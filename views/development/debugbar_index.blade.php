<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
<style>
td{
	cursor: pointer;
}
.load-more{
	padding: 10px;
	text-align: center;
}
</style>
</head>
<body>
<div class="manage-content" style="margin-bottom: 20px">
	<!-- <div class="tnav">
		<ul class="cc">
			<li class="current"><a href="{{ route('developmentDebugbarIndex') }}" title="" class="" >调试</a></li>
		</ul>
	</div> -->
	<div class="manage-search">
		<label>Method:</label>
		<select id="search-method">
			<option value="">{{ lzs_lang('lzscms::public.all') }}</option>
			<option value="get">GET</option>
			<option value="post">POST</option>
			<option value="put">PUT</option>
			<option value="delete">DELETE</option>
		</select>
		<label>URL:</label>
	    <input class="hstui-input hstui-length-4" id="search-uri" placeholder="uri" />
		<label>IP:</label>
	    <input class="hstui-input hstui-length-4" id="search-ip" placeholder="IP" />
	    <a href="javascript:;" class="hstui-button hstui-button-default hstui-button-xs J_search">{{ lzs_lang('lzscms::public.search') }}</a>
	</div>
	<div class="table-main">
	    <table class="hstui-table hstui-table-bordered hstui-table-radius hstui-table-striped hstui-table-hover hstui-table-compact hstui-text-nowrap">
	       <thead class="hstui-table-head">
	            <tr>
	                <th width="20%" >Date</th>
	                <th width="10%" >Method</th>
	                <th width="" >URL</th>
	                <th width="10%">IP</th>
	                <th width="15%">Filter data</th>
	            </tr>
	        </thead>
	        <tbody id="list">
	            
	        </tbody>
	    </table>
	</div>
	<div class="load-more" style="display: none;">
		<a class="hstui-button hstui-button-default J_load_more">点击加载更多</a>
	</div>
</div>
<script>
var max = 50;
var offset = 0;
var page = 0;
var url = '{{ route('debugbar.openhandler') }}';
var table = null;
var method = '';
var uri = '';
var ip = '';
Hstui.use('jquery','common',function() {
	table = $('#list');
  	getData(url,{
  		max:max,
  		offset:offset
  	}, function(data) {
	  	if(data.length == 0){
  			table.html('<tr><td colspan="5">{{ lzs_lang('lzscms::public.no.list') }}</td></tr>');
  			return false;
  		}
  		bindHtml(data);
  	});
   	$(".J_search").on('click',function(){
	  	method = $("#search-method").val();
	  	uri = $("#search-uri").val();
	  	ip = $("#search-ip").val();
        table.html('');
        var data = {
		  	max:max,
		  	offset:offset,
		};
		if(method) {
			data['method'] = method;
		}
		if(uri) {
			data['uri'] = uri;
		}
		if(ip) {
			data['ip'] = ip;
		}
		page = 0;
		getData(url,data, function(data){
	  		if(data.length == 0){
	  			table.html('<tr><td colspan="5">{{ lzs_lang('lzscms::public.no.list') }}</td></tr>');
	  			return false;
	  		}
		  	bindHtml(data);
		});
  	});
  	$(".J_load_more").on('click',function(){
   		var _this = $(this);
  		page++;
        var data = {
		  	max:max,
		  	offset:max*page,
		};
		if(method) {
			data['method'] = method;
		}
		if(uri) {
			data['uri'] = uri;
		}
		if(ip) {
			data['ip'] = ip;
		}
		_this.html('加载中...');
		getData(url, data, function(data){
			_this.html('点击加载更多');
	  		if(data.length == 0) {
	  			$(".load-more").hide();
	  			return false;
	  		}
		  	bindHtml(data);
		});
  	})
});
function bindHtml(data, ) {
    $.each(data, function(i, meta) {
        var method = $('<a />')
            .text(meta['method'])
            .on('click', function(e) {
                table.empty();
                table.html('');
				page = 0;
                getData(url, {
                	max:max,
                	offset:offset,
                	method:meta['method']
                },function(data){
	  				if(data.length == 0){
			  			table.html('<tr><td colspan="5">{{ lzs_lang('lzscms::public.no.list') }}</td></tr>');
			  			return false;
			  		}
                	bindHtml(data);
                });
                e.preventDefault();
            });
        var uri = $('<a />')
            .text(meta['uri'])
            .on('click', function(e) {
            	table.find('tr').removeClass('hstui-active');
            	$("#"+meta['id']).addClass('hstui-active');
                getData(url, {
                	op:'get',
                	id:meta['id']
                },function(data){
                	phpdebugbar.addDataSet(data);
                	phpdebugbar.restore();
                	$(".phpdebugbar-open-btn").hide();
                });
                e.preventDefault();
            });

        var ip = $('<a />')
            .text(meta['ip'])
            .on('click', function(e) {
                table.html('');
				page = 0;
                getData(url, {
                	max:max,
                	offset:offset,
                	ip:meta['ip']
                },function(data){
	  				if(data.length == 0){
			  			table.html('<tr><td colspan="5">{{ lzs_lang('lzscms::public.no.list') }}</td></tr>');
			  			return false;
			  		}
                	bindHtml(data);
                });
                e.preventDefault();
            });

        var search = $('<a />')
            .text('Show URL')
            .on('click', function(e) {
                table.html('');
				page = 0;
                getData(url, {
                	max:max,
                	offset:offset,
                	uri:meta['uri']
                },function(data){
	  				if(data.length == 0){
			  			table.html('<tr><td colspan="5">{{ lzs_lang('lzscms::public.no.list') }}</td></tr>');
			  			return false;
			  		}
                	bindHtml(data);
                });
                e.preventDefault();
            });
        $('<tr />').attr('id', meta['id'])
            .append('<td>' + meta['datetime'] + '</td>')
            .append('<td>' + meta['method'] + '</td>')
            .append($('<td />').append(uri))
            .append($('<td />').append(ip))
            .append($('<td />').append(search))
            .appendTo(table);
    });
	$(".load-more").show();
}
function getData(url,  data, callback) {
	Hstui.Util.ajaxMaskShow();
    $.ajax({
        dataType: 'json',
        url: url,
        data: data,
        success: function(data){
        	Hstui.Util.ajaxMaskRemove();
        	callback(data);
        },
        ignoreDebugBarAjaxHandler: true
    });
}
</script>
@include('lzscms::common.foot')
</body>
</html>