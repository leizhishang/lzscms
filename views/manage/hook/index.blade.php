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
                <th width="20%" >{{ lzs_lang('lzscms::hook.name') }}</th>
                <th width="20%" >{{ lzs_lang('lzscms::hook.module') }}</th>
                <th >{{ lzs_lang('lzscms::public.times') }}</th>
                <th width="10%" >{{ lzs_lang('lzscms::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($list)
            @foreach($list as $v)
            <tr>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['module'] !!}</td>
                <td>{!! lzs_time2str($v['times']) !!}</td>
                <td>
                    <a class="btn btn-xs btn-info" title="" href="{!! route('manageHookInjectIndex', ['name'=>$v['name']]) !!}">{{ lzs_lang('lzscms::public.view')}}</a>
                    @if($v['issystem'] == 0)
                    <a class="btn btn-xs btn-info J_dialog" title="{{ lzs_lang('lzscms::public.update')}}{!! $v['name'] !!}{{ lzs_lang('lzscms::public.data')}}" href="{!! route('manageHookEdit', ['name'=>$v['name']]) !!}">{{ lzs_lang('lzscms::public.update')}}</a>
                    <a class="btn btn-xs btn-info J_ajax_del" href="{!! route('manageHookDelete', ['name'=>$v['name']]) !!}">{{ lzs_lang('lzscms::public.delete')}}</a>
                    @endif
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="4">{!! lzs_lang('lzscms::public.no.list') !!}</td>
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