<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
<style>
.hstui-attach-list{
    width: 100%;
    overflow: hidden;
    border: 1px solid #ddd;
    min-height: 600px;
}
.hstui-attach-list ul{
    padding: 5px;
}
.hstui-attach-list ul li{
    /*width: 200px;*/
    height: 200px;
    float: left;
    border: 1px solid #ddd;
    margin-right: 10px;
    margin-bottom: 10px;
    text-align:center;
    /*padding: 2px;*/
    line-height: 198px;
    position: relative;
}
.hstui-attach-list ul li img{
    width: 100%;
    max-width: 198px;
    /*max-height: 198px;*/
    max-height: 200px;
    overflow: hidden;
}
.hstui-attach-list ul li .J_dialog>i{
    font-size: 30px;
}
.hstui-attach-list ul li .view {
    position: absolute;
    top: 10px;
    right: 10px;
    line-height: initial;
    width: 30px;
    height: 30px;
    line-height: 30px;
     border-radius: 50%;
    border: 1px solid #ddd;
}
</style>
</head>
<body>
<div class="manage-content">
{!! $navs !!}
    <div class="manage-search">
        <form action="{{ route('manageAttachManage') }}" method="get">
            <input type="hidden" name="type" value="{{ $args['type'] }}">
            <input class="hstui-input hstui-length-2" id="search-aid" name="aid" value="{!! lzs_value('aid', $args) !!}" placeholder="AID" />
            <input class="hstui-input hstui-length-2" id="search-uid" name="uid" value="{!! lzs_value('uid', $args) !!}" placeholder="UID" />
            <input class="hstui-input hstui-length-3" id="search-name" name="name" value="{!! lzs_value('name', $args) !!}" placeholder="{!! lzs_lang('lzscms::public.name') !!}" />
            <input class="hstui-input hstui-length-2" id="search-app" name="app" value="{!! lzs_value('app', $args) !!}" placeholder="APP" />
            <input class="hstui-input hstui-length-2" id="search-appid" name="appid" value="{!! lzs_value('appid', $args) !!}" placeholder="APPID" />
            <!-- <input class="hstui-input hstui-length-3 J_datetime" name="stime" value="{!! lzs_value('stime', $args) !!}" id="search-stime" placeholder="{!! lzs_lang('lzscms::public.stime') !!}" /> -->
            <!-- <input class="hstui-input hstui-length-3 J_datetime" name="etime" value="{!! lzs_value('etime', $args) !!}" id="search-etime" placeholder="{!! lzs_lang('lzscms::public.etime') !!}" /> -->
            <button type="submit" class="hstui-button hstui-button-default hstui-button-xs J_search">{{ lzs_lang('lzscms::public.search') }}</button>
            <div class="hstui-fr">
                <a href="{{ route('manageAttachManage', ['type'=>1]) }}" style="margin-right: 10px;"><i class="hstui-icon hstui-icon-class"></i></a>
                <a href="{{ route('manageAttachManage', ['type'=>0]) }}"><i class="hstui-icon hstui-icon-list1" style="font-size: 20px;"></i></a>
            </div>
        </form>
    </div>
<div class="table-main">
    @if(!$type)
    <table class="hstui-table hstui-table-bordered hstui-table-radius hstui-table-striped hstui-table-hover hstui-table-compact hstui-text-nowrap">
       <thead class="hstui-table-head">
            <tr>
                <th width="80" >{{ lzs_lang('AID') }}</th>
                <th width="80" >{{ lzs_lang('UID') }}</th>
                <th width="80" >{{ lzs_lang('APP') }}</th>
                <th width="80" >{{ lzs_lang('APPID') }}</th>
                <th width="20%" >{{ lzs_lang('lzscms::public.name') }}</th>
                <th >{{ lzs_lang('lzscms::public.type') }}</th>
                <th >{{ lzs_lang('lzscms::public.size') }}</th>
                <th >{{ lzs_lang('lzscms::public.times') }}</th>
                <th width="10%" >{{ lzs_lang('lzscms::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if(count($list))
            @foreach($list as $v)
            <tr>
                <td>{!! $v['aid'] !!}</td>
                <td>{!! $v['created_userid'] !!}</td>
                <td>{!! $v['app'] !!}</td>
                <td>@if($v['appid']){!! $v['appid'] !!}@else - @endif</td>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['type'] !!}</td>
                <td>{!! Lzs_byte_format($v['size']) !!}</td>
                <td>{!! Lzs_time2str($v['created_time']) !!}</td>
                <td>
                   <a class="J_dialog" title="{{ lzs_lang('lzscms::public.view') }}" href="{{ route('manageAttachView', ['aid'=>$v['aid']]) }}">{{ lzs_lang('lzscms::public.view') }}</a>
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
    @else
        <div class="hstui-attach-list">
            <ul>
            @if(count($list))
            @foreach($list as $v)
                <li class="J_tooltips" data-tooltips-content="{{$v['name']}}</br>{!! lzs_byte_format($v['size']) !!}">
                    @if(in_array($v['type'], ['jpeg', 'jpg', 'png', 'gif']))
                    <a href="{{ $v['url'] }}" target="_b" class="view"><i class="hstui-icon hstui-icon-eye"></i></a>
                    @endif
                   <a class="J_dialog" title="{{ lzs_lang('lzscms::public.view') }}" href="{{ route('manageAttachView', ['aid'=>$v['aid']]) }}"> 
                    @if(in_array($v['type'], ['jpeg', 'jpg', 'png', 'gif']))
                    <img src="{{ $v['url'] }}">
                    @endif
                    @if($v['type'] == 'zip')
                        <i class="hstui-icon hstui-icon-zip"></i>
                    @endif
                    @if($v['type'] == 'pdf')
                        <i class="hstui-icon hstui-icon-pdf"></i>
                    @endif
                    @if($v['type'] == 'exl')
                        <i class="hstui-icon hstui-icon-exl"></i>
                    @endif
                    </a>
                </li>
            @endforeach
            @else

            @endif
            </ul>
        </div>
    @endif
    <div class="table-footer"><div class="J_listPage hstui-fr">{!! $list->appends($args)->links() !!}</div></div>
</div>
</div>
<script>
Hstui.use('jquery','common',function() {
  initHw(function(h){
  });
});

window.onresize = function(){
  initHw(function(h){
  });
}
function initHw(c){
  var lh = $('.hstui-attach-list').height();
  var lw = $('.hstui-attach-list').width();
  $('.hstui-attach-list ul li').width((lw - 40 - 40)/5);
  $('.hstui-attach-list ul li img').css('max-width', (lw - 40 - 40)/5);
  for (var i = 1; i <= $('.hstui-attach-list ul li').length; i++) {
      if(i%5 == 0) {
        $('.hstui-attach-list ul li').eq(i-1).css('margin-right', '0px');
      }
  }
  if(c){
    c(lh);
  }
}
</script>
</body>
</html>