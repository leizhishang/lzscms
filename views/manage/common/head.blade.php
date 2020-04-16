<meta charset="UTF-8" />
<title>{{ $seo_title }}</title>
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="generator" content="lzscms v{!! config('lzscms:version') !!} 20171111" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="initial-scale=0.1">
<link rel="shortcut icon" href="{{ lzs_public('favicon.ico') }}" />
<link rel="stylesheet" type="text/css" href="{{ lzs_resurl('webui/css/hstui.min.css') }}" />
<link rel="stylesheet" href="{{ lzs_assets('manage/css/style.css') }}">
<script>
var G = {
	RES_ROOT: '{{ lzs_resurl('webui') }}',
	TIPS_MESSAGE: {
		STATE : '{!! session('state') !!}',
		MESSAGE : '{!! session('message') !!}',
	}
}
</script>
<script type="text/javascript" src="{{ lzs_resurl('webui/js/hstui.min.js') }}"></script>