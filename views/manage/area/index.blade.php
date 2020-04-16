<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
{!! $navs !!}
<div class="table-main">
    <table class="hstui-table hstui-table-bordered hstui-table-radius hstui-table-striped hstui-table-hover hstui-table-compact hstui-text-nowrap">
       <thead class="hstui-table-head">
            <tr>
                <th width="80" >{{ lzs_lang('ID') }}</th>
                <th width="20%" >{{ lzs_lang('lzscms::public.name') }}</th>
                <th >{{ lzs_lang('lzscms::public.dir') }}</th>
                <th >{{ lzs_lang('lzscms::manage.area.zimu') }}</th>
                <th >{{ lzs_lang('lzscms::manage.area.zip') }}</th>
                <th width="10%" >{{ lzs_lang('lzscms::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($list)
            @foreach($list as $v)
            <tr>
                <td>{!! $v['areaid'] !!}</td>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['joinname'] !!}</td>
                <td>{!! $v['initials'] !!}</td>
                <td>{!! $v['zip'] !!}</td>
                <td>
                   <a href="{{ route('manageAreaDelete', ['areaid'=>$v['areaid']]) }}" class="J_ajax_del" style="margin-right: 5px;">{{ lzs_lang('lzscms::public.delete') }}</a>
                   <a class="J_dialog" title="{{ lzs_lang('lzscms::public.edit') }}" href="{{ route('manageAreaEdit', ['areaid'=>$v['areaid']]) }}">{{ lzs_lang('lzscms::public.edit') }}</a>
                   <a title="{{ lzs_lang('lzscms::public.edit') }}" href="{{ route('manageAreaIndex', ['areaid'=>$v['areaid']]) }}">{{ lzs_lang('lzscms::manage.area.list') }}</a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="9">{!! lzs_lang('lzscms::public.no.list') !!}</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>