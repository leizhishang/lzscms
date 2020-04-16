<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
{!! $navs !!}
<div class="hstui-frame" style="width: 100%; margin-bottom: 10px">
    <div class="hstui-frame-title">{{ lzs_lang('lzscms::public.e.info') }}</div>
    <div class="hstui-frame-content">
        <table class="hstui-table">
            <thead>
                <tr>
                    <td width="10%">{{ lzs_lang('lzscms::hook.name')}}</td>
                <td>{!! $info['name'] !!}</td>
                </tr>
                <tr>
                    <td>{!! lzs_lang('lzscms::public.module') !!}</td>
                    <td>{!! $info['module'] !!}</td>
                </tr>
                <tr>
                    <td>{!! lzs_lang('lzscms::public.add', 'lzscms::public.times') !!}</td>
                    <td>{!! Lzs_time2str($info['times'], 'Y-m-d H:i:s') !!}</td>
                </tr>
                <tr>
                    <td>{!! lzs_lang('lzscms::public.description') !!}</td>
                    <td>{!! $info['description'] !!}</td>
                </tr>
                <tr>
                    <td>{!! lzs_lang('lzscms::hook.document') !!}</td>
                    <td>{!! $info['document'] !!}</td>
                </tr>
            </thead>
        </table>

    </div>
</div>
<div class="table-main">
    <table class="hstui-table hstui-table-compact hstui-text-nowrap">
       <thead class="hstui-table-head">
            <tr>
                <th width="20%" >{{ lzs_lang('lzscms::hook.alias') }}</th>
                <th >{{ lzs_lang('lzscms::hook.description') }}</th>
                <th >{{ lzs_lang('lzscms::hook.files') }}</th>
                <th >{{ lzs_lang('lzscms::hook.class') }}</th>
                <th >{{ lzs_lang('lzscms::hook.fun') }}</th>
                <th >{{ lzs_lang('lzscms::public.times') }}</th>
                <th width="10%" >{{ lzs_lang('lzscms::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($list)
            @foreach($list as $v)
            <tr>
                <td>{!! $v['alias'] !!}</td>
                <td>{!! $v['description'] !!}</td>
                <td>{!! $v['files'] !!}</td>
                <td>{!! $v['class'] !!}</td>
                <td>{!! $v['fun'] !!}</td>
                <td>{!! Lzs_time2str($v['times']) !!}</td>
                <td>
                    @if($v['issystem'] == 0)
                    <a class="btn btn-xs btn-info J_dialog" title="{{ lzs_lang('lzscms::public.update')}}{{ lzs_lang('lzscms::public.data')}}" href="{!! route('manageHookInjectEdit', ['name'=>$v['hook_name'], 'id'=>$v['id']]) !!}">{{ lzs_lang('lzscms::public.update')}}</a>
                    <a class="btn btn-xs btn-info J_ajax_del" href="{!! route('manageHookInjectDelete', ['name'=>$v['hook_name'], 'id'=>$v['id']]) !!}">{{ lzs_lang('lzscms::public.delete')}}</a>
                    @endif
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="7">{!! lzs_lang('lzscms::public.no.list') !!}</td>
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