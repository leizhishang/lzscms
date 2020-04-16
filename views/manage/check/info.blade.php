<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <div class="hstui-form hstui-form-horizontal" >
    {!! Lzs_csrf() !!} 
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        {!! phpinfo() !!}
      </div>
    </div>    
  </div>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>