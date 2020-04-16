<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries\Fields;
use Illuminate\Http\Request;
use Leizhishang\Lzscms\Model\CommonFieldsModel;

class Redirect extends FieldAbs {
	
	/**
     * 构造函数 转向链接 **
     */
    public function __construct() 
    {
		parent::__construct();
		$this->name = lzs_lang('lzscms::fields.redirect'); // 字段名称
		$this->fieldtype = [
			'VARCHAR'=>''
		]; // TRUE表全部可用字段类型,自定义格式为 array('可用字段类型名称' => '默认长度', ... )
		$this->defaulttype = 'VARCHAR'; // 当用户没有选择字段类型时的缺省值
    }
	
	/**
	 * 字段相关属性参数
	 *
	 * @param	array	$value	值
	 * @return  string
	 */
	public function option($option)
	{
		$option['width'] = isset($option['width']) ? $option['width'] : 400;
		$option['value'] = isset($option['value']) ? $option['value'] : '';
		$option['fvalue'] = isset($option['fvalue']) ? $option['fvalue'] : '';
		$option['fieldtype'] = isset($option['fieldtype']) ? $option['fieldtype'] : 'VARCHAR';
		$option['fieldlength'] = isset($option['fieldlength']) ? $option['fieldlength'] : '';
		return '
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.lzs_lang('lzscms::public.width').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="setting[option][width]" value="'.$option['width'].'" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="'.lzs_lang('lzscms::manage.fields.type.width.tips').'">'.lzs_lang('lzscms::manage.fields.type.width.tips').'</div>
	          </div>
	        </div>
                '.$this->get_default_value($option['value']).$this->field_type($option['fieldtype'], $option['fieldlength'], $option['fvalue']);
	}
	
	/**
	 * 字段表单输入
	 *
	 * @param	string	$cname	字段别名
	 * @param	string	$name	字段名称
	 * @param	array	$cfg	字段配置
	 * @param	array	$value	值
	 * @param	array	$id		当前内容表的id（表示非发布操作）
	 * @return  string
	 */
	public function input($cname, $name, $cfg, $value = NULL, $id = 0) 
	{
		$cfg['option']['value'] = isset($cfg['option']['value']) ? $cfg['option']['value'] : "";
		// 字段显示名称
		$text = (isset($cfg['validate']['required']) && $cfg['validate']['required'] == 1 ? '<font color="red">*</font>&nbsp;' : '').$cname;
		// 表单宽度设置
		$width = 'style="width:'.(isset($cfg['option']['width']) && $cfg['option']['width'] ? $cfg['option']['width'] : '200').'px;"';
		// 表单附加参数
		$attr = isset($cfg['validate']['formattr']) && $cfg['validate']['formattr'] ? $cfg['validate']['formattr'] : '';
		// 字段提示信息
		$tips = isset($cfg['validate']['tips']) && $cfg['validate']['tips'] ? $cfg['validate']['tips']: '';
		// 字段默认值
		$value = $value ? $value : '';
		// 禁止修改
		if (!$this->isadmin && $id && $value  && isset($cfg['validate']['isedit']) && $cfg['validate']['isedit']) {
            $attr.= ' disabled';
        }
		// 当字段必填时，加入html5验证标签
		if (isset($cfg['validate']['required']) && $cfg['validate']['required'] == 1) {
            $attr.= ' required="required"';
        }
		$str = '<input placeholder="http://" class="hstui-input" type="text" name="'.$name.'" id="Lzscms_'.$name.'" value="'.$value.'" '.$width.' '.$attr.' />';
		return $this->input_format($name, $text, $str, $tips);
	}
	
    /**
     * 处理输入数据，提供给入库
     */
	public function insert_value(Request $request, $field, $postData = [])
	{
		$value = $request->get($field['fieldname']);
		if ($value) {
			$value = stripos($value, 'http://') != 0 || stripos($value, 'ftp://') != 0 || stripos($value, 'https://') != 0 ? 'http://'.$value : $value;
		}
		$postData[$field['relatedtable']] = [
			$field['fieldname']=>trim($value)
		];
    	return $postData;
    }
}