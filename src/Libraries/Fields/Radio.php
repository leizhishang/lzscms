<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries\Fields;
use Illuminate\Http\Request;
use Leizhishang\Lzscms\Model\CommonFieldsModel;

class Radio extends FieldAbs {
	
	/**
     * 单选 **
     */
    public function __construct() 
    {
		parent::__construct();
		$this->name = lzs_lang('lzscms::fields.radio'); // 字段名称
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
		$option['list'] = isset($option['list']) ? $option['list'] : 'name1|value1'.PHP_EOL.'name2|value2';
		$option['value'] = isset($option['value']) ? $option['value'] : '';
		$option['fvalue'] = isset($option['fvalue']) ? $option['fvalue'] : '';
		$option['fieldtype'] = isset($option['fieldtype']) ? $option['fieldtype'] : 'VARCHAR';
		$option['fieldlength'] = isset($option['fieldlength']) ? $option['fieldlength'] : '';
		return '
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.lzs_lang('lzscms::fields.select.list').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
                    <textarea name="setting[option][list]" class="hstui-input hstui-textarea" style="height:100px;width:400px;">'.$option['list'].'</textarea>
	            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="'.lzs_lang('lzscms::fields.select.list.tips').'">'.lzs_lang('lzscms::fields.select.list.tips').'</div>
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
	 * @param	string	$value	值
	 * @return  string
	 */
	public function input($cname, $name, $cfg, $value = NULL, $id = 0) 
	{
		$cfg['option']['value'] = isset($cfg['option']['value']) ? $cfg['option']['value'] : "";
		// 字段显示名称
		$text = (isset($cfg['validate']['required']) && $cfg['validate']['required'] == 1 ? '<font color="red">*</font>&nbsp;' : '').$cname;
		// 表单附加参数
		$attr = isset($cfg['validate']['formattr']) && $cfg['validate']['formattr'] ? $cfg['validate']['formattr'] : '';
		// 字段提示信息
		$tips = isset($cfg['validate']['tips']) && $cfg['validate']['tips'] ? $cfg['validate']['tips']: '';
		// 字段默认值
		$value = $value ? $value : $cfg['option']['value'];
        $str = '';
		// 表单选项
		$options = isset($cfg['option']['list']) && $cfg['option']['list'] ? $cfg['option']['list'] : '';// 禁止修改
		$disabled = !$this->isadmin && $id && $value && isset($cfg['validate']['isedit']) && $cfg['validate']['isedit'] ? 'disabled' : '';
		if ($options) {
			$options = explode(PHP_EOL, str_replace(array(chr(13), chr(10)), PHP_EOL, $options));
			$_i = 0;
			foreach ($options as $t) {
				if ($t) {
					$_i++;
					$n = $v = $selected = '';
					list($n, $v) = explode('|', $t);
					$v = $v === NULL ? trim($n) : trim($v);
					$selected = $v == $value ? ' checked' : '';
					if(!$selected && $_i == 1){
						$selected = 'checked';
					}
					$str.= '<input '.$disabled.' type="radio" name="'.$name.'" value="'.$v.'" '.$selected.' '.$attr.' />&nbsp;<label>'.$n.'</label>&nbsp;&nbsp;&nbsp;&nbsp;';
				}
			}
		}
		return $this->input_format($name, $text, $str, $tips);
	}
	
	/**
	 * 字段输出
	 */
	public function output_data($data, $field = []) 
	{
		if(!isset($data[$field['fieldname']])) {
			return $data;
		}
		$value = $data[$field['fieldname']];
		$data['_'.$field['fieldname']] = $value;
		if(!$value) {
			return $data;
		}
		$cfg = $field['setting']['option'];
		$options = @explode(PHP_EOL, str_replace(array(chr(13), chr(10)), PHP_EOL, $cfg['list']));
		$_options = array();
		foreach ($options as $key => $val) {
			$_value = @explode('|', $val);
			$_options[$_value[1]] = isset($_value[0]) ? $_value[0] : '';
		}
		$data[$field['fieldname']] = $_options[$value];
		return $data;
	}
}