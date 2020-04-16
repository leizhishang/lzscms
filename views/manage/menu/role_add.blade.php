<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body style="width: 600px; height:365px">
<form method="post" class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageMenuRoleAddSave') }}">
    {{ lzs_csrf() }}
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="name" id="lzscms_name" value="{{ lzs_value('name', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="{{ lzs_lang('lzscms::public.enter.one.name') }}">{{ lzs_lang('lzscms::public.enter.one.name') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('ename')) hstui-form-error @endif" id="J_form_error_ename">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.ename') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="ename" id="lzscms_ename" value="{{ lzs_value('ename', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_ename" data-tips="{{ lzs_lang('lzscms::public.enter.one.ename') }}">{{ lzs_lang('lzscms::public.enter.one.ename') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('uri')) hstui-form-error @endif" id="J_form_error_uri">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.uri') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="uri" id="lzscms_uri" value="{{ lzs_value('uri', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_uri" data-tips="{{ lzs_lang('lzscms::public.enter.one.uri') }}">{{ lzs_lang('lzscms::public.enter.one.uri') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('parent')) hstui-form-error @endif" id="J_form_error_parent">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.ascription') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="parent" id="lzscms_parent" value="{{ lzs_value('parent', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_parent" data-tips="{{ lzs_lang('lzscms::public.enter.one.ascription') }}">{{ lzs_lang('lzscms::public.enter.one.ascription') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('remark')) hstui-form-error @endif" id="J_form_error_remark">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.remark') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="remark" id="lzscms_remark" value="{{ lzs_value('remark', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_remark" data-tips=""></div>
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
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>