<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageCachesMemcachedConfigSave') }}" method="post">
    {!! lzs_csrf() !!} 
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('memdpsid')) hstui-form-error @endif" id="J_form_error_memdpsid">
          <label class="hstui-u-sm-2 hstui-form-label">persistent_id</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="memdpsid" id="lzscms_memdpsid" value="{{ lzs_value('memdpsid', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_memdpsid"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('memdhost')) hstui-form-error @endif" id="J_form_error_memdhost">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.host') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="memdhost" id="lzscms_memdhost" value="{{ lzs_value('memdhost', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_memdhost"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('memdport')) hstui-form-error @endif" id="J_form_error_memdport">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.port') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="memdport" id="lzscms_memdport" value="{{ lzs_value('memdport', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_memdport"></div>
          </div>
        </div>

        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('memdusername')) hstui-form-error @endif" id="J_form_error_memdusername">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.username') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="memdusername" id="lzscms_memdusername" value="{{ lzs_value('memdusername', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_memdusername"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('memdpassword')) hstui-form-error @endif" id="J_form_error_memdpassword">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.password') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="memdpassword" id="lzscms_memdpassword" value="{{ lzs_value('memdpassword', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_memdpassword"></div>
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