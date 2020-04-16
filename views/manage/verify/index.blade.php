<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageCaptchaSave') }}" method="post">
    {!! lzs_csrf() !!} 
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('width')) hstui-form-error @endif" id="J_form_error_width">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.width') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="width" id="lzscms_width" value="{!! lzs_value('width', $config) !!}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_width" data-tips="{!! lzs_lang('lzscms::captcha.default.width') !!}">{!! lzs_lang('lzscms::captcha.default.width') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('height')) hstui-form-error @endif" id="J_form_error_height">
          <label for="doc-ipt-3-1" class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.height') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="height" id="lzscms_height" value="{!! lzs_value('height', $config) !!}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_height" data-tips="{!! lzs_lang('lzscms::captcha.default.height') !!}">{!! lzs_lang('lzscms::captcha.default.height') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('length')) hstui-form-error @endif" id="J_form_error_length">
          <label for="doc-ipt-3-1" class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.length') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="length" id="lzscms_length" value="{!! lzs_value('length', $config) !!}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_length" data-tips="{!! lzs_lang('lzscms::captcha.default.length') !!}">{!! lzs_lang('lzscms::captcha.default.length') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm" id="J_form_error_preview">
          <label for="doc-ipt-3-1" class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.preview') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <img src="{!! route('captchaIndexGet') !!}">
            <div class="hstui-form-input-tips" id="J_form_tips_preview"></div>
          </div>
        </div>
        <div class="hstui-form-group">
          <div class="hstui-u-sm-10 hstui-u-sm-offset-2">
            <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn">{{ lzs_lang('lzscms::public.save') }}</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>