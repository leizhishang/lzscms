<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body style="width:690px; height: 330px">
<form method="post" class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageHookEditSave') }}">
    <input type="hidden" name="name" id="lzscms_name" class="hstui-form-field hstui-length-4" value="{{ $name }}" placeholder="">
    {{ lzs_csrf() }}
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label"><font color="red">*</font>{{ lzs_lang('lzscms::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="name" id="lzscms_name" value="{{ lzs_value('name', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="{{ lzs_lang('lzscms::public.enter.one.name') }}">{{ lzs_lang('lzscms::public.enter.one.name') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('description')) hstui-form-error @endif" id="J_form_error_description">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.description') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="description" id="lzscms_description" value="{{ lzs_value('description', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_description" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('document', $info)) hstui-form-error @endif" id="J_form_error_document">
          <label class="hstui-u-sm-2 hstui-form-label"><font color="red">*</font>{{ lzs_lang('lzscms::hook.document') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
                <textarea name="document" id="lzscms_document" class="hstui-input hstui-textarea hstui-length-4" placeholder="" style="height: 120px">{{ lzs_value('document') }}</textarea>
            <div class="hstui-form-input-tips" id="J_form_tips_document" data-tips=""></div>
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