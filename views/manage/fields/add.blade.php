<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageFieldsAddSave') }}" method="post">
    {!! lzs_csrf() !!}
    <input type="hidden" name="rname" value="{{ $rname }}">
    <input type="hidden" name="relatedid" value="{{ $relatedid }}">
    <input type="hidden" name="relatedtable" value="{{ $relatedtable }}">
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-frame-title">{{ lzs_lang('lzscms::public.basic.information')}}</div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="name" id="lzscms_name"  onBlur="Lzs_topinyin('fieldname', 'name');" value="{{ Lzs_value('name') }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="{{ lzs_lang('lzscms::manage.fields.name.tips') }}">{{ lzs_lang('lzscms::manage.fields.name.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('fieldname')) hstui-form-error @endif" id="J_form_error_fieldname">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.fields.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="fieldname" id="lzscms_fieldname" value="{{ lzs_value('fieldname') }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_fieldname" data-tips="{{ lzs_lang('lzscms::manage.fields.namex.tips') }}">{{ lzs_lang('lzscms::manage.fields.namex.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('vieworder')) hstui-form-error @endif" id="J_form_error_vieworder">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.fields.vieworder') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="vieworder" id="lzscms_vieworder" value="{{ lzs_value('vieworder') }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_vieworder" data-tips="{{ lzs_lang('lzscms::manage.fields.vieworder.tips') }}">{{ lzs_lang('lzscms::manage.fields.vieworder.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('issearch')) hstui-form-error @endif" id="J_form_error_issearch">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.fields.issearch') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="issearch" id="lzscms_issearch" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ lzs_lang('lzscms::public.no')}}" data-switchx-ontext="{{ lzs_lang('lzscms::public.yes')}}" data-hstui-switchx @if(old('issearch')) {{ lzs_ifCheck(old('issearch')) }}@endif data-switchx-text="issearch"/>
            <div class="hstui-form-input-tips" id="J_form_tips_disabled" data-tips="{{ lzs_lang('lzscms::manage.fields.issearch.tips') }}">{{ lzs_lang('lzscms::manage.fields.issearch.tips') }}</div>
          </div>
        </div>

        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('disabled')) hstui-form-error @endif" id="J_form_error_disabled">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.status') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="disabled" id="lzscms_disabled" data-class="hstui-switchx-default hstui-round hstui-fl" data-switchx-offtext="{{ lzs_lang('lzscms::public.closes')}}" data-switchx-ontext="{{ lzs_lang('lzscms::public.opens')}}" data-hstui-switchx @if(old('disabled')) {{ lzs_ifCheck(old('disabled')) }} @else checked @endif data-switchx-text="disabled"/>
            <div class="hstui-form-input-tips" id="J_form_tips_disabled" data-tips="{{ lzs_lang('lzscms::manage.fields.status.tips') }}">{{ lzs_lang('lzscms::manage.fields.status.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('fieldtype')) hstui-form-error @endif" id="J_form_error_fieldtype">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.type') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <select class="hstui-input hstui-select" name="fieldtype" id="lzscms_fieldtype" style="" onChange="show_field_option(this.value)">
                <option value="">{{ lzs_lang('lzscms::public.please.select') }}</option>
                @foreach($fieldTypes as $fieldType)
                <option value="{{ $fieldType['id'] }}">{{ $fieldType['name'] }}</option>
                @endforeach
              </select>
              <span id="lzs_loading" style="display:none; font-size: 12px;margin-left: 10px; margin-top: 15px;">{{ lzs_lang('lzscms::public.loading')}}</span>
            <div class="hstui-form-input-tips" id="J_form_tips_fieldtype" data-tips="{{ lzs_lang('lzscms::manage.fields.type.tips') }}">{{ lzs_lang('lzscms::manage.fields.type.tips') }}</div>
          </div>
        </div>
      </div>
      <div class="hstui-frame-content" id="lzs_option"></div>
      <div class="hstui-frame-content">
        <div class="hstui-frame-title">{{ lzs_lang('lzscms::manage.fields.validators') }}</div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('isrequired')) hstui-form-error @endif" id="J_form_error_isrequired">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.isrequired') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <label><input type="radio" value="0" onClick="set_required(0)" name="setting[validate][required]" checked><span>否</span></label>
              <label><input type="radio" value="1" onClick="set_required(1)" name="setting[validate][required]"><span>是</span></label>
            <div class="hstui-form-input-tips" id="J_form_tips_isrequired" data-tips="{{ lzs_lang('lzscms::manage.fields.isrequired.tips') }}">{{ lzs_lang('lzscms::manage.fields.isrequired.tips') }}</div>
          </div>
        </div>
        <div id="required" class="hstui-form-group hstui-form-group-sm" style="display: none;" id="J_form_error_pattern">
          <div class="hstui-form-group hstui-form-group-sm" id="J_form_error_pattern">
            <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.fields.validator.pattern') }}</label>
            <div class="hstui-u-sm-10 hstui-form-input">
                <input type="text" name="setting[validate][pattern]" id="lzscms_pattern" value="" class="hstui-input hstui-length-3">
                <select class="hstui-select " style="height: 37px; margin-left: 5px;" onChange="set_pattern(this)" name="pattern_select">
                  <option value="">{{ lzs_lang('lzscms::public.regular.verification') }}</option>
                  <option value="/^[0-9.-]+$/">{{ lzs_lang('lzscms::public.number') }}</option>
                  <option value="/^[0-9-]+$/">{{ lzs_lang('lzscms::public.integer') }}</option>
                  <option value="/^[a-z]+$/i">{{ lzs_lang('lzscms::public.letters') }}</option>
                  <option value="/^[0-9a-z]+$/i">{{ lzs_lang('lzscms::public.number') }}+{{ lzs_lang('lzscms::public.letters') }}</option>
                  <option value="/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/">E-mail</option>
                  <option value="/^[0-9]{5,20}$/">QQ</option>
                  <option value="/^http:\/\//">URL</option>
                  <option value="/^(1)[0-9]{10}$/">{{ lzs_lang('lzscms::public.mobile') }}</option>
                  <option value="/^[0-9-]{6,13}$/">{{ lzs_lang('lzscms::public.phone') }}</option>
                  <option value="/^[0-9]{6}$/">{{ lzs_lang('lzscms::public.postal.code') }}</option>
                  </select>
              <div class="hstui-form-input-tips" id="J_form_tips_pattern"></div>
            </div>
          </div>
          <div class="hstui-form-group hstui-form-group-sm" id="J_form_error_errortips">
            <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.fields.validator') }}</label>
            <div class="hstui-u-sm-10 hstui-form-input">
                <input type="text" name="setting[validate][errortips]" id="lzscms_errortips" value="" class="hstui-input hstui-length-5">
              <div class="hstui-form-input-tips" id="J_form_tips_errortips" data-tips="{{ lzs_lang('lzscms::manage.fields.validator.tips') }}">{{ lzs_lang('lzscms::manage.fields.validator.tips') }}</div>
            </div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm" id="J_form_error_v_tips">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.fields.tips') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="setting[validate][tips]" id="lzscms_v_tips" value="" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_v_tips" data-tips="{{ lzs_lang('lzscms::manage.fields.tips.tips') }}">{{ lzs_lang('lzscms::manage.fields.tips.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('isedit')) hstui-form-error @endif" id="J_form_error_isedit">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.fields.isedit') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="isedit" id="lzscms_isedit" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ lzs_lang('lzscms::public.no')}}" data-switchx-ontext="{{ lzs_lang('lzscms::public.yes')}}" data-hstui-switchx @if(old('isedit')){{ Lzs_ifCheck(old('isedit')) }}@else @endif data-switchx-text="isedit"/>
            <div class="hstui-form-input-tips" id="J_form_tips_isedit" data-tips="{{ lzs_lang('lzscms::manage.fields.isedit.tips') }}">{{ lzs_lang('lzscms::manage.fields.isedit.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('isfrontshow')) hstui-form-error @endif" id="J_form_error_isfrontshow">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.front.end') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="isfrontshow" id="lzscms_isfrontshow" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ lzs_lang('lzscms::public.no')}}" data-switchx-ontext="{{ lzs_lang('lzscms::public.yes')}}" data-hstui-switchx @if(old('isfrontshow')) {{ lzs_ifCheck(old('isfrontshow')) }} @else checked @endif data-switchx-text="isfrontshow"/>
            <div class="hstui-form-input-tips" id="J_form_tips_isedit" data-tips="{{ lzs_lang('lzscms::manage.fields.front.end.tips') }}">{{ lzs_lang('lzscms::manage.fields.front.end.tips') }}</div>
          </div>
        </div>
      </div>
      <div class="hstui-frame-content">
        <div class="hstui-frame-title">{{ lzs_lang('lzscms::manage.fields.show') }}</div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('ismshow')) hstui-form-error @endif" id="J_form_error_ismshow">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.fields.manage.content.list.show') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="ismshow" id="lzscms_ismshow" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ lzs_lang('lzscms::public.no')}}" data-switchx-ontext="{{ lzs_lang('lzscms::public.yes')}}" data-hstui-switchx @if(old('ismshow')) {{ lzs_ifCheck(old('ismshow')) }}@endif data-switchx-text="ismshow"/>
            <div class="hstui-form-input-tips" id="J_form_tips_ismshow" data-tips="{{ lzs_lang('lzscms::manage.fields.manage.content.list.show.tips') }}">{{ lzs_lang('lzscms::manage.fields.manage.content.list.show.tips') }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="hstui-form-button">
       <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn">{{ lzs_lang('lzscms::public.save') }}</button>
    </div>    
  </form>
</div>
<script>
Hstui.use('jquery','common',function() {

});
function set_required(id) {
  if (id == 0) {
    $('#required').hide();
  } else {
    $('#required').show();
  }
}
function show_field_option(type) {
  $("#lzs_loading").show();
  $.get('{!! route('publicFieldsTypeHtml', ['id'=>0, 'relatedid'=>$relatedid, 'rname'=>$rname]) !!}&rand='+Math.random(),{ type:type}, function(data){
    $('#lzs_option').html(data);
    $("#lzs_loading").hide();
  });
}
function lzs_topinyin(t, f) {
  $.get('{!! route('publicTopinyin') !!}?rand='+Math.random(),{ str:$("#lzscms_"+f).val()}, function(data){
    $('#lzscms_'+t).val(data);
  });
}
function set_pattern(o)
{
  $('#lzscms_pattern').val(o.value)
}
</script>
</body>
</html>