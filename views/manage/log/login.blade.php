<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
    {!! $navs !!}
    <div class="manage-search">
      <input class="hstui-input hstui-length-3" id="search-username" placeholder="{!! lzs_lang('lzscms::public.enter.one.username') !!}" />
      <input class="hstui-input hstui-length-2" id="search-ip" placeholder="{!! lzs_lang('lzscms::public.enter.one.ip') !!}" />
      <input class="hstui-input hstui-length-3 J_datetime" id="search-stime" placeholder="{!! lzs_lang('lzscms::public.stime') !!}" />
      <input class="hstui-input hstui-length-3 J_datetime" id="search-etime" placeholder="{!! lzs_lang('lzscms::public.etime') !!}" />
      <a href="javascript:;" class="hstui-button hstui-button-default hstui-button-xs J_search">{{ lzs_lang('lzscms::public.search') }}</a>
    </div>
    <div class="table-main">
        <table class="hstui-table hstui-table-striped hstui-table-bordered hstui-table-compact hstui-text-nowrap" cellspacing="0" width="100%" id="dataTable">
            <thead class="hstui-table-head">
               <tr>
        	        <th width="10%" >{!! lzs_lang('lzscms::public.username') !!}</th>
        	        <th width="12%" >{!! lzs_lang('lzscms::public.times') !!}</th>
        	        <th width="12%" >ip</th>
        	        <th width="10%" >platform</th>
        	        <th width="10%" >browser</th>
        	        <th width="" >{!! lzs_lang('lzscms::public.note') !!}</th>
                </tr>
            </thead>
            <tbody id="list">
            </tbody>
        </table>
         <div class="table-footer"><div class="J_listPage hstui-fr"></div></div>
    </div>
</div>
<script type="text/html" id="listTpl">
    [: for(i=0; i < data.length; i++){ :]
          <tr>
            <td>[:=data[i]['username']:]</td>
            <td>[:=data[i]['times']:]</td>
            <td>[:=data[i]['ip']:]:[:=data[i]['port']:]</td>
            <td>[:=data[i]['platform']:]</td>
            <td>[:=data[i]['browser']:]</td>
            <td>[:=data[i]['remark']:]</td>
        </tr>
      [:}:]
</script>
<script>
Hstui.use('jquery','common',function() {
  var listdata = Hstui.listData({
    url: '{!! route('manageLogLogin') !!}',
    col: 6,
    loadPage: true
  }, function(){
    Hstui.dataTable('#dataTable', {
      scrollY: Hstui.dataTableHW(),
      scrollX: true
    }, function() {
      Hstui.dataTableHW();
    });
  });
  $(".J_search").on('click',function(){
    listdata.data['ip'] = $('#search-ip').val();
    listdata.data['username'] = $('#search-username').val();
    listdata.data['stime'] = $('#search-stime').val();
    listdata.data['etime'] = $('#search-etime').val();
    listdata.loadPage = true;
    Hstui.listData(listdata);
  });
});
</script>
</body>
</html>