<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
{!! $navs !!}
  <div class="manage-search">
        <form action="{{ route('manageFormContent', ['formid'=>$formid]) }}" method="get">
        <input class="hstui-input hstui-length-1" id="search-uid" name="uid" value="{!! lzs_value('uid', $args) !!}" placeholder="UID" />
        <input class="hstui-input hstui-length-3 J_datetime" name="stime" value="{!! lzs_value('stime', $args) !!}" id="search-stime" placeholder="{!! lzs_lang('lzscms::public.stime') !!}" />
        <input class="hstui-input hstui-length-3 J_datetime" name="etime" value="{!! lzs_value('etime', $args) !!}" id="search-etime" placeholder="{!! lzs_lang('lzscms::public.etime') !!}" />
        <button type="submit" class="hstui-button hstui-button-default hstui-button-xs J_search">{{ lzs_lang('lzscms::public.search') }}</button>
        </form>
    </div>
<div class="table-main">
    <table class="hstui-table hstui-table-bordered hstui-table-radius hstui-table-striped hstui-table-hover hstui-table-compact hstui-text-nowrap">
       <thead class="hstui-table-head">
            <tr>
                <th width="50" >{{ lzs_lang('ID') }}</th>
                <th width="60" >{{ lzs_lang('UID') }}</th>
                <th width="160">{{ lzs_lang('lzscms::public.times') }}</th>
                @foreach($showFields as $key=>$field)
                <th width="">{{ $field['name'] }}</th>
                @endforeach
                <th width="120" >{{ lzs_lang('lzscms::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if(count($list))
            @foreach($list as $v)
            <tr>
                <td>{!! $v['id'] !!}</td>
                <td>{!! (int)$v['created_uid'] !!}</td>
                <td>{!! lzs_time2str($v['created_time'], 'Y-m-d H:i:s') !!}</td>
                @foreach($showFields as $key=>$field)
                <td>@if(isset($v[$field['fieldname'].'_str'])){{$v[$field['fieldname'].'_str']}}@else{{ @$v[$field['fieldname']] }}@endif</td>
                @endforeach
                <td>
                    <a href="{{ route('manageFormContentDelete', ['formid'=>$formid, 'id'=>$v['id']]) }}" class="J_ajax_del"  style="margin-right: 5px;">{{ lzs_lang('lzscms::public.delete') }}</a>
                    <a href="{{ route('manageFormContentEdit', ['formid'=>$formid, 'id'=>$v['id']]) }}" style="margin-right: 5px;">{{ lzs_lang('lzscms::public.edit') }}</a>                    
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
    <div class="table-footer"><div class="J_listPage hstui-fr">{!! $list->appends($args)->links() !!}</div></div>
</div>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>