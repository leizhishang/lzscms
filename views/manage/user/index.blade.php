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
                <th width="20%" >{{ lzs_lang('lzscms::public.username') }}</th>
                <th width="10%" >{{ lzs_lang('lzscms::public.role') }}</th>
                <th width="10%">{{ lzs_lang('lzscms::public.realname') }}</th>
                <th width="15%">{{ lzs_lang('lzscms::public.email') }}</th>
                <th width="15%">{{ lzs_lang('lzscms::public.mobile') }}</th>
                <th width="10%">qq</th>
                <th width="10%">{{ lzs_lang('lzscms::public.weixin') }}</th>
                <th width="10%">{{ lzs_lang('lzscms::public.status') }}</th>
                <th>{{ lzs_lang('lzscms::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($users)
            @foreach($users as $v)
            <tr>
                <td>{!! $v['username'] !!}</td>
                <td>{!! @$roles[$v['gid']]['name'] !!}</td>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['email'] !!}</td>
                <td>{!! $v['mobile'] !!}</td>
                <td>{!! $v['qq'] !!}</td>
                <td>{!! $v['weixin'] !!}</td>
                <td>@if($v['status']){!! lzs_lang('lzscms::public.disable') !!}@else{!! lzs_lang('lzscms::public.normal') !!}@endif</td>
                <td width="40%">
                    <a class="btn btn-xs btn-info J_dialog" title="{{ lzs_lang('lzscms::public.update')}}{!! $v['name'] !!}{{ lzs_lang('lzscms::public.data')}}" href="{!! route('manageUserEdit',['uid'=>$v['uid']]) !!}"><i class="hstui-icon hstui-icon-compose"></i>{{ lzs_lang('lzscms::public.update')}}</a>
                    <a class="btn btn-xs btn-danger J_ajax_del" href="{!! route('manageUserDelete',['uid'=>$v['uid']]) !!}"><i class="hstui-icon hstui-icon-trash"></i>{{ lzs_lang('lzscms::public.delete')}}</a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="8">{!! lzs_lang('lzscms::public.no.list') !!}</td>
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