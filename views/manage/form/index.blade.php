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
                <th width="20%" >{{ lzs_lang('lzscms::manage.form.name') }}</th>
                <th >{{ lzs_lang('lzscms::manage.form.table') }}</th>
                <th >{{ lzs_lang('lzscms::manage.form.field') }}</th>
                <th >{{ lzs_lang('lzscms::manage.form.email.notice') }}</th>
                <th >{{ lzs_lang('lzscms::manage.form.mobile.notice') }}</th>
                <th >{{ lzs_lang('lzscms::public.times') }}</th>
                <th >{{ lzs_lang('lzscms::manage.form.content') }}</th>
                <th width="10%" >{{ lzs_lang('lzscms::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($list)
            @foreach($list as $v)
            <tr>
                <td>{!! $v['id'] !!}</td>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['table'] !!}</td>
                <td><a class="J_linkframe_trigger" data-id="form-fields-{{ $v['id'] }}" data-name="[{!! $v['name'] !!}]{{ lzs_lang('lzscms::manage.form.field') }}" href="{{ route('manageFieldsIndex', ['rname'=>'form', 'relatedid'=>$v['id']]) }}">{{ lzs_lang('lzscms::public.view') }}</a></td>
                <td>@if(isset($v['setting']['email']) && $v['setting']['email']){{ $v['setting']['email'] }}@else - @endif</td>
                <td>@if(isset($v['setting']['mobile']) && $v['setting']['mobile']){{ $v['setting']['mobile'] }}@else - @endif</td>
                <td>{!! $v['times_str'] !!}</td>
                <td> <a class="J_linkframe_trigger" data-id="form-content-{{ $v['id'] }}" data-name="[{!! $v['name'] !!}]{{ lzs_lang('lzscms::manage.form.content') }}" href="{{ route('manageFormContent', ['formid'=>$v['id']]) }}">{{ lzs_lang('lzscms::public.manage') }}</a> </td>
                <td>
                   <a href="{{ route('manageFormDelete', ['id'=>$v['id'], 'module'=>$module, 'relatedid'=>$relatedid]) }}" data-msg="{{ lzs_lang('lzscms::manage.form.delete.msg') }}" class="J_ajax_del" style="margin-right: 5px;">{{ lzs_lang('lzscms::public.delete') }}</a>
                   <a class="J_dialog" title="{{ lzs_lang('lzscms::public.edit') }}" href="{{ route('manageFormEdit', ['id'=>$v['id'], 'module'=>$module, 'relatedid'=>$relatedid ]) }}">{{ lzs_lang('lzscms::public.edit') }}</a>
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