<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body style="width: 720px; height: 450px">
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageFormEditSave', ['module'=>$module, 'relatedid'=>$relatedid]) }}" method="post">
    {!! lzs_csrf() !!}
    <input type="hidden" name="id" value="{{ $id }}" id="lzscms_id">
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.form.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="name" id="lzscms_name" value="{{ lzs_value('name', $info) }}" class="hstui-input hstui-length-3">
            <div class="hstui-form-input-tips" id="J_form_tips_name"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('table')) hstui-form-error @endif" id="J_form_error_table">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.form.table') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="table" id="lzscms_table" value="{{ lzs_value('table', $info) }}" readonly class="hstui-input hstui-length-3">
            <div class="hstui-form-input-tips" id="J_form_tips_table" data-tips="{{ lzs_lang('lzscms::manage.form.table.tips') }}">{{ lzs_lang('lzscms::manage.form.table.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('mobile')) hstui-form-error @endif" id="J_form_error_mobile">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.form.mobile.notice') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="mobile" id="lzscms_mobile" value="{{ lzs_value('mobile', $info['setting']) }}" class="hstui-input hstui-length-3">
            <div class="hstui-form-input-tips hstui-u-sm-8" id="J_form_tips_mobile" data-tips="{!! lzs_lang('lzscms::manage.form.mobile.notice.tips') !!}">{!! lzs_lang('lzscms::manage.form.mobile.notice.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('email')) hstui-form-error @endif" id="J_form_error_email">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.form.email.notice') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="email" id="lzscms_email" value="{{ lzs_value('email', $info['setting']) }}" class="hstui-input hstui-length-3">
            <div class="hstui-form-input-tips hstui-u-sm-8" id="J_form_tips_email" data-tips="{!! lzs_lang('lzscms::manage.form.email.notice.tips') !!}">{!! lzs_lang('lzscms::manage.form.email.notice.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('emailcontent')) hstui-form-error @endif" id="J_form_error_emailcontent">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.form.email.content') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <textarea class="hstui-input hstui-textarea hstui-length-4" style="height: 120px" name="emailcontent" id="lzscms_emailcontent">{{ lzs_value('email_content', $info['setting']) }}</textarea>
            <div class="hstui-form-input-tips" id="J_form_tips_emailcontent" data-tips="{!! lzs_lang('lzscms::manage.form.email.content.tips') !!}">{!! lzs_lang('lzscms::manage.form.email.content.tips') !!}</div>
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