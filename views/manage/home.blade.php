<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="hstui-content">
    {!! lzscms_hook('s_manage_home') !!}
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>