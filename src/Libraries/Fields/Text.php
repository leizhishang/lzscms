<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries\Fields;
use Illuminate\Http\Request;
use Leizhishang\Lzscms\Model\CommonFieldsModel;

class Text extends FieldAbs {
	
	/**
     * 构造函数 单行文本 **
     */
    public function __construct() 
    {
		parent::__construct();
		$this->name = lzs_lang('lzscms::fields.text'); // 字段名称
		$this->fieldtype = TRUE; // TRUE表全部可用字段类型,自定义格式为 array('可用字段类型名称' => '默认长度', ... )
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
        $option['value'] = isset($option['value']) ? $option['value'] : '';
        $option['fvalue'] = isset($option['fvalue']) ? $option['fvalue'] : '';
		$option['width'] = isset($option['width']) ? $option['width'] : 200;
        $option['ispass'] = isset($option['ispass']) ? $option['ispass'] : 0;
		$option['fieldtype'] = isset($option['fieldtype']) ? $option['fieldtype'] : '';
		$option['fieldlength'] = isset($option['fieldlength']) ? $option['fieldlength'] : '';
		return '
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.lzs_lang('lzscms::public.width').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="setting[option][width]" value="'.$option['width'].'" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="'.lzs_lang('lzscms::manage.fields.type.width.tips').'">'.lzs_lang('lzscms::manage.fields.type.width.tips').'</div>
	          </div>
	        </div>
	        <div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.lzs_lang('lzscms::manage.fields.ispass').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
                    <input type="radio" value="0" name="setting[option][ispass]" '.($option['ispass'] == 0 ? 'checked' : '').' >&nbsp;<label>'.lzs_lang('lzscms::public.no').'</label>&nbsp;&nbsp;
                    <input type="radio" value="1" name="setting[option][ispass]" '.($option['ispass'] == 1 ? 'checked' : '').' >&nbsp;<label>'.lzs_lang('lzscms::public.yes').'</label>&nbsp;&nbsp;
	            <div class="hstui-form-input-tips" data-tips="'.lzs_lang('lzscms::manage.fields.ispass.tips').'">'.lzs_lang('lzscms::manage.fields.ispass.tips').'</div>
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
		$cfg['validate']['tips'] = isset($cfg['validate']['tips']) ? $cfg['validate']['tips'] : "";
		$text = (isset($cfg['validate']['required']) && $cfg['validate']['required'] == 1 ? '<font color="red">*</font>' : '').$cname;
		// 表单附加参数
		$attr = isset($cfg['validate']['formattr']) && $cfg['validate']['formattr'] ? $cfg['validate']['formattr'] : '';
		// 表单宽度设置
		$width = isset($cfg['option']['width']) && $cfg['option']['width'] ? $cfg['option']['width'] : '200';
		$ispass = isset($cfg['option']['ispass']) && $cfg['option']['ispass'] ? $cfg['option']['ispass'] : 0;
		$width = 'style="width:'.$width.(is_numeric($width) ? 'px' : '').';"';
		// 字段提示信息
		$tips = ($name == 'title') || (isset($cfg['validate']['tips']) && $cfg['validate']['tips']) ? ''.$cfg['validate']['tips'].'' : '';
		// 字段默认值
		if(!$value) {
			$value = isset($cfg['option']['value']) && $cfg['option']['value'] ? htmlspecialchars_decode($cfg['option']['value']) : "";
		} else {
			$value = isset($value) && $value ? htmlspecialchars_decode($value) : "";
		}
		//修改
		$disabled = !$this->isadmin && $id && $value && isset($cfg['validate']['isedit']) && !$cfg['validate']['isedit'] ? ' disabled' : ' ';
		$_type = $ispass ? 'password' : 'text';
		// 当字段必填时，加入html5验证标签
		$required = isset($cfg['validate']['required']) && $cfg['validate']['required'] == 1 ? ' required="required"' : '';
		return $this->input_format($name, $text, '<input class="hstui-input" type="'.$_type.'" name="'.$name.'" id="Lzscms_'.$name.'" value="'.$value.'" '.$width . $disabled . $required . $attr .' >', $tips);
	}

    /**
     * 处理输入数据，提供给入库
     */
	public function insert_value(Request $request, $field, $postData = [])
	{
		$value = $request->get($field['fieldname']);
		$postData[$field['relatedtable']] = [
			$field['fieldname']=>htmlspecialchars($value)
		];
    	return $postData;
    }
}