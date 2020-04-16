<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageFormContentEditSave', ['formid'=>$formid, 'id'=>$id]) }}" method="post">
    {!! lzs_csrf() !!}
    <input type="hidden" name="formid" value="{{ $formid }}">
    <input type="hidden" name="id" value="{{ $id }}">
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('created_uid')) hstui-form-error @endif" id="J_form_error_created_uid">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('UID') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="created_uid" readonly id="lzscms_created_uid"  value="{{ lzs_value('created_uid', $infos) }}" class="hstui-input hstui-length-5 ">
            <div class="hstui-form-input-tips" id="J_form_tips_created_uid"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('created_time')) hstui-form-error @endif" id="J_form_error_created_time">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.add') }}{{ lzs_lang('lzscms::public.times') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="created_time" readonly id="lzscms_created_time"  value="{{ Lzs_time2str(lzs_value('created_time', $infos), 'Y-m-d H:i') }}" class="hstui-input hstui-length-5 ">
            <div class="hstui-form-input-tips" id="J_form_tips_created_time"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('created_ip')) hstui-form-error @endif" id="J_form_error_created_ip">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('IP') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="created_ip" readonly id="lzscms_created_ip"  value="{{ lzs_value('created_ip', $infos) }}" class="hstui-length-2 " style="margin-right: 5px;">
              <input type="text" name="created_port" readonly id="lzscms_created_port"  value="{{ lzs_value('created_port', $infos) }}" class="hstui-input hstui-length-2 ">
            <div class="hstui-form-input-tips" id="J_form_tips_created_ip"></div>
          </div>
        </div>
        {!! $inputHtml !!}
      </div>
    </div>
    <div class="hstui-form-button">
        <button class="hstui-button " id="J_dialog_close">{{ lzs_lang('lzscms::public.cancel')}}</button>
        <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn">{{ lzs_lang('lzscms::public.submit')}}</button>
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
  $.get('{!! route('publicFieldsTypeHtml', ['id'=>0]) !!}&rand='+Math.random(),{ type:type}, function(data){
    $('#Lzs_option').html(data);
    $("#lzs_loading").hide();
  });
}
function Lzs_topinyin(t, f) {
  $.get('{!! route('publicTopinyin') !!}?rand='+Math.random(),{ str:$("#lzscms_"+f).val()}, function(data){
    $('#lzscms_'+t).val(data);
  });
}
</script>
</body>
</html>