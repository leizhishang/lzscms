<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
<style>
</style>
</head>
<body>
<div class="hstui-form hstui-form-horizontal">
    {{ lzs_csrf() }}
    <div class="hstui-frame">
      <div class="hstui-frame-content" style="position: relative; padding: 0px;">
        @if(!$isview)<input type="text" class="hstui-input hstui-length-6 J_input_ajax_list" name="" id="tipinput" style="margin-right: 5px;height: 40px; position: absolute; top: 20px;right: 20px;z-index: 8888">@endif
        <div id="container" style="width: 100%; min-height: 500px;"></div>
      </div>
    </div>
    @if(!$isview)
    <div class="hstui-form-button">
        <button class="hstui-button " id="J_dialog_close">{{ lzs_lang('lzscms::public.cancel')}}</button>
        <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn" data-dialog="1">{{ lzs_lang('lzscms::public.submit')}}</button>
    </div>
    @endif
</div>
<input type="hidden" id="lzscms_lng" value="{{ $lng }}" >
<input type="hidden" id="lzscms_lat" value="{{ $lat }}" >

<script src="https://webapi.amap.com/maps?v=1.4.10&key=74128c0720844bc5b41eb48f83971372&plugin=AMap.Autocomplete"></script>
<script>
var name = '{{ $name }}',lng = '{{ $lng }}', lat = '{{ $lat }}', zoom = {!! $zoom !!}, city = '{{ $city }}', title = '{{ $title }}';
    var map = new AMap.Map('container', {
        resizeEnable: true,
        zoom: zoom
    });  
    map.plugin(["AMap.ToolBar"], function() {
        map.addControl(new AMap.ToolBar());
    });
    if(lng && lat) {
      map.setZoomAndCenter(zoom, [lng, lat]);
    }
    if(city) {
      map.setCity(city);
    }
    map.on('click', function(e) {
      addMarker(e.lnglat.getLng(), e.lnglat.getLat());
    });
    function addMarker(lng, lat) {
        map.clearMap();
        var marker = new AMap.Marker({
            icon: "https://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
            position: [lng, lat]
        });
        if(title) {
          marker.setLabel({
            offset: new AMap.Pixel(20, 20),
            content: "<div class='info'>" + title + "</div>"
          });
        } else {
          marker.setLabel({
            offset: new AMap.Pixel(20, 20),
            content: "<div class='info'>" + lng + ", " + lat + "</div>"
          });
        }
        $("#lzscms_lng").val(lng);
        $("#lzscms_lat").val(lat);
        map.add(marker);
    }
    map.on("complete", function(){
    });
</script>
<script>
Hstui.use('jquery','common', 'inputList',function() {
      if(lng && lat) {
        addMarker(lng, lat);
      }

  Hstui.css('inputList', function(){
    $('.J_input_ajax_list').inputList({
      'url':'',
      'item': true,
      'ajax':function(keywords, options, oDiv) {
        autoInput(keywords, oDiv, options);
      },
      'callback': function(text, item, obj) {
        
        if(typeof(item.location.lng) == 'number') {
          map.setZoomAndCenter(zoom, [item.location.lng, item.location.lat]);
          addMarker(item.location.lng, item.location.lat)
        } else {
          map.setCity(item.name);
        }
      }
    });
  });
  $('.J_ajax_submit_btn').on('click', function() {
    window.parent.document.getElementById('lzscms_'+name+'_lng').value = $("#lzscms_lng").val();
    window.parent.document.getElementById('lzscms_'+name+'_lat').value = $("#lzscms_lat").val();
    window.parent.document.getElementById('J_html_'+name).innerHTML = $("#lzscms_lng").val() + ',' + $("#lzscms_lat").val();
    window.parent.Hstui.dialog.closeAll();
  });
});
// 获取输入提示信息
function autoInput(keywords, oDiv, o){
  AMap.plugin('AMap.Autocomplete', function(){
    var autoOptions = {
      city: '全国'
    }
    var autoComplete = new AMap.Autocomplete(autoOptions);
    autoComplete.search(keywords, function(status, result) {
      console.log(result);
      oDiv.find('.J_input_ajax_list_loading').hide();
      var html = '';
      if(result.tips.length) {
        $(result.tips).each(function(i, v) {
          if(o.item) {
            html += '<li data-text="' + v.name + '" data-item=\'' + JSON.stringify(v) + '\'>' + v.name + '<span>'+v.district+'</span>' + '</li>';
          } else {
            html += '<li data-text="' + v.name + '" data-item="">' + v.name + '</li>';
          }
        });
        oDiv.find('p').html(o.ptips).css('margin-left', '-' + (oDiv.find('.J_input_ajax_list_box p').width() / 2) + 'px').hide();
        oDiv.find('ul').html(html).show();
      } else {
        oDiv.find('p').html(o.nodata).css('margin-left', '-' + (oDiv.find('.J_input_ajax_list_box p').width() / 2) + 'px').show();
        if(o.callback != null) {
          o.callback('', null, options, _this);
        }
      }
    })
  })
}
</script>
</body>
</html>