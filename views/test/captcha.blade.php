<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="chrome=1">
	<meta name="viewport" content="initial-scale=0.1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="{{ config('lzscms.resurl') }}/css/hstui.min.css" />
	<title>{!! lzs_lang('captcha::public.captcha') !!}</title>
	<script>
	var G = {
		RES_ROOT: '{{ config('lzscms.resurl') }}',
		TIPS_MESSAGE: {
			STATE : '{!! session('state') !!}',
			MESSAGE : '{!! session('message') !!}',
		}
	}
	</script>
	<script type="text/javascript" src="{{ config('lzscms.resurl') }}/js/hstui.min.js"></script>
	</head>
	<body>
		<img src="{{ route('captchaIndexGet', ['w'=>120, 'h'=>40]) }}" id="code">
		<button  class="hstui-button J_getNewCode">{!! lzs_lang('lzscms::captcha.change.one') !!}</button>
		
		<form action="{{ route('lzscmsCaptchaTestCheck') }}" method="post">
		{{ lzs_csrf() }}
		<input type="text" name="code" class="hstui-input">
		@if($errors->has('code'))
			<p>{!! $errors->first('code') !!}</p>
		@endif
		<button type="submit" class="hstui-button">{!! lzs_lang('lzscms::public.checks') !!}</button>
			
		</form>
	
		<script>
			var codeUrl = '{{ route('captchaIndexGet', ['w'=>120, 'h'=>40]) }}';
			Hstui.use('jquery', 'common', function(){
				$(".J_getNewCode").on('click',function(){
					$("#code").attr('src', codeUrl + '?t='+Date.parse(new Date()));
				});
			});
		</script>
	</body>
</html>