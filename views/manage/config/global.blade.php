<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageConfigGlobalSave') }}" method="post">
    {!! lzs_csrf() !!} 
    <div class="hstui-frame">
      	<div class="hstui-frame-content">
	        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('url')) hstui-form-error @endif" id="J_form_error_url">
	          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.site.url') }}</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="url" id="lzscms_url" value="@if($errors->has('url')){!! old('url') !!}@else{!! @$config['url'] !!}@endif" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_url" data-tips="{{ lzs_lang('lzscms::manage.site.url.tips') }}">{{ lzs_lang('lzscms::manage.site.url.tips') }}</div>
	          </div>
	        </div>
	        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('timezone')) hstui-form-error @endif" id="J_form_error_timezone">
	          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.default.timezone') }}</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="timezone" id="lzscms_timezone" value="{{ lzs_value('timezone', $config) }}" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_timezone"></div>
	          </div>
	        </div>
	        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('timecv')) hstui-form-error @endif" id="J_form_error_timecv">
	          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.timecv') }}</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="timecv" id="lzscms_timecv" value="{{ lzs_value('timecv', $config) }}" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_timecv" data-tips="{{ lzs_lang('lzscms::manage.timecv.tips') }}">{{ lzs_lang('lzscms::manage.timecv.tips') }}</div>
	          </div>
	        </div>
	        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('debug')) hstui-form-error @endif" id="J_form_error_debug">
	          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.debug') }}</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="checkbox" name="debug" id="lzscms_debug" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ lzs_lang('lzscms::public.close')}}" data-switchx-ontext="{{ lzs_lang('lzscms::public.open')}}" data-hstui-switchx @if(old('debug')) {{ lzs_ifCheck(old('debug')) }} @else {{ lzs_ifCheck($config['debug']) }} @endif data-switchx-text="debug"/>
	            <div class="hstui-form-input-tips" id="J_form_tips_debug" data-tips="{{ lzs_lang('lzscms::manage.debug.tips') }}">{!! lzs_lang('lzscms::manage.debug.tips') !!}</div>
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