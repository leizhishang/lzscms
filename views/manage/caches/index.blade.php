<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
{!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageCachesSave') }}" method="post">
    {!! lzs_csrf() !!} 
    <div class="hstui-frame">
      <div class="hstui-frame-title">{{ lzs_lang('lzscms::manage.caches.driver') }}</div>
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('request')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.selection.driver') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
                <div class="hstui-u-sm-12">
                      <input name="driver" value="file" type="radio"  {{ lzs_ifCheck(lzs_value('driver', $config) == 'file') }} />
                      <span>{{ lzs_lang('lzscms::manage.caches.driver.file') }}</span>
                  <div class="hstui-form-input-tips" id=""></div>
                </div>
                <div class="hstui-u-sm-12">
                      <label class="hstui-fl hstui-u-sm-5" style="padding: 0px">
                      <input name="driver" value="memcached" type="radio"  {{ lzs_ifCheck(lzs_value('driver', $config) == 'memcached') }}  />
                      <span>memcached</span>
                      </label>
                <div class="hstui-form-input-tips" id="" data-tips="">{!! lzs_lang('lzscms::manage.caches.driver.memcached.tips') !!}</div>
              </div>
                <div class="hstui-u-sm-12">
                      <label class="hstui-fl hstui-u-sm-5" style="padding: 0px">
                      <input name="driver" value="redis" type="radio"  {{ lzs_ifCheck(lzs_value('driver', $config) == 'redis') }}  />
                      <span>redis</span>
                      </label>
                <div class="hstui-form-input-tips" id="" data-tips="">{!! lzs_lang('lzscms::manage.caches.driver.redis.tips') !!}</div>
              </div>
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