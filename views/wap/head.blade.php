<meta charset="UTF-8" />
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="generator" content="lzscms v{!! config('lzscms:version') !!} 20171111" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{ lzs_public('favicon.ico') }}" />
<link rel="stylesheet" type="text/css" href="{{ config('lzscms.wapres') }}/css/hstui.css" />
<script>
var G = {
	RES_ROOT: '{{ config('lzscms.wapres') }}',
	TIPS_MESSAGE: {
		STATE : '{!! session('state') !!}',
		MESSAGE : '{!! session('message') !!}'
	}
}
</script>
<script type="text/javascript" src="{{ config('lzscms.wapres') }}/js/hstui.js"></script>