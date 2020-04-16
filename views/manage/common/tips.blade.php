<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
	<div class="hstui-frame manage-tips">
		<div class="hstui-frame-title">
			{!! lzs_lang('lzscms::public.tips.title') !!}
		</div>
		<div class="hstui-frame-content">
			<p>{{ $message }}</p>
			<a class="J_tips"><em style="color: red;" id="t">(5)</em>{!! lzs_lang('lzscms::public.tips.tiao') !!}</a>
		</div>
	</div>
</div>
<script>
var referer = '{!! $referer !!}';
var withs = {!! $with !!};
Hstui.use('jquery','common',function() {
	if(window.parent.Hstui.dialog && withs == 4) {
		$("body").css('width', '390px').css('height', '200px');
		$(".hstui-frame-title").remove();
		$(".manage-tips").removeClass('manage-tips').addClass('manage-tips-dialog');
		if(referer) {
			var t = 5;
		    setInterval(function () {
		    	t--;
		    	$("#t").html('('+t+')');
		    	if(t == 1) {
		    		window.parent.location.href = decodeURIComponent(referer);
		    	}
		    }, 1000);
		    $(".J_tips").on('click',function() {
		    	window.parent.location.href = decodeURIComponent(referer);
		    });
	    } else{
			var t = 5;
		    setInterval(function () {
		    	t--;
		    	$("#t").html('('+ t +')');
		    	if(t == 1) {
					window.parent.Hstui.dialog.closeAll();
		    	}
		    }, 1000);
		    $(".J_tips").on('click',function(){
		    	window.parent.Hstui.dialog.closeAll();
		    });
	    }
	} else {
		if(referer) {
			var t = 5;
		    setInterval(function () {
		    	t--;
		    	$("#t").html('('+t+')');
		    	if(t == 1) {
		    		window.location.href = referer; 
		    	}
		    }, 1000);
		    $(".J_tips").on('click',function(){
		    	window.location.href = referer;
		    });
	    }
	}
});
</script>
</body>
</html>