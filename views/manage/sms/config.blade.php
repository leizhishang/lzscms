<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
{!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageSmsConfigSave') }}" method="post">
    {!! lzs_csrf() !!} 
    <div class="hstui-frame">
      <div class="hstui-frame-title">{{ lzs_lang('lzscms::manage.sms.setting') }}</div>
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('product')) hstui-form-error @endif" id="J_form_error_product">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.sms.product') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="product" id="lzscms_product" value="{!! lzs_value('product', $config) !!}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" data-tips="{{ lzs_lang('lzscms::manage.sms.product.tips') }}">{{ lzs_lang('lzscms::manage.sms.product.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('codelength')) hstui-form-error @endif" id="J_form_error_codelength">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.sms.code.length') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="codelength" id="lzscms_codelength" value="{!! lzs_value('codelength', $config) !!}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" data-tips="{{ lzs_lang('lzscms::manage.sms.code.length.tips') }}">{{ lzs_lang('lzscms::manage.sms.code.length.tips') }}</div>
          </div>
        </div>
        @foreach($types as $k=>$v)
        <div class="hstui-form-group hstui-form-group-sm " id="J_form_error_{{ $k }}">
          <label class="hstui-u-sm-2 hstui-form-label">{{ $v['name'] }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="{{ $k }}" id="lzscms_types_{{ $k }}" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ lzs_lang('lzscms::public.close')}}" data-switchx-ontext="{{ lzs_lang('lzscms::public.open')}}" data-hstui-switchx {{ @Lzs_ifCheck($config['types'][$k]['status']) }} data-switchx-text="types_{{ $k }}"/>
            <div class="hstui-form-input-tips" >日发限制：{{$v['num'] }} {{ $v['desc'] }}</div>
          <div class="hstui-u-sm-12 hstui-form-input">
              <textarea class="hstui-input hstui-textarea hstui-length-5" style="height: 110px;" name="types[{{ $k }}][content]" id="lzscms_content_{{ $k }}">{{ @$config['types'][$k]['content'] }}</textarea>
            <div class="hstui-form-input-tips" data-tips="{!! $v['descs'] !!}">{!! $v['descs'] !!}</div>
          </div>
          </div>
        </div>
        @endforeach
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