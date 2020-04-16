<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
{!! $navs !!}
<form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageConfigEmailTestSubmit') }}" method="post">
  {!! lzs_csrf() !!} 
  <div class="hstui-frame">
    <div class="hstui-frame-content">
      <div class="hstui-form-group hstui-form-group-sm " id="J_form_error_from">
        <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.email.from') }}</label>
        <div class="hstui-u-sm-10 hstui-form-input">
            <input type="text" value="@if($errors->has('port')){!! old('from') !!}@else{!! $config['from'] !!}@endif" class="hstui-input hstui-length-5 hstui-disabled" disabled>
          <div class="hstui-form-input-tips" id="J_form_tips_from"></div>
        </div>
      </div>
      <div class="hstui-form-group hstui-form-group-sm" id="J_form_error_fromName">
        <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.email.from.name') }}</label>
        <div class="hstui-u-sm-10 hstui-form-input">
            <input type="text" value="@if($errors->has('fromName')){!! old('fromName') !!}@else{!! $config['from.name'] !!}@endif" class="hstui-input hstui-length-5" disabled>
          <div class="hstui-form-input-tips" id="J_form_tips_fromName"></div>
        </div>
      </div>
      <div class="hstui-form-group hstui-form-group-sm @if($errors->has('toemail')) hstui-form-error @endif" id="J_form_error_toemail">
        <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.email.toemail') }}</label>
        <div class="hstui-u-sm-10 hstui-form-input">
            <input type="text" name="toemail" id="lzscms_toemail" value="@if($errors->has('toemail')){!! old('toemail') !!}@endif" class="hstui-input hstui-length-5 J_email_match">
            <div class="hstui-form-input-tips" id="J_form_tips_toemail" data-tips=""></div>
        </div>
      </div>
      <div class="hstui-form-group hstui-form-group-sm">
        <label class="hstui-u-sm-2 hstui-form-label">{!! lzs_lang('lzscms::manage.email.content') !!}</label>
        <div class="hstui-u-sm-10 hstui-form-input">
              <div class="hstui-alert hstui-alert-secondary" style="overflow:hidden">
                {!! lzs_lang('lzscms::manage.email.test.content.tips') !!}
              </div>
        </div>
      </div>
    </div>
  </div>
    <div class="hstui-form-button">
       <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn">{{ lzs_lang('lzscms::public.send') }}</button>
    </div>  
</form>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>