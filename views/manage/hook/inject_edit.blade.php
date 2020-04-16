<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body style="width:690px; height: 500px">
<form method="post" class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageHookInjectEditSave', ['name'=>$hook_name]) }}">
<input type="hidden" name="id" value="{!! $id !!}">
<input type="hidden" name="alias" value="{{ lzs_value('alias', $info) }}">
    {{ lzs_csrf() }}
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label"><font color="red">*</font>{{ lzs_lang('lzscms::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" readonly value="{{ $hook_name }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="{{ lzs_lang('lzscms::public.enter.one.name') }}">{{ lzs_lang('lzscms::public.enter.one.name') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('alias')) hstui-form-error @endif" id="J_form_error_alias">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::hook.alias') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" readonly value="{{ lzs_value('alias', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_alias" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('files')) hstui-form-error @endif" id="J_form_error_files">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::hook.files') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="files" id="lzscms_files" value="{{ lzs_value('files', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_files" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('class')) hstui-form-error @endif" id="J_form_error_class">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::hook.class') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="class" id="lzscms_class" value="{{ lzs_value('class', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_class" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('fun')) hstui-form-error @endif" id="J_form_error_fun">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::hook.fun') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="fun" id="lzscms_fun" value="{{ lzs_value('fun', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_fun" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('description')) hstui-form-error @endif" id="J_form_error_description">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::hook.description') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
                <textarea name="description" id="lzscms_description" class="hstui-input hstui-textarea hstui-length-4" placeholder="" style="height: 120px">{{ lzs_value('description', $info) }}</textarea>
            <div class="hstui-form-input-tips" id="J_form_tips_description" data-tips=""></div>
          </div>
        </div>
      </div>
    </div>
        <div class="hstui-pop-cont hstui-pop-table">
            <div class="hstui-form hstui-form-horizontal">
                <div class="hstui-form-group" id="J_form_error_hook_name">
                    <label for="doc-ipt-pwd-21" class="hstui-u-sm-4 hstui-form-label">{{ lzs_lang('lzscms::hook.name') }}</label>
                    <input type="text" class="hstui-form-field hstui-length-4" value="{{ $hook_name }}" readonly placeholder="">
                </div>
                <div class="hstui-form-group" id="J_form_error_alias">
                    <label for="doc-ipt-pwd-21" class="hstui-u-sm-4 hstui-form-label">{{ lzs_lang('lzscms::hook.alias') }}</label>
                    <input type="text" readonly class="hstui-form-field hstui-length-4" value="{{ lzs_value('alias', $info) }}" placeholder="">
                </div>
                <div class="hstui-form-group" id="J_form_error_files">
                    <label for="doc-ipt-pwd-21" class="hstui-u-sm-4 hstui-form-label">{{ lzs_lang('lzscms::hook.files') }}</label>
                    <input type="text" name="files" id="lzscms_files" class="hstui-form-field hstui-length-4" value="{{ lzs_value('files', $info) }}" placeholder="">
                </div>
                <div class="hstui-form-group" id="J_form_error_class">
                    <label for="doc-ipt-pwd-21" class="hstui-u-sm-4 hstui-form-label">{{ lzs_lang('lzscms::hook.class') }}</label>
                    <input type="text" name="class" id="lzscms_class" class="hstui-form-field hstui-length-4" value="{{ lzs_value('class', $info) }}" placeholder="">
                </div>
                <div class="hstui-form-group" id="J_form_error_fun">
                    <label for="doc-ipt-pwd-21" class="hstui-u-sm-4 hstui-form-label">{{ lzs_lang('lzscms::hook.fun') }}</label>
                    <input type="text" name="fun" id="lzscms_fun" class="hstui-form-field hstui-length-4" value="{{ lzs_value('fun', $info) }}" placeholder="">
                </div>
                <div class="hstui-form-group" id="J_form_error_description">
                    <label for="doc-ipt-pwd-21" class="hstui-u-sm-4 hstui-form-label">{{ lzs_lang('lzscms::hook.description') }}</label>
                    <textarea name="description" id="lzscms_description" class="hstui-length-4" placeholder="" style="height: 120px">{{ lzs_value('description', $info) }}</textarea>
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