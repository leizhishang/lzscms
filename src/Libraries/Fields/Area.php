<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries\Fields;
use Illuminate\Http\Request;
use Leizhishang\Lzscms\Model\CommonFieldsModel;
use Leizhishang\Lzscms\Model\CommonAreaModel;

class Area extends FieldAbs 
{
	/**
     * 构造函数 **
     */
    public function __construct()
    {
		parent::__construct();
		$this->name = lzs_lang('lzscms::fields.area').lzs_lang('lzscms::fields.area.mode.003'); // 字段名称
		$this->fieldtype = [
			'INT' => '11'
		]; // TRUE表全部可用字段类型,自定义格式为 array('可用字段类型名称' => '默认长度', ... )
		$this->defaulttype = 'INT'; // 当用户没有选择字段类型时的缺省值
    }
	
	/**
	 * 字段相关属性参数
	 *
	 * @param	array	$value	值
	 * @return  string
	 */
	public function option($option) 
	{
		$option['areaid1'] = isset($option['areaid1']) ? $option['areaid1'] : 0;
		$option['areaid2'] = isset($option['areaid2']) ? $option['areaid2'] : 0;
		$option['areaid3'] = isset($option['areaid3']) ? $option['areaid3'] : 0;

		$option['value'] = isset($option['value']) ? $option['value'] : '';
		$option['fvalue'] = isset($option['fvalue']) ? $option['fvalue'] : '';
		$option['fieldtype'] = isset($option['fieldtype']) ? $option['fieldtype'] : "VARCHAR";
		$option['fieldlength'] = isset($option['fieldlength']) ? $option['fieldlength'] : "255";
		$areaid1 = '';
		$areaList = CommonAreaModel::getSubByAreaid(0, false);
		foreach ($areaList as $key => $value) {
			$areaid1 .= '<option value="'.$value['areaid'].'" '.lzs_isSelected($value['areaid'] == $option['areaid1']).'>'.$value['name'].'</option>';
		}
		return '
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.lzs_lang('lzscms::public.default.value').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	            <select name="setting[option][areaid1]" class="hstui-input hstui-select J_areaAjax" data-toid="Lzscms_areaid2" id="Lzscms_areaid1" data-area="1" data-tips="请选择省份">
					<option value="">请选择省份</option>
					'.$areaid1.'
	            </select>
	            <select name="setting[option][areaid2]" class="hstui-input hstui-select J_areaAjax" data-toid="Lzscms_areaid3" id="Lzscms_areaid2" data-area="2" data-tips="请选择城市">
					<option value="">请选择城市</option>
	            </select>
	            <select name="setting[option][areaid3]" class="hstui-input hstui-select" data-area="3" id="Lzscms_areaid3" data-tips="请选择县(区)">
					<option value="">请选择县(区)</option>
	            </select>
	            <div class="hstui-form-input-tips" id="J_form_tips_mode" data-tips=""></div>
	          </div>
	        </div>

            <script>
            var areaid1 = '.$option['areaid1'].';
            var areaid2 = '.$option['areaid2'].';
            var areaid3 = '.$option['areaid3'].';
                Hstui.use(\'jquery\',function() {
                	function setArea(areaid, toid, area, id) {
						var url = \''.route('publicAreaList').'\';
						var tips = $(\'#\'+toid).data(\'tips\');
						if(typeof(toid) !== \'undefined\') {
							 var option = \'<option value="">\'+tips+\'</option>\';
							$.get(url + \'?areaid=\'+areaid,function(data, status){
							    if(data.length) {
							    	var selected = \'\';
							    	for (var i=0; i < data.length; i++) {
							    		selected = \'\';
							    		if(id == data[i].areaid) {
							    			selected = \'selected\';
							    		}
							    		option +=\'<option \'+selected+\' value="\'+data[i].areaid+\'">\'+data[i].name+\'</option>\';
							    	}
							    }
							    $(\'#\'+toid).html(option);
							}, \'json\');
						}
                	}
                	if(areaid1) {
                		setArea(areaid1, \'lzscms_areaid2\', 1, areaid2);
                	}
                	if(areaid2) {
                		setArea(areaid2, \'lzscms_areaid3\', 2, areaid3);
                	}
					$(".J_areaAjax").on(\'change\',function() {
						var _this=$(this),val=_this.val(),toid=_this.data(\'toid\'),area=_this.data(\'area\');
						setArea(val, toid, area);
						if(area == 1) {
                			setArea(0, \'lzscms_areaid3\');
						}
					});
                });
            </script>
				'.$this->field_type($option['fieldtype'], $option['fieldlength'], $option['fvalue']);
	}

	public function createSql($data)
	{
		$postData = $data;
        $postData['fieldname'] = $data['fieldname'].'1';
        CommonFieldsModel::createSql($postData);
        $postData['fieldname'] = $data['fieldname'].'2';
        CommonFieldsModel::createSql($postData);
        $postData['fieldname'] = $data['fieldname'].'3';
        CommonFieldsModel::createSql($postData);
	}

	public function deleteSql($data)
	{
		$datas = $data;
        $datas['fieldname'] = $data['fieldname'].'1';
        CommonFieldsModel::deleteSql($datas);
        $datas['fieldname'] = $data['fieldname'].'2';
        CommonFieldsModel::deleteSql($datas);
        $datas['fieldname'] = $data['fieldname'].'3';
        CommonFieldsModel::deleteSql($datas);
        return true;
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
		$areaid1 = isset($cfg['option']['areaid1']) ? $cfg['option']['areaid1'] : '';
		$areaid2 = isset($cfg['option']['areaid2']) ? $cfg['option']['areaid2'] : '';
		$areaid3 = isset($cfg['option']['areaid3']) ? $cfg['option']['areaid3'] : '';

		// 字段显示名称
		$text = (isset($cfg['validate']['required']) && $cfg['validate']['required'] == 1 ? '<font color="red">*</font> ' : '').$cname.'';
		// 表单附加参数
		$attr = '';
		// 字段提示信息
		$tips = isset($cfg['validate']['tips']) && $cfg['validate']['tips'] ? $cfg['validate']['tips'] : '';
		// 字段默认值
		$vInfo = [
			'joinids'=>[0,0,0]
		];
		if (!$value && $areaid3) {
			$vInfo = CommonAreaModel::getInfoByAreaid($areaid3, false);
		} else if (!$value && $areaid1 && $areaid2 && !$areaid3) {
			$vInfo = [
				'joinids'=>[$areaid1, $areaid2, 0]
			];
		} else if (!$value && $areaid1 && !$areaid2 && !$areaid3) {
			$vInfo = [
				'joinids'=>[$areaid1, 0, 0]
			];
		} else {
			if($value) {
				$vInfo = $value;
			}
		}
		$show =  '';
		$disabled = !$this->isadmin &&  $id && $value && isset($cfg['validate']['isedit']) && !$cfg['validate']['isedit'] ? ' disabled' : ' ';
		$required = isset($cfg['validate']['required']) && $cfg['validate']['required'] == 1 ? ' required="required"' : '';
		$str = '';
		$option1 = '';
		$areaList = CommonAreaModel::getSubByAreaid(0, false);
		foreach ($areaList as $key => $value) {
			$option1 .= '<option value="'.$value['areaid'].'" '.lzs_isSelected($vInfo && $value['areaid'] == $vInfo['joinids'][0]).'>'.$value['name'].'</option>';
		}
		$str.= '<select '.$disabled.' name="'.$name.'1" class="hstui-input hstui-select J_areaAjax_'.$name.'" data-toid="Lzscms_'.$name.'2" id="Lzscms_'.$name.'1" data-area="1" data-tips="请选择省份">
					<option value="">请选择省份</option>
					'.$option1.'
	            </select>
	            <select '.$disabled.'  name="'.$name.'2" class="hstui-input hstui-select J_areaAjax_'.$name.'" data-toid="Lzscms_'.$name.'3" id="Lzscms_'.$name.'2" data-area="2" data-tips="请选择城市">
					<option value="">请选择城市</option>
	            </select>
	            <select '.$disabled.' name="'.$name.'3" class="hstui-input hstui-select" id="Lzscms_'.$name.'3"  data-area="3" data-tips="请选择县(区)">
					<option value="">请选择县(区)</option>
	            </select>';
        $str .='
            <script>
            var '.$name.'1 = '.(int)$vInfo['joinids'][0].';
            var '.$name.'2 = '.(int)$vInfo['joinids'][1].';
            var '.$name.'3 = '.(int)$vInfo['joinids'][2].';
                Hstui.use(\'jquery\',function(){
                	function setArea_'.$name.'(areaid, toid, area, id) {
						var url = \''.route('publicAreaList').'\';
						var tips = $(\'#\'+toid).data(\'tips\')
						if(typeof(toid) !== \'undefined\') {
							var option = \'<option value="">\'+tips+\'</option>\';
							$.get(url + \'?areaid=\'+areaid,function(data, status){
							    if(data.length) {
							    	var selected = \'\';
							    	for (var i=0; i < data.length; i++) {
							    		selected = \'\';
							    		if(id == data[i].areaid) {
							    			selected = \'selected\';
							    		}
							    		option +=\'<option \'+selected+\' value="\'+data[i].areaid+\'">\'+data[i].name+\'</option>\';
							    	}
							    }
							    $(\'#\'+toid).html(option);
							}, \'json\');
						}
                	}
                	if('.$name.'1) {
                		setArea_'.$name.'('.$name.'1, \'Lzscms_'.$name.'2\', 1, '.$name.'2);
                	}
                	if('.$name.'2) {
                		setArea_'.$name.'('.$name.'2, \'Lzscms_'.$name.'3\', 2, '.$name.'3);
                	}
					$(".J_areaAjax_'.$name.'").on(\'change\',function(){
						var _this=$(this),val=_this.val(),toid=_this.data(\'toid\'),area=_this.data(\'area\');
						setArea_'.$name.'(val, toid, area);
						if(area == 1) {
                			setArea_'.$name.'(0, \'lzscms_'.$name.'3\');
						}
					});
                });
            </script>';
		return $this->input_format($name, $text, $str, $tips);
	}
	
    /**
     * 处理输入数据，提供给入库
     */
	public function insert_value(Request $request, $field, $postData = [])
	{
		$value1 = $request->get($field['fieldname'].'1');
		$value2 = $request->get($field['fieldname'].'2');
		$value3 = $request->get($field['fieldname'].'3');
		$postData[$field['relatedtable']][$field['fieldname'].'1'] = $value1;
		$postData[$field['relatedtable']][$field['fieldname'].'2'] = $value2;
		$postData[$field['relatedtable']][$field['fieldname'].'3'] = $value3;
    	return $postData;
    }
	
	/**
	 * 字段输出
	 */
	public function output_data($data, $field = []) 
	{
		if(!isset($data[$field['fieldname'].'3'])) {
			return $data;
		}
		$value = $data[$field['fieldname'].'3'];
		if(!$value) {
			return $data;
		}
		$data[$field['fieldname']] = CommonAreaModel::getInfoByAreaid($value, false);
		$data[$field['fieldname'].'_str'] = $data[$field['fieldname']]['joinname'];
		return $data;
	}
}