<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body style="width: 600px; height:355px">
<form method="post" class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageMenuNavEditSave') }}">
    <input type="hidden" name="id" id="lzscms_id" value="{!! $id !!}">
    {{ lzs_csrf() }}
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('parent')) hstui-form-error @endif" id="J_form_error_parent">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.username') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
                <select class="hstui-length-4" name="parent" id="lzscms_parent">
                    <option value="0" {!! Lzs_isSelected('root' == $info['parent']) !!}>{!! lzs_lang('lzscms::public.top.level') !!}</option>
                    @foreach($menus as $k=>$v)
                        <option value="{!! $v['id'] !!}" {!! Lzs_isSelected($v['ename'] == $info['parent']) !!}>{!! $v['name'] !!}</option>
                        @if(isset($v['items']) && $v['items'])
                        @foreach($v['items'] as $ks=>$vs)
                        <option value="{!! $vs['id'] !!}" {!! Lzs_isSelected($vs['ename'] == $info['parents'] && $vs['parent'] == $info['parent']) !!}>  --{!! $vs['name'] !!}</option>
                        @endforeach
                        @endif
                    @endforeach
                </select>
                <div class="hstui-form-input-tips" id="J_form_tips_parent" data-tips=""></div>
          </div>
        </div>
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
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('url')) hstui-form-error @endif" id="J_form_error_url">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.url') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="url" id="lzscms_url" value="{{ lzs_value('url', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_url" data-tips="{{ lzs_lang('lzscms::public.enter.one.url') }}">{{ lzs_lang('lzscms::public.enter.one.url') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('icon')) hstui-form-error @endif" id="J_form_error_icon">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.icon') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="icon" id="lzscms_icon" value="{{ lzs_value('icon', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_icon" data-tips="{{ lzs_lang('lzscms::public.enter.one.icon') }}">{{ lzs_lang('lzscms::public.enter.one.icon') }}</div>
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