<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body style="width: 600px; height: 600px;">
<div class="hstui-scrollable-vertical" style="height: 600px;">
  <table class="hstui-table">
    <thead>
      <tr>
        <td>{{ lzs_lang('lzscms::public.username')}}</td>
        <td>{!! $info['username'] !!}</td>
      </tr>
      <tr>
        <td>{!! lzs_lang('lzscms::public.operation', 'lzscms::public.times') !!}</td>
        <td>{!! Lzs_time2str($info['times'], 'Y-m-d H:i:s') !!}</td>
      </tr>
      <tr>
        <td>{!! lzs_lang('lzscms::public.operation') !!}IP</td>
        <td>{!! $info['ip'] !!}:{!! $info['port'] !!}</td>
      </tr>
      <tr>
        <td>{!! lzs_lang('lzscms::public.operation','lzscms::public.operating.system') !!}</td>
        <td>{!! $info['platform'] !!}</td>
      </tr>
      <tr>
        <td>{!! lzs_lang('lzscms::public.operation','lzscms::public.browser') !!}</td>
        <td>{!! $info['browser'] !!}</td>
      </tr>
      <tr>
        <td>{!! lzs_lang('lzscms::public.remark') !!}</td>
        <td>{!! $info['remark'] !!}</td>
      </tr>
      <tr>
        <td>{!! lzs_lang('lzscms::public.olddata') !!}</td>
        <td>
          <table class="hstui-table">
            <thead>
              @foreach($info['olddata'] as $key=>$val)
              <tr>
                <td>{!! $key !!}</td>
                <td>{!! $val !!}</td>
              </tr>
              @endforeach
            </thead>
          </table>
        </td>
      </tr>
      <tr>
        <td>{!! lzs_lang('lzscms::public.newdata') !!}</td>
        <td>
          <table class="hstui-table">
            <thead>
              @foreach($info['newdata'] as $key=>$val)
              <tr @if(isset($info['olddata'][$key]) && $info['newdata'][$key] != $info['olddata'][$key]) style="color: red" @endif>
                <td>{!! $key !!}</td>
                <td>{!! $val !!}</td>
              </tr>
              @endforeach
            </thead>
          </table>
        </td>
      </tr>
    </thead>
  </table>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>