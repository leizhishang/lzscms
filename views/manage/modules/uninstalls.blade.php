<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
    {!! $navs !!}
    <div class="table-main">
        <table class="hstui-table hstui-table-radius hstui-table-striped hstui-text-nowrap" cellspacing="0" width="100%" id="dataTable">
           <thead class="hstui-table-head">
               <tr>
                  <th width="" >{!! lzs_lang('lzscms::public.name') !!}</th>
                  <th width="12%" >{!! lzs_lang('lzscms::public.ename') !!}</th>
                  <th width="10%" >{!! lzs_lang('lzscms::public.version') !!}</th>
                  <th width="" >{!! lzs_lang('lzscms::public.description') !!}</th>
                  <th width="30" >{!! lzs_lang('lzscms::public.operation') !!}</th>
                </tr>
            </thead>
            <tbody id="list">
            @if($list)
            @foreach($list as $v)
               <tr>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['slug'] !!}</td>
                <td>{!! $v['version'] !!}</td>
                <td>{!! $v['description'] !!}</td>
                <td><a href="{!! route('manageModulesDoinstalls', ['slug'=>$v['slug']]) !!}" class="J_confirm" data-msg="{{ lzs_lang('lzscms::manage.modules.install.tips') }}">{!! lzs_lang('lzscms::public.install') !!}</a></td>
              </tr>
            @endforeach
            @else
            <tr>
              <td colspan="6">{{ lzs_lang('lzscms::public.no.list') }}</td>
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