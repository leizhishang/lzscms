<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageBlockEditSave', ['module'=>$module]) }}" method="post">
    {!! lzs_csrf() !!}
    <input type="hidden" name="id" value="{{ $id }}" id="lzscms_id">
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="name" id="lzscms_name" value="{{ lzs_value('name', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('type')) hstui-form-error @endif" id="J_form_error_type">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.type') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
             <input type="radio" onchange="clickType('text')" name="type" value="text" {{ Lzs_ifCheck($info['type'] == 'text') }}>
             <label>文本</label>
             <input type="radio" onchange="clickType('html')" name="type" value="html" {{ Lzs_ifCheck($info['type'] == 'html') }}> 
             <label>html</label>
             <input type="radio" onchange="clickType('image')" name="type" value="image" {{ Lzs_ifCheck($info['type'] == 'image') }}> 
             <label>图片</label>
            <div class="hstui-form-input-tips" id="J_form_tips_type" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('isopen')) hstui-form-error @endif" id="J_form_error_isopen">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.status') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="isopen" id="lzscms_isopen" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ lzs_lang('lzscms::public.closes')}}" data-switchx-ontext="{{ lzs_lang('lzscms::public.opens')}}" data-hstui-switchx @if(old('isopen')) {{ Lzs_ifCheck(old('isopen')) }}@else {{ Lzs_ifCheck($info['isopen']) }} @endif data-switchx-text="isopen"/>
            <div class="hstui-form-input-tips" id="J_form_tips_isopen" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($info['type'] != 'image') hstui-hide @endif @if($errors->has('image')) hstui-form-error @endif" id="J_form_error_image">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.image') }}</label>
          <div class="hstui-u-sm-10  hstui-form-input">
            <div class="hstui-upload J_upload"></div>
            <div class="hstui-form-input-tips" id="J_form_tips_image" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($info['type'] != 'image') hstui-hide @endif @if($errors->has('link')) hstui-form-error @endif" id="J_form_error_link">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.url') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="link" id="lzscms_link" value="{{ lzs_value('link', $info['image']) }}" class="hstui-input hstui-length-6">
            <div class="hstui-form-input-tips" id="J_form_tips_link" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($info['type'] != 'text') hstui-hide @endif @if($errors->has('content')) hstui-form-error @endif" id="J_form_error_content">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.content') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <textarea class="hstui-textarea" style="height: 420px; width: 100%;" name="content" id="lzscms_content">{{ lzs_value('content', $info) }}</textarea>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($info['type'] != 'html') hstui-hide @endif @if($errors->has('contentv')) hstui-form-error @endif" id="J_form_error_contentv">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.content') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <textarea class="hstui-textarea" style="height: 420px; width: 100%;" name="contentv" id="lzscms_contentv">{{ lzs_value('content', $info) }}</textarea>
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

Hstui.use('jquery','common', 'upload', 'kindeditor', function() {
    Hstui.editer('#lzscms_contentv', {
      source:true
    });
    $(".J_upload").hstuiUpload({  
      fileName: 'filedata',
      fName: 'image',
      isedit: true,
      multi:false,
      url: '{{ route('uploadImageSave') }}',
      dataList: [{!! json_encode($info['attach']) !!}],
      formParam: {
        upapp: 'block',
        _token: $("input[name='_token']").val()
      }
    });
});
function clickType(t) 
{
  if(t=='text') {
      $("#J_form_error_image").addClass('hstui-hide');
      $("#J_form_error_link").addClass('hstui-hide');
      $("#J_form_error_contentv").addClass('hstui-hide');
      $("#J_form_error_content").removeClass('hstui-hide');
  } else if(t=='html') {
      $("#J_form_error_image").addClass('hstui-hide');
      $("#J_form_error_link").addClass('hstui-hide');
      $("#J_form_error_content").addClass('hstui-hide');
      $("#J_form_error_contentv").removeClass('hstui-hide');
  } else if(t == 'image') {
      $("#J_form_error_content").addClass('hstui-hide');
      $("#J_form_error_contentv").addClass('hstui-hide');
      $("#J_form_error_image").removeClass('hstui-hide');
      $("#J_form_error_link").removeClass('hstui-hide');
  }
}
</script>
</body>
</html>