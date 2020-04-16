<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries\Fields;

use Illuminate\Http\Request;
use Leizhishang\Lzscms\Model\CommonFieldsModel;

abstract class FieldAbs  {

	public $isadmin;
	public $name; // 字段类别的名字
	protected $fieldtype; // 可用字段类型
	protected $defaulttype;	// 默认字段类型
	protected $fields = array(
		'INT' => 10,
		'TINYINT' => 3,
		'SMALLINT' => 5,
		'MEDIUMINT' => 8,
		'DECIMAL' => '10,2',
		'FLOAT' => '8,2',
		'CHAR' => 100,
		'VARCHAR' => 255,
		'TEXT' => '',
		'MEDIUMTEXT' => ''
	);	// 内置可用字段及默认长度

	public $format = '<div class="hstui-form-group hstui-form-group-sm" id="J_form_error_{name}">
          <label class="hstui-u-sm-2 hstui-form-label">{text}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              {value}<div class="hstui-form-input-tips" id="J_form_tips_{name}" data-tips="{tips}">{tips}</div>
          </div>
        </div>{formattr}'; // 格式化字段输入表单
	
	/**
     * 构造函数
     */
    public function __construct() {}

	/**
	 * 字段相关属性参数
	 *
	 * @param	array	$option
	 * @return  string
	 */
	abstract public function option($option);

	public function createSql($data)
	{
        return CommonFieldsModel::createSql($data);
	}

	public function deleteSql($data)
	{
        return CommonFieldsModel::deleteSql($data);
	}
	
	/**
	 * 字段表单输入样式
	 *
	 * @param	string	$cname	字段别名
	 * @param	string	$name	字段名称
	 * @param	array	$option	字段配置
	 * @param	array	$value	值
	 * @param	array	$id		当前内容表的id
	 * @return  string
	 */
	abstract function input($cname, $name, $option, $value = NULL, $id = 0);
	
	/**
	 * 验证字段输入
	 */
	public function validate_filter(Request $request, $field, $validate, $error = []) 
	{
        $fieldname = $field['fieldname'];
		$value = $request->get($fieldname);
        if($field['fieldtype'] == 'Date' || $field['fieldtype'] == 'DateTime') {
            $value = lzs_str2time($value);
        }
        // 验证必填字段
		if ($field['fieldtype'] != 'Group' && isset($validate['required']) && $validate['required']) {
			if ($value == '') {
                if(isset($validate['kongzhitips']) && $validate['kongzhitips']) {
                    $error[$fieldname] = [$validate['kongzhitips']];
                } else {
                    $error[$fieldname] = [lzs_buildContent('Lzscms::fields.post.content.kongzhi', ['name'=>$field['name']])];
                }
            } else {
                // 正则验证
                if (isset($validate['pattern']) && $validate['pattern'] && !preg_match($validate['pattern'], $value)) {
                    if(isset($validate['errortips']) && $validate['errortips']) {
                        $error[$fieldname] = [$validate['errortips']];
                    } else {
                        $error[$fieldname] = [lzs_buildContent('Lzscms::fields.post.content.error', ['name'=>$field['name']])];
                    }
                }
            }
		}
        // 判断表字段值的唯一性
        if ($field['ismain'] && isset($field['setting']['option']['unique']) && $field['setting']['option']['unique']) 
        {
        }
		return $error;
	}

	/**
	 * 处理输入数据，提供给入库
	 */
	public function insert_value(Request $request, $field, $postData = [])
	{
        $fieldname = $field['fieldname'];
		$value = $request->get($fieldname);
        if($field['fieldtype'] == 'Date' || $field['fieldtype'] == 'DateTime') {
            $value = (int)lzs_str2time($value);
        }
        if (strpos($field['setting']['option']['fieldtype'], 'INT') !== FALSE) {
            $postData[$field['relatedtable']][$fieldname] = (int)$value;
        } elseif ($field['setting']['option']['fieldtype'] == 'DECIMAL' || $field['setting']['option']['fieldtype'] == 'FLOAT') {
            $postData[$field['relatedtable']][$fieldname] = (double)$value;
        } else {
            $postData[$field['relatedtable']][$fieldname] = $value ? $value : '';
        }
        return $postData;
	}

	/**
	 * 处理输出数据
	 *
	 */
	public function output_data($data, $field)
	{
		return $data;		
	}
	
