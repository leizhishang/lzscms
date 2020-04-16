<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries;

use Leizhishang\Lzscms\Model\AttachmentModel;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;

/**
* 
*/
class LzscmsFields
{
	public $objects = [];
    public $isadmin = false;

	/**
	 * 获取字段类别对象 **
	 *
	 * @param   string $name    字段类别名称
	 * @param   string	$module	模块名称
	 * @return  object
	 */
    public function get($name)
    {
        if (!$name || strpos($name, '.') !== FALSE) {
            return NULL;
        }
		$class = ucfirst($name);
		$files = 'Leizhishang\Lzscms\Libraries\Fields';
		$fieldClass = $this->field_class($files, $class);
		if(!class_exists($fieldClass)) {
            return NULL;
		}
		if (isset($this->objects[$class])) {
			return $this->objects[$class];
		} else {
			return $this->objects[$class] = new $fieldClass();
		}
	}

	/**
	 * 自定义字段选项信息 
	 *
	 * @param   string	$name	字段类别名称
	 * @param   array 	$option	选项值
	 * @return  string
	 */
	public function option($name, $option = NULL, $fields = [])
	{
		return $name ? $this->get($name)->option($option, $fields) : NULL;
	}
	
	
	/**
	 * 获取可用字段类别 **
	 *
	 * @return  array
	 */
	public function type()
	{
		$file = new Filesystem();
        $path    = realpath(__DIR__.'/../Libraries/Fields');
        $fields = $file->glob($path.'/*.php');
		$data = [];
        if($fields) {
        	foreach ($fields as $key => $value) {
				$name = substr(basename($value), 0, -4);
				if($name != 'FieldAbs') {
					$obj = $this->get($name);
					$data[] = array('id' => $name, 'name' => $obj->name);
				}
        	}
        }
		return $data;
	}
    
    /**
     * Return the full path to the given  class.
     *
     * @param  string  $class
     * @return string
     */
    protected function field_class($namespace, $class)
    {
        return "{$namespace}\\{$class}";
    }

    public function input_html($fields = [], $data = NULL, $cat = FALSE, $id = 0)
    {
        $group = [];
        $myfield = $mygroup = $mycat = $mark = '';
        if ($cat == TRUE) {
            $mycat = '<div id="Lzscms_category_field"></div>';
        }
        if (!$fields) {
            return $mycat;
        }
        // 分组字段筛选
        foreach ($fields as $t) {
            if ($t['fieldtype'] == 'Group'
                && preg_match_all('/\{(.+)\}/U', $t['setting']['option']['value'], $value)) {
                foreach ($value[1] as $v) {
                    $group[$v] = $t['fieldname'];
                }
            }
        }
        foreach ($fields as $t) {
            if(!$this->isadmin && isset($t['setting']['option']['isfrontshow']) && !$t['setting']['option']['isfrontshow']) {
                continue;
            }
            $obj = $this->get($t['fieldtype']);
            if (is_object($obj)) {
                $obj->isadmin = $this->isadmin;
                $data = $obj->output_data($data, $t);
                // 百度地图特殊字段
                $value = isset($data[$t['fieldname']]) ? $data[$t['fieldname']] : '';
                if (isset($group[$t['fieldname']])) {
                    $obj->format = '{value}';
                    $input = $obj->input($t['name'], $t['fieldname'], $t['setting'], $value, isset($data[$id]) ? $data[$id] : 0);
                    $mygroup[$t['fieldname']] = $input;
                } else {
                    $input = $obj->input($t['name'], $t['fieldname'], $t['setting'], $value, isset($data[$id]) ? $data[$id] : 0);
                    // 将栏目附加字段放在内容或者作者上面一行
                    if ($cat == TRUE && $mark == '' && in_array($t['fieldname'], ['content', 'hits'])) {
                        $mark = 1;
                        $myfield .= $mycat;
                    }
                    $myfield .= $input;
                }
            }
        }
        if ($cat == TRUE && $mark == '') {
            $myfield .= $mycat;
        }
        if ($mygroup) {
            foreach ($mygroup as $name => $t) {
                $myfield = str_replace('{' . $name . '}', $t, $myfield);
            }
        }
        return $myfield;
    }

    /**
     * 表单提交数据验证和过滤
     *
     * @param   array   $request  	Request
     * @param   array   $_field 字段
     * @param   array   $_data  修改前的数据
     * @return  array
     */
    public function validate_filter(Request $request, $_fields, $_data = [])
    {
    	$postData = [];
    	$error = [];
        $requestAll = $request->all();
        foreach ($_fields as $field) {
            if(!$this->isadmin && isset($field['setting']['option']['isfrontshow']) && !$field['setting']['option']['isfrontshow']) {
                continue;
            }
            $obj = $this->get($field['fieldtype']);
            if (!$obj) {
                continue;
            }
            if ($field['fieldtype'] === 'Group') {
                continue;
            }
            $obj->isadmin = $this->isadmin;
            $field['setting']['option']['fieldtype'] = isset($field['setting']['option']['fieldtype']) ? $field['setting']['option']['fieldtype'] : '';
            $validate = isset($field['setting']['validate']) ? $field['setting']['validate'] : ['required'=>0];
            if (!$this->isadmin && $validate['isedit']) {
                continue;
            }
            // 验证字段
            $error = $obj->validate_filter($request, $field, $validate, $error);
            // 获取入库值
            $data = $obj->insert_value($request, $field, []);
            if($postData) {
                $postData[$field['relatedtable']] = array_merge($postData[$field['relatedtable']], $data[$field['relatedtable']]);
            } else {
                $postData = $data;
            }
        }
        if($error) {
        	return ['status'=>'error', 'error'=>$error];
        }
        return ['status'=>'success', 'data'=>$postData];
    }

     /**
     * 字段输出格式化
     *
     * @param   array   $fields     可用字段集
     * @param   array   $data       数据
     * @return  string
     */
    public function field_format_value($fields, $data) 
    {
        if (!$fields || !$data || !is_array($data)) {
            return $data;
        }
        foreach ($fields as $field) {
            $obj = $this->get($field['fieldtype']);
            if (!$obj) {
                continue;
            }
            if ($field['fieldtype'] === 'Group') {
                continue;
            }
            $data = $obj->output_data($data, $field);
        }
        return $data;
    }

    //附件处理
    public function saveAttach($appid, Request $request, $fields = []) 
    {
        foreach ($fields as $field) {
           if($field['fieldtype'] === 'File') {
                $v = $request->get($field['fieldname']);
                if($v) {
                    AttachmentModel::where('aid', $v['aid'])->update([
                        'app_id'=>$appid,
                        'descrip'=>(string)$v['descrip']
                    ]);
                }
           } else if($field['fieldtype'] === 'Files') {
                $v = $request->get($field['fieldname']);
                if($v) {
                    foreach ($v['aid'] as $k => $aid) {
                        AttachmentModel::where('aid', $aid)->update([
                            'app_id'=>$appid,
                            'descrip'=>(string)$v['descrip'][$k]
                        ]);
                    }
                }
                
           }
        }
        return true;
    }



}