<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
{!! $navs !!}
    <div class="manage-search">
        <form action="{{ route('manageSmsLog') }}" method="get">
        <select name="type" id="search-type" >
            <option value="0" {!! lzs_isSelected(!$args['type']) !!}>{!! lzs_lang('lzscms::public.unlimited') !!}</option>
            @foreach($types as $k=>$v)
            <option value="{!! $k !!}" {!! lzs_isSelected($args['type'] == $k) !!}>{!! $v['name'] !!}</option>
            @endforeach
        </select>
        <input class="hstui-input hstui-length-2" id="search-uid" name="uid" value="{!! lzs_value('uid', $args) !!}" placeholder="UID" />
        <input class="hstui-input hstui-length-3" name="mobile" value="{!! lzs_value('mobile', $args) !!}" id="search-mobile" placeholder="{!! lzs_lang('lzscms::public.mobile') !!}" />
        <input class="hstui-input hstui-length-3 J_datetime" name="stime" value="{!! lzs_value('stime', $args) !!}" id="search-stime" placeholder="{!! lzs_lang('lzscms::public.stime') !!}" />
        <input class="hstui-input hstui-length-3 J_datetime" name="etime" value="{!! lzs_value('etime', $args) !!}" id="search-etime" placeholder="{!! lzs_lang('lzscms::public.etime') !!}" />
        <button type="submit" class="hstui-button hstui-button-default hstui-button-xs J_search">{{ lzs_lang('lzscms::public.search') }}</button>
        </form>
    </div>
<div class="table-main">
    <table class="hstui-table hstui-table-bordered hstui-table-radius hstui-table-striped hstui-table-hover hstui-table-compact hstui-text-nowrap">
       <thead class="hstui-table-head">
            <tr>
                <th width="7%" >{{ lzs_lang('ID') }}</th>
                <th width="7%" >{{ lzs_lang('lzscms::public.type') }}</th>
                <th width="15%">{{ lzs_lang('lzscms::public.mobile') }}</th>
                <th width="15%">{{ lzs_lang('lzscms::public.content') }}</th>
                <th width="15%">{{ lzs_lang('lzscms::public.captcha') }}</th>
                <th width="7%" >{{ lzs_lang('UID') }}</th>
                <th width="15%">{{ lzs_lang('lzscms::public.times') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($list)
            @foreach($list as $v)
            <tr>
                <td>{!! $v['id'] !!}</td>
                <td>{!! $types[$v['type']]['name'] !!}</td>
                <td>{!! $v['mobile'] !!}</td>
                <td>{!! $v['content'] !!}</td>
                <td>@if($v['code']){!! $v['code'] !!}@else - @endif</td>
                <td>{!! (int)$v['uid'] !!}</td>
                <td>{!! lzs_time2str($v['times'], 'Y-m-d H:i:s') !!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="10">{!! lzs_lang('lzscms::public.no.list') !!}</td>
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