	public function get_columnAttribute($option) 
	{
		$columnAttribute = [];
		$fieldtype = $this->fieldtype === TRUE ? $this->fields : $this->fieldtype; // 可用字段类型
		if(isset($option['fieldtype']) && isset($fieldtype[$option['fieldtype']]) ) {
			$columnAttribute['type'] = $option['fieldtype']; // 字段类型
		} else {
			$columnAttribute['type'] = $this->defaulttype; // 字段类型
		}
		$option['fieldlength'] = isset($option['fieldlength']) && $option['fieldlength'] ? $option['fieldlength'] : $fieldtype[$columnAttribute['type']]; // 字段长度
		$fieldlength = explode(',', $option['fieldlength']);
		$columnAttribute['length1'] = $fieldlength[0];
		$columnAttribute['length2'] = isset($fieldlength[1]) && $fieldlength[1] ? $fieldlength[1] : 0;
			
		if(isset($option['fvalue']) && $option['fvalue'] === 'NULL' ) {
			$columnAttribute['defaultValueType'] = 'NULL';
			$columnAttribute['defaultValue'] = '';
		} else {
			if($columnAttribute['type'] == 'INT' || $columnAttribute['type'] == 'TINYINT') {
				$option['fvalue'] = (int)$option['fvalue'];
			}
			$columnAttribute['defaultValue'] = $option['fvalue'];
			$columnAttribute['defaultValueType'] = 'other';
			if($columnAttribute['type'] == 'TEXT') {
				$columnAttribute['defaultValue'] = '';
				$columnAttribute['defaultValueType'] = '';
			}
			if($columnAttribute['type'] == 'CHAR' || $columnAttribute['type'] == 'VARCHAR') {
				$columnAttribute['defaultValue'] = '';
				$columnAttribute['defaultValueType'] = 'other';
			}
			if($columnAttribute['type'] == 'DECIMAL' || $columnAttribute['type'] == 'FLOAT') {
				$columnAttribute['defaultValue'] = '0';
				$columnAttribute['defaultValueType'] = 'other';
			}
		}
		return $columnAttribute;
	}

	public function get_default_value($value) 
	{
		return '
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.lzs_lang('lzscms::public.default.value').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="setting[option][value]" value="'.$value.'" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="'.lzs_lang('lzscms::manage.fields.default.value.001.tips').'">'.lzs_lang('lzscms::manage.fields.default.value.001.tips').'</div>
	          </div>
	        </div>';
	}
	
	/**
	 * 字段类型选择
	 *
	 * @param	string	$name
	 * @param	string	$length
	 * @return  string
	 */
	public function field_type($name = NULL, $length = NULL, $fvalue = '')
	{
		if ($this->fieldtype === TRUE) {
			$select	= '<option value="">-</option>
				<option value="INT" '.($name == 'INT' ? 'selected' : '').'>INT</option>
				<option value="TINYINT" '.($name == 'TINYINT' ? 'selected' : '').'>TINYINT</option>
				<option value="SMALLINT" '.($name == 'SMALLINT' ? 'selected' : '').'>SMALLINT</option>
				<option value="MEDIUMINT" '.($name == 'MEDIUMINT' ? 'selected' : '').'>MEDIUMINT</option>
				<option value="">-</option>
				<option value="DECIMAL" '.($name == 'DECIMAL' ? 'selected' : '').'>DECIMAL</option>
				<option value="FLOAT" '.($name == 'FLOAT' ? 'selected' : '').'>FLOAT</option>
				<option value="">-</option>
				<option value="CHAR" '.($name == 'CHAR' ? 'selected' : '').'>CHAR</option>
				<option value="VARCHAR" '.($name == 'VARCHAR' ? 'selected' : '').'>VARCHAR</option>
				<option value="TEXT" '.($name == 'TEXT' ? 'selected' : '').'>TEXT</option>
				<option value="MEDIUMTEXT" '.($name == 'MEDIUMTEXT' ? 'selected' : '').'>MEDIUMTEXT</option>';
		} elseif (count($this->fieldtype) > 1) {
			$select	= '<option value="">-</option>';
			foreach ($this->fieldtype as $t) {
				$select	= "<option value=\"{$t}\" ".($name == $t ? "selected" : "").">{$t}</option>";
			}
		} else {
			return '
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.lzs_lang('lzscms::fields.default.value').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="setting[option][fvalue]" value="'.$fvalue.'" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="'.lzs_lang('lzscms::fields.default.value.tips').'">'.lzs_lang('lzscms::fields.default.value.tips').'</div>
	          </div>
	        </div>';
		}
		$str = '
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.lzs_lang('lzscms::manage.fields.fieldtype').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	             	<select class="hstui-input hstui-textarea" name="setting[option][fieldtype]" onChange="setlength()" id="type">
						'.$select.'
					</select>
	            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="'.lzs_lang('lzscms::manage.fields.fieldtype.tips').'">'.lzs_lang('lzscms::manage.fields.fieldtype.tips').'</div>
	          </div>
	        </div>
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.lzs_lang('lzscms::manage.fields.length.value').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="setting[option][fieldlength]" value="'.$length.'" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="'.lzs_lang('lzscms::manage.fields.length.value.tips').'">'.lzs_lang('lzscms::manage.fields.length.value.tips').'</div>
	          </div>
	        </div>
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.lzs_lang('lzscms::fields.default.value').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="setting[option][fvalue]" value="'.$fvalue.'" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="'.lzs_lang('lzscms::fields.default.value.tips').'">'.lzs_lang('lzscms::fields.default.value.tips').'</div>
	          </div>
	        </div>';
		return $str; 
	}
	
	/**
	 * 表单输入格式
	 *
	 * @param	string	$name	字段名称
	 * @param	string	$text	字段别名
	 * @param	string	$value	表单输入内容
	 * @return  string
	 */
	public function input_format($name, $text, $value, $tips, $formattr = '')
	{
		return str_replace(['{name}', '{text}', '{value}', '{tips}', '{formattr}'], [$name, $text, $value, $tips, $formattr], $this->format);
	}
}