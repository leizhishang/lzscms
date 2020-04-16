<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageSpecialAddSave', ['module'=>$module]) }}" method="post">
    {!! lzs_csrf() !!}
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input onBlur="lzs_topinyin('dir', 'name');" type="text" name="name" id="lzscms_name" value="{{ lzs_value('name') }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('dir')) hstui-form-error @endif" id="J_form_error_dir">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.dir') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="dir" id="lzscms_dir" value="{{ lzs_value('dir') }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_dir" data-tips="{{ lzs_lang('lzscms::manage.special.dir.tips') }}">{{ lzs_lang('lzscms::manage.special.dir.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('domain')) hstui-form-error @endif" id="J_form_error_domain">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.special.domain') }}</label>
          <div class="hstui-u-sm-10  hstui-form-input">
              <input type="text" name="domain" id="lzscms_domain" value="" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_domain" data-tips="{!! lzs_lang('lzscms::manage.special.domain.tips') !!}">{!! lzs_lang('lzscms::manage.special.domain.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('style')) hstui-form-error @endif" id="J_form_error_style">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.special.style') }}</label>
          <div class="hstui-u-sm-10  hstui-form-input">
              <input type="text" name="style" id="lzscms_style" value="{{ lzs_value('style') }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_style" data-tips="{!! lzs_lang('lzscms::manage.special.style.tips') !!}">{!! lzs_lang('lzscms::manage.special.style.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('isopen')) hstui-form-error @endif" id="J_form_error_isopen">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.status') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="isopen" id="lzscms_isopen" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ lzs_lang('lzscms::public.closes')}}" data-switchx-ontext="{{ lzs_lang('lzscms::public.opens')}}" data-hstui-switchx @if(old('isopen')) {{ lzs_ifCheck(old('isopen')) }}@else checked @endif data-switchx-text="isopen"/>
            <div class="hstui-form-input-tips" id="J_form_tips_isopen" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('header')) hstui-form-error @endif" id="J_form_error_header">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.special.header') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="header" id="lzscms_header" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ lzs_lang('lzscms::public.closes')}}" data-switchx-ontext="{{ lzs_lang('lzscms::public.opens')}}" data-hstui-switchx @if(old('header')) {{ lzs_ifCheck(old('header')) }}@else checked @endif data-switchx-text="header"/>
            <div class="hstui-form-input-tips" id="J_form_tips_header" data-tips="{!! lzs_lang('lzscms::manage.special.header.tips') !!}">{!! lzs_lang('lzscms::manage.special.header.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('footer')) hstui-form-error @endif" id="J_form_error_footer">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.special.footer') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="footer" id="lzscms_footer" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ lzs_lang('lzscms::public.closes')}}" data-switchx-ontext="{{ lzs_lang('lzscms::public.opens')}}" data-hstui-switchx @if(old('footer')) {{ lzs_ifCheck(old('footer')) }}@else checked @endif data-switchx-text="footer"/>
            <div class="hstui-form-input-tips" id="J_form_tips_footer" data-tips="{!! lzs_lang('lzscms::manage.special.footer.tips') !!}">{!! lzs_lang('lzscms::manage.special.footer.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('content')) hstui-form-error @endif" id="J_form_error_content">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.content') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <textarea class="hstui-textarea" style="height: 420px; width: 100%;" name="content" id="lzscms_content"></textarea>
          </div>
        </div>
      </div>
      <div class="hstui-frame-title">SEO</div>
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('title')) hstui-form-error @endif" id="J_form_error_title">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.seo.title') }}</label>
          <div class="hstui-u-sm-10  hstui-form-input">
              <input type="text" name="title" id="lzscms_title" value="" class="hstui-input hstui-length-6">
            <div class="hstui-form-input-tips" id="J_form_tips_title" data-tips="{!! lzs_lang('lzscms::manage.seo.title.tips') !!}">{!! lzs_lang('lzscms::manage.seo.title.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('keywords')) hstui-form-error @endif" id="J_form_error_keywords">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.seo.keywords') }}</label>
          <div class="hstui-u-sm-10  hstui-form-input">
              <input type="text" name="keywords" id="lzscms_keywords" value="" class="hstui-input hstui-length-6">
            <div class="hstui-form-input-tips" id="J_form_tips_keywords" data-tips="{!! lzs_lang('lzscms::manage.seo.keywords.tips') !!}">{!! lzs_lang('lzscms::manage.seo.keywords.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('description')) hstui-form-error @endif" id="J_form_error_description">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.seo.description') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <textarea class="hstui-input hstui-textarea hstui-length-6" style="height: 120px;" name="description" id="lzscms_description"></textarea>
              <div class="hstui-form-input-tips" id="J_form_tips_description" data-tips="{!! lzs_lang('lzscms::manage.seo.description.tips') !!}">{!! lzs_lang('lzscms::manage.seo.description.tips') !!}</div>
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
Hstui.use('jquery','common', 'kindeditor', function() {
    Hstui.editer('#lzscms_content', {
      source:true
    });
});
function Lzs_topinyin(t, f) {
  $.get('{!! route('publicTopinyin') !!}?rand='+Math.random(),{ str:$("#lzscms_"+f).val()}, function(data){
    $('#lzscms_'+t).val(data);
  });
}
</script>
</body>
</html>