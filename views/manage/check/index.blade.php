<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
    <table class="hstui-table hstui-table-bordered hstui-table-radius hstui-table-striped hstui-table-hover hstui-table-compact hstui-text-nowrap">
           <thead class="hstui-table-head">
                <tr>
                    <th width="80" ></th>
                    <th width="" >{{ lzs_lang('lzscms::manage.check.items') }}</th>
                    <th width="" >{{ lzs_lang('lzscms::manage.check.result') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($step as $v)
                <tr>
                    <td><i class="hstui-icon hstui-spinner"></i></td>
                    <td>{{ lzs_lang('lzscms::manage.'.$v['1']) }}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>  
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>