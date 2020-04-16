<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageCachesRedisConfigSave') }}" method="post">
    {!! lzs_csrf() !!} 
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('host')) hstui-form-error @endif" id="J_form_error_host">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.host') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="host" id="lzscms_memdhost" value="{{ lzs_value('redishost', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_host"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('port')) hstui-form-error @endif" id="J_form_error_port">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.port') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="port" id="lzscms_port" value="{{ lzs_value('redisport', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_port"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('password')) hstui-form-error @endif" id="J_form_error_password">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.password') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="password" id="lzscms_password" value="{{ lzs_value('redispassword', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_password"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="hstui-form-button">
       <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn">{{ lzs_lang('lzscms::public.submit') }}</button>
    </div>
  </form>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>