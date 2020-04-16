<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
{!! $navs !!}
<div class="table-main">

  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manageFieldsSave') }}" method="post">
    {!! lzs_csrf() !!} 
    <input type="hidden" name="rname" value="{{ $rname }}">
    <input type="hidden" name="relatedid" value="{{ $relatedid }}">
    <table class="hstui-table hstui-table-bordered hstui-table-radius hstui-table-striped hstui-table-hover hstui-table-compact hstui-text-nowrap">
       <thead class="hstui-table-head">
            <tr>
                <th width="60" >{{ lzs_lang('lzscms::public.vieworder') }}</th>
                <th width="20%" >{{ lzs_lang('lzscms::public.name') }}</th>
                <th >{{ lzs_lang('lzscms::manage.fields.name') }}</th>
                <th >{{ lzs_lang('lzscms::public.type') }}</th>
                <th >{{ lzs_lang('lzscms::public.main.table') }}</th>
                <th >{{ lzs_lang('lzscms::manage.fields.ismember') }}</th>
                <th >{{ lzs_lang('lzscms::public.status') }}</th>
                <th width="10%" >{{ lzs_lang('lzscms::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($list)
            @foreach($list as $v)
            <tr>
                <td><input type="text" name="vieworder[{{$v['id']}}]" value="{!! $v['vieworder'] !!}" class="hstui-length-1 hstui-input"></td>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['fieldname'] !!}</td>
                <td>{!! $v['fieldtype'] !!}</td>
                <td>@if($v['ismain']) {{ lzs_lang('lzscms::public.yes') }} @else - @endif</td>
                <td>@if($v['ismember']) {{ lzs_lang('lzscms::public.opens') }} @else - @endif</td>
                <td>@if(!$v['disabled']) {{ lzs_lang('lzscms::public.opens') }} @else {{ lzs_lang('lzscms::public.closes') }} @endif</td>
                <td>
                   <a href="{{ route('manageFieldsDelete', ['id'=>$v['id']]) }}" class="J_ajax_del" style="margin-right: 5px;">{{ lzs_lang('lzscms::public.delete') }}</a>
                   <a  href="{{ route('manageFieldsEdit', ['id'=>$v['id'], 'rname'=>$rname, 'relatedid'=>$relatedid]) }}">{{ lzs_lang('lzscms::public.edit') }}</a>
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
    @if($list)
    <div class="hstui-form-group">
      <div class="hstui-u-sm-12">
        <button type="submit" class="hstui-button hstui-button-default J_ajax_submit_btn">{{ lzs_lang('lzscms::public.submit') }}</button>
      </div>
    </div>
    @endif
    </form>
</div>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>