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
          <th >{{ lzs_lang('lzscms::manage.role.name') }}</th>
          <th width="20%">{{ lzs_lang('lzscms::public.operation') }}</th>
        </tr>
      </thead>
      <tbody>
        @if(count($roles))
        @foreach($roles as $v)
        <tr>
          <td>{!! $v['name'] !!}</td>
          <td width="20%">
            <a class="btn btn-xs btn-info" title="{{ lzs_lang('lzscms::public.update')}}" href="{!! route('manageRoleEdit',['id'=>$v['id']]) !!}"><i class="hstui-icon hstui-icon-compose"></i>{{ lzs_lang('lzscms::public.update')}}</a>
            <a class="btn btn-xs btn-danger J_ajax_del" href="{!! route('manageRoleDelete',['id'=>$v['id']]) !!}"><i class="hstui-icon hstui-icon-trash"></i>{{ lzs_lang('lzscms::public.delete')}}</a>
          </td>
        </tr>
        @endforeach
        @else
        <tr>
          <td colspan="2">{!! lzs_lang('lzscms::public.no.list') !!}</td>
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