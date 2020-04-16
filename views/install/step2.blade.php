<!DOCTYPE html>
<html  class="no-js" lang="">
<head>
@include('lzscms::install.head')
</head>
<body>
@include('lzscms::install.header')
<section>
    <div class="content">
        <div class="form-group form-group-overfix">
            <div data-target="#step-container" class="row-fluid" id="fuelux-wizard">
                <ul class="wizard-steps">
                    <li class="active" data-target="#step1">
                        <span class="step">1</span>
                        <span class="title">{{ lzs_lang('lzscms::install.step1') }}</span>
                    </li>
                    <li class="active" data-target="#step2">
                        <span class="step">2</span>
                        <span class="title">{{ lzs_lang('lzscms::install.step2') }}</span>
                    </li>
                    <li data-target="#step3">
                        <span class="step">3</span>
                        <span class="title">{{ lzs_lang('lzscms::install.step3') }}</span>
                    </li>
                    <li data-target="#step4">
                        <span class="step">4</span>
                        <span class="title">{{ lzs_lang('lzscms::install.step4') }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main" style="margin-bottom: 10px;">
            <div class="dialogs">
                {{ lzs_lang('lzscms::install.environmental.testing') }}
                <table class="hstui-table hstui-table-bordered">
                    <tr>
                        <th>{{ lzs_lang('lzscms::install.detection.project') }}</th>
                        <th>{{ $n }}{{ lzs_lang('lzscms::install.required.configuration') }}</th>
                        <th>{{ $n }}{{ lzs_lang('lzscms::install.optimum') }}</th>
                        <th>{{ lzs_lang('lzscms::install.current.server') }}</th>
                    </tr>
                    <tr>
                        <td>{{ lzs_lang('lzscms::install.operating.system') }}</td>
                        <td>{{ lzs_lang('lzscms::install.unrestricted') }}</td>
                        <td>linux</td>
                        <td>{!! $env['OS'] !!}</td>
                    </tr>
                    <tr>
                        <td>{{ lzs_lang('lzscms::install.php.v') }}</td>
                        <td>{!! $limitEnv['min']['php_version'] !!}</td>
                        <td>{!! $limitEnv['perfect']['php_version'] !!}</td>
                        <td>{!! $env['php_version'] !!}</td>
                    </tr>
                    <tr>
                        <td>{{ lzs_lang('lzscms::install.attachments.upload') }}</td>
                        <td>{{ lzs_lang('lzscms::install.unrestricted') }}</td>
                        <td>2M</td>
                        <td>{!! $env['file_upload'] !!}</td>
                    </tr>
                    <tr>
                        <td>GD</td>
                        <td>{!! $limitEnv['min']['gd'] !!}</td>
                        <td>{!! $limitEnv['perfect']['gd'] !!}</td>
                        <td>{!! $env['gd'] !!}</td>
                    </tr>
                    <tr>
                        <td>{{ lzs_lang('lzscms::install.disk.space') }}</td>
                        <td>{!! $limitEnv['min']['disk_space'] !!}</td>
                        <td>{!! $limitEnv['perfect']['disk_space'] !!}</td>
                        <td>{!! $env['disk_space'] !!}</td>
                    </tr>
                </table>
                {{ lzs_lang('lzscms::install.dir.file.jurisdiction') }}
                <table class="hstui-table hstui-table-bordered">
                    <tr><th>{{ lzs_lang('lzscms::install.dir.file') }}</th><th>{{ lzs_lang('lzscms::install.required.state') }}</th><th>{{ lzs_lang('lzscms::install.current.state') }}</th></tr>
                    @foreach($fileRW as $item)
                    <tr>
                        <td>{!! $item['path'] !!}</td>
                        <td><span class="cor-blue2a text-size20">√</span> {{ lzs_lang('lzscms::install.write1') }}</td>
                        <td>
                            @if($item['result'] == 1)<span class="cor-blue2a text-size20">√</span>@else<span class="cor-redfc text-size20">×</span>@endif
                            @if($item['result'] == 1){{ lzs_lang('lzscms::install.write1') }}@elseif($item['result'] == -1){{ lzs_lang('lzscms::install.noin') }}@else{{ lzs_lang('lzscms::install.write2') }}@endif
                        </td>
                    </tr>
                    @endforeach
                </table>
                {{ lzs_lang('lzscms::install.php.extension') }}
                <table class="hstui-table hstui-table-bordered">
                    <tr><th>{{ lzs_lang('lzscms::install.required.extension') }}</th><th>{{ lzs_lang('lzscms::install.required.state') }}</th><th>{{ lzs_lang('lzscms::install.current.state') }}</th></tr>
                    @foreach($functionArr as $item)
                        <tr>
                            <td>{!! $item['extension'] !!}</td>
                            <td><span class="cor-blue2a text-size20">√</span> {{ lzs_lang('lzscms::install.support1') }}</td>
                            <td>
                                @if($item['support'] == 'y')<span class="cor-blue2a text-size20">√</span>@else<span class="cor-redfc text-size20">×</span>@endif
                                @if($item['support'] == 'y'){{ lzs_lang('lzscms::install.support1') }}@else{{ lzs_lang('lzscms::install.support2') }}@endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="footer">
        <div class="btn-group shadow_con">
            <button onclick="window.location.href='{!! url('install?step=' . Crypt::encrypt(1)) !!}'" type="button" class="btn-white dropdown-toggle">
                {{ lzs_lang('lzscms::install.go.back') }}
            </button>
        </div>
        @if(!$error)
        <a href="{!! url('install?step=' . Crypt::encrypt(3)) !!}" class="btn-orange shadow_con">{{ lzs_lang('lzscms::install.start.install') }}</a>
        @endif
    </div>
</footer>
<script>
lzscms.use('jquery', 'common', function(){
    
});
</script>
</body>
</html>