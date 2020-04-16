<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries\Fields;
use Illuminate\Http\Request;
use Leizhishang\Lzscms\Model\CommonFieldsModel;

class Group extends FieldAbs {
	
	/**
     * 构造函数 分组字段 **
     */
    public function __construct() {
		parent::__construct();
		$this->name = lzs_lang('lzscms::fields.group'); // 字段名称
		$this->fieldtype = ''; // TRUE表全部可用字段类型,自定义格式为 array('可用字段类型名称' => '默认长度', ... )
		$this->defaulttype = ''; // 当用户没有选择字段类型时的缺省值
    }
	
	/**
	 * 字段相关属性参数
	 *
	 * @param	array	$value	值
	 * @param	array	$field	字段集合
	 * @return  string
	 */
	public function option($option, $field = NULL) 
	{
		$group = [];
		$option['value'] = isset($option['value']) && $option['value'] ? $option['value'] : '';
		if ($field) {
			foreach ($field as $t) {
				if ($t['fieldtype'] == 'Group') {
					$t['setting'] = lzs_str2array($t['setting']);
					if (preg_match_all('/\{(.+)\}/U', $t['setting']['option']['value'], $value)) {
						foreach ($value[1] as $v) {
							$group[] = $v;
						}
					}
				}
			}
			$_field = [];
			$_field[] = '<option value=""> -- </option>';
			foreach ($field as $t) {
				if ($t['fieldtype'] != 'Group' && !@in_array($t['fieldname'], $group)) {
					$_field[] = '<option value="'.$t['fieldname'].'">'.$t['name'].'</option>';
				}
			}
			$_field = @implode('', @array_unique($_field));
		}
		return '
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.lzs_lang('lzscms::fields.group.field').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	            <select class="hstui-input hstui-select" name="xx" id="fxx" >'.$_field.'</select>
	            <div class="hstui-form-input-tips" id="J_form_tips_name">'.lzs_lang('lzscms::fields.group.field.tips').'</div>
	          </div>
	        </div>
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.lzs_lang('lzscms::fields.group.rule').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	            <textarea name="setting[option][value]" id="fvalue" style="width:520px;height:120px;" class="hstui-input hstui-textarea">'.$option['value'].'</textarea>
	            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="'.lzs_lang('lzscms::fields.group.rule.tips').'">'.lzs_lang('lzscms::fields.group.rule.tips').'</div>
	          </div>
	        </div>
				<script type="text/javascript">
				Hstui.use(\'jquery\',function() {
					$("#fxx").change(function(){
						var value = $(this).val();
						var fvalue = $("#fvalue").val();
						var text = $("#fxx").find("option:selected").text();
						$("#fxx option[value=\'"+value+"\']").remove();
						$("#fvalue").val(fvalue+" "+text+": {"+value+"}");
					});
				});
				</script>';
	}
	
	/**
	 * 字段表单输入
	 *
	 * @param	string	$cname	字段别名
	 * @param	string	$name	字段名称
	 * @param	array	$cfg	字段配置
	 * @param	array	$data	值
	 * @return  string
	 */
	public function input($cname, $name, $cfg, $value = NULL, $id = 0) 
	{
		// 字段显示名称
		$text = (isset($cfg['validate']['required']) && $cfg['validate']['required'] == 1 ? '<font color="red">*</font>' : '').'&nbsp;'.$cname.'：';
		// 字段提示信息
		$tips = isset($cfg['validate']['tips']) && $cfg['validate']['tips'] ? $cfg['validate']['tips']: '';
		// 字段默认值
		$value = isset($cfg['option']['value']) ? $cfg['option']['value'] : "";
		// 当字段必填时，加入html5验证标签
		if (isset($cfg['validate']['required'])  && $cfg['validate']['required'] == 1) {
            $attr.= ' required="required"';
        }
		return $this->input_format($name, $text, $value, $tips);
	}
	
}