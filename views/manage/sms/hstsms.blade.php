<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
{!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageSmsHstsmsConfigSave') }}" method="post">
    {!! lzs_csrf() !!} 
    <div class="hstui-frame">
      <div class="hstui-frame-title">{{ lzs_lang('lzscms::public.setting') }}</div>
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm" >
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.sms.tiaos') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              @if($surplus['state'] == 0) <font color="red">{{ @$surplus['data']['surplus'] }}</font> 条 @else <font color="red">{{ $surplus['message'] }} </font>@endif
            <div class="hstui-form-input-tips"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('hstsmsappid')) hstui-form-error @endif" id="J_form_error_hstsmsappid">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.sms.hstsmsappid') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="hstsmsappid" id="lzscms_hstsmsappid" value="{!! lzs_value('hstsmsappid', $config) !!}" class="hstui-input hstui-length-6">
            <div class="hstui-form-input-tips" id="J_form_tips_hstsmsappid" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('hstsmskey')) hstui-form-error @endif" id="J_form_error_hstsmskey">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.sms.key') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="hstsmskey" id="lzscms_hstsmskey" value="{!! lzs_value('hstsmskey', $config) !!}" class="hstui-input hstui-length-6">
            <div class="hstui-form-input-tips" id="J_form_tips_hstsmskey" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('hstsmssign')) hstui-form-error @endif" id="J_form_error_hstsmssign">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.sms.sign') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="hstsmssign" id="lzscms_hstsmssign" value="{!! lzs_value('hstsmssign', $config) !!}" class="hstui-input hstui-length-6">
            <div class="hstui-form-input-tips" id="J_form_tips_hstsmssign" data-tips=""></div>
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
</script>
</body>
</html>