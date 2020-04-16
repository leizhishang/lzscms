<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body style="width: 700px; height: 500px;">
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageAreaAddSave') }}" method="post">
    {!! lzs_csrf() !!}
    <input type="hidden" name="parentid" value="{{$areaid}}">
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('areaid')) hstui-form-error @endif" id="J_form_error_areaid">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('Areaid') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="areaid" id="lzscms_areaid" value="{{ lzs_value('areaid') }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_areaid" data-tips="{{ lzs_lang('lzscms::manage.area.areaid') }}">{{ lzs_lang('lzscms::manage.area.areaid') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="name" id="lzscms_name" value="{{ lzs_value('name') }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('zip')) hstui-form-error @endif" id="J_form_error_zip">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.area.zip') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="zip" id="lzscms_zip" value="{{ lzs_value('zip') }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_zip" data-tips=""></div>
          </div>
        </div>
      </div>
    </div>
    <div class="hstui-form-button">
        <button class="hstui-button " id="J_dialog_close">{{ lzs_lang('lzscms::public.cancel')}}</button>
        <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn">{{ lzs_lang('lzscms::public.submit')}}</button>
    </div>
  </form>
<script>
Hstui.use('jquery','common', 'kindeditor', function() {
    Hstui.editer('#lzscms_content', {
      source:true
    });
});
function Lzs_topinyin(t, f) {
  $.get('{!! route('publicTopinyin') !!}?rand='+Math.random(),{ str:$("#lzscms_"+f).val()}, function(data){
    $('#lzscms_'+t).val(data);
  });
}
</script>
</body>
</html>