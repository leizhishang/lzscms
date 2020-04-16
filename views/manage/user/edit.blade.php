<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<form method="post" class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageUserEditSave') }}">
    <input type="hidden" name="uid" value="{{ $uid }}">
    {{ lzs_csrf() }}
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('gid')) hstui-form-error @endif" id="J_form_error_gid">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.role') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
                <select name="gid" id="lzscms_gid" class="hstui-length-2">
                    <option value="0">{{ lzs_lang('lzscms::manage.select.role') }}</option>
                    @foreach($roles as $key=>$val)
                    <option value="{{ $val['id'] }}" {!! Lzs_isSelected($val['id'] == $info['gid']) !!}>{{ $val['name'] }}</option>
                    @endforeach
                </select>
            <div class="hstui-form-input-tips" id="J_form_tips_width" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('username')) hstui-form-error @endif" id="J_form_error_username">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.username') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="username" id="lzscms_username" value="{{ lzs_value('username', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_username" data-tips="{{ lzs_lang('lzscms::public.enter.one.username') }}">{{ lzs_lang('lzscms::public.enter.one.username') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('password')) hstui-form-error @endif" id="J_form_error_password">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.password') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="password" id="lzscms_password" value="{{ lzs_value('password') }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_password" data-tips="{{ lzs_lang('lzscms::public.enter.one.password') }}">{{ lzs_lang('lzscms::public.enter.one.password') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.realname') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="name" id="lzscms_name" value="{{ lzs_value('name', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="{{ lzs_lang('lzscms::public.enter.one.realname') }}">{{ lzs_lang('lzscms::public.enter.one.realname') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('mobile')) hstui-form-error @endif" id="J_form_error_mobile">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.mobile') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="mobile" id="lzscms_mobile" value="{{ lzs_value('mobile', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_mobile" data-tips="{{ lzs_lang('lzscms::public.enter.one.mobile') }}">{{ lzs_lang('lzscms::public.enter.one.mobile') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('email')) hstui-form-error @endif" id="J_form_error_email">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.email') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="email" id="lzscms_email" value="{{ lzs_value('email', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_mobile" data-tips="{{ lzs_lang('lzscms::public.enter.one.email') }}">{{ lzs_lang('lzscms::public.enter.one.email') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('qq')) hstui-form-error @endif" id="J_form_error_qq">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('QQ') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="qq" id="lzscms_qq" value="{{ lzs_value('qq', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_qq" data-tips="{{ lzs_lang('lzscms::public.enter.one.qq') }}">{{ lzs_lang('lzscms::public.enter.one.qq') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('weixin')) hstui-form-error @endif" id="J_form_error_weixin">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.weixin') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="weixin" id="lzscms_weixin" value="{{ lzs_value('weixin', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_weixin" data-tips="{{ lzs_lang('lzscms::public.enter.one.weixin') }}">{{ lzs_lang('lzscms::public.enter.one.weixin') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('status')) hstui-form-error @endif" id="J_form_error_status">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.status') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
            <input type="checkbox" name="status" id="lzscms_status" data-class="hstui-switchx-default hstui-round hstui-mr-lg" data-switchx-offtext="{{ lzs_lang('lzscms::public.disable')}}" data-switchx-ontext="{{ lzs_lang('lzscms::public.enable')}}" data-hstui-switchx {{ Lzs_ifCheck(!$info['status']) }} data-switchx-text="status"/>
            <div class="hstui-form-input-tips" id="J_form_tips_status" data-tips=""></div>
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