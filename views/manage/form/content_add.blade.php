<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageFormContentAddSave', ['formid'=>$id]) }}" method="post">
    {!! lzs_csrf() !!}
    <input type="hidden" name="formid" value="{{ $id }}">
    <div class="hstui-frame">
      <div class="hstui-frame-content">
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