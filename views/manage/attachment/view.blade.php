<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="hstui-form hstui-form-horizontal">
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm ">
          <label class="hstui-u-sm-2 hstui-form-label">disk</label>
          <div class="hstui-u-sm-10 hstui-form-input">
            {{ lzs_value('disk', $info) }}
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm ">
          <label class="hstui-u-sm-2 hstui-form-label">AID</label>
          <div class="hstui-u-sm-10 hstui-form-input">
            {{ lzs_value('aid', $info) }}
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm ">
          <label class="hstui-u-sm-2 hstui-form-label">UID</label>
          <div class="hstui-u-sm-10 hstui-form-input">
            @if(lzs_value('created_userid', $info)) {{ lzs_value('created_userid', $info) }} @else - @endif
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm ">
          <label class="hstui-u-sm-2 hstui-form-label">APP</label>
          <div class="hstui-u-sm-10 hstui-form-input">
            {{ lzs_value('app', $info) }}
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm ">
          <label class="hstui-u-sm-2 hstui-form-label">APPID</label>
          <div class="hstui-u-sm-10 hstui-form-input">
            @if(lzs_value('appid', $info)) {{ lzs_value('appid', $info) }} @else - @endif
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm ">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
            {{ lzs_value('name', $info) }}
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm ">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.type') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
            {{ lzs_value('type', $info) }}
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm ">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.size') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
            {!! lzs_byte_format($info['size']) !!}
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm ">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.url') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
            {{ lzs_value('path', $info) }}
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.times') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
            {{ lzs_time2str($info['created_time'], 'Y-m-d H:i:s') }}
          </div>
        </div>
        @if(in_array($info['type'], ['jpeg', 'jpg', 'png', 'gif']))
        <div class="hstui-form-group hstui-form-group-sm">
          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::public.pic') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
           <a href="{{ $info['url'] }}" target="_b">
            <img src="{{ $info['url'] }}" style="width: 200px;">
          </a>
          </div>
        </div>
        @endif
      </div>
      <div class="hstui-form-button">
        
      </div>
    </div>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>