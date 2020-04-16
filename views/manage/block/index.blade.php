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
                    <th >{{ lzs_lang('lzscms::public.calls') }}</th>
                    <th width="10%" >{{ lzs_lang('lzscms::public.operation') }}</th>
                </tr>
            </thead>
            <tbody>
                @if(count($list))
                @foreach($list as $v)
                <tr>
                    <td>{!! $v['id'] !!}</td>
                    <td>{!! $v['name'] !!}</td>
                    <td>&#123;&#33;&#33; lzs_block( {{$v['id']}} ) &#33;&#33;&#125;</td>
                    <td>
                       <a href="{{ route('manageBlockDelete', ['id'=>$v['id'], 'module'=>$module]) }}" class="J_ajax_del" style="margin-right: 5px;">{{ lzs_lang('lzscms::public.delete') }}</a>
                       <a class="J_dialog" title="{{ lzs_lang('lzscms::public.edit') }}" href="{{ route('manageBlockEdit', ['id'=>$v['id'], 'module'=>$module]) }}">{{ lzs_lang('lzscms::public.edit') }}</a>
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
        <div class="table-footer"><div class="J_listPage hstui-fr">{!! $list->appends($args)->links() !!}</div></div>
    </div>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>