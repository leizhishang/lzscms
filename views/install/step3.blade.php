<!DOCTYPE html>
<html  class="no-js" lang="">
<head>
@include('lzscms::install.head')
</head>
<body>
@include('lzscms::install.header')
<form class="conts-form J_ajaxForm" action="{!! url('install/checkDatabase') !!}" method="post" >
    {!! Lzs_csrf() !!} 
    <section>
        <div class="content">
            <div class="hstui-form-group hstui-form-group-overfix">
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
                        <li class="active" data-target="#step3">
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
            <div class="main" style="overflow:hidden; margin-bottom: 10px;">
                <div class="hstui-frame" style="width: 100% !important; ">
                    <div class="hstui-frame-title">
                        {{ lzs_lang('lzscms::install.title1') }}
                    </div>
                    <div class="hstui-frame-content">
                        <div class="hstui-form hstui-form-horizontal" action="">
                            <div class="hstui-form-group @if($errors->first('site_url')) hstui-form-error @endif"  id="J_form_error_site_url">
                                <label for="exampleInputName2" class="hstui-u-sm-3 hstui-form-label">{{ lzs_lang('lzscms::install.username') }}</label>
                                <input type="text" name="site_url" value="@if(old('site_url')){!! old('site_url') !!}@else{!! $preData['site_url'] !!}@endif">
                                <label class="Validform_checktip point-out">{{ lzs_lang('lzscms::install.username') }}</label>
                            </div>
                            <div class="hstui-form-group @if($errors->first('db_host')) hstui-form-error @endif" id="J_form_error_db_host">
                                <label for="exampleInputName3" class="hstui-u-sm-3 hstui-form-label">{{ lzs_lang('lzscms::install.db.host') }}</label>
                                <input type="text" name="db_host" value="@if(old('db_host')){!! old('db_host') !!}@else{!! $preData['db_host'] !!}@endif">
                                <label class="Validform_checktip point-out">@if($errors->first('db_host')){!! $errors->first('db_host') !!}@else {{ lzs_lang('lzscms::install.db.host.tips') }} @endif</label>
                            </div>
                            <div class="hstui-form-group @if($errors->first('db_database')) hstui-form-error @endif" id="J_form_error_db_name">
                                <label for="exampleInputName4" class="hstui-u-sm-3 hstui-form-label">{{ lzs_lang('lzscms::install.db.database') }}</label>
                                <input type="text" name="db_database" value="@if(old('db_database')){!! old('db_database') !!}@else{!! $preData['db_database'] !!}@endif">
                                <label class="Validform_checktip point-out">{{ lzs_lang('lzscms::install.db.database.tips') }}</label>
                            </div>
                            <div class="hstui-form-group @if($errors->first('db_username')) hstui-form-error @endif" id="J_form_error_db_account">
                                <label for="exampleInputName5" class="hstui-u-sm-3 hstui-form-label">{{ lzs_lang('lzscms::install.db.username') }}</label>
                                <input type="text" name="db_username" value="@if(old('db_username')){!! old('db_username') !!}@else{!! $preData['db_username'] !!}@endif">
                                <label class="Validform_checktip point-out">@if($errors->first('db_username')){!! $errors->first('db_username') !!}@else {{ lzs_lang('lzscms::install.db.username.tips') }} @endif</label>
                            </div>
                            <div class="hstui-form-group @if($errors->first('db_password')) hstui-form-error @endif" id="J_form_error_db_password">
                                <label for="exampleInputName6" class="hstui-u-sm-3 hstui-form-label">{{ lzs_lang('lzscms::install.db.password') }}</label>
                                <input type="password" class="form-control inputxt" name="db_password" value="@if(old('db_password')){!! old('db_password') !!}@else{!! $preData['db_password'] !!}@endif">
                                <label class="Validform_checktip point-out">@if($errors->first('db_password')){!! $errors->first('db_password') !!}@else {{ lzs_lang('lzscms::install.db.password.tips') }} @endif</label>
                            </div>
                        </div>
                        <div class="hstui-frame-title" style="background: #fff; margin-bottom: 10px">
                        {{ lzs_lang('lzscms::install.title2') }}
                        </div>
                        <div class="hstui-form hstui-form-horizontal" action="">
                            <div class="hstui-form-group @if($errors->first('username')) hstui-form-error @endif">
                                <label for="exampleInputName7" class="hstui-u-sm-3 hstui-form-label">{{ lzs_lang('lzscms::install.username') }}</label>
                                <input type="text" name="username" value="@if(old('username')){!! old('username') !!}@else{!! $preData['username'] !!}@endif">
                                <label class="Validform_checktip point-out">{{ lzs_lang('lzscms::install.username.tips') }}</label>
                            </div>
                            <div class="hstui-form-group @if($errors->first('password')) hstui-form-error @endif">
                                <label for="exampleInputName8" class="hstui-u-sm-3 hstui-form-label">{{ lzs_lang('lzscms::install.password') }}</label>
                                <input type="password" name="password"  value="{!! old('password') !!}">
                                <label  class="Validform_checktip point-out">{{ lzs_lang('lzscms::install.password.tips') }}</label>
                            </div>
                            <div class="hstui-form-group @if($errors->first('confirm_password')) hstui-form-error @endif">
                                <label for="exampleInputName9" class="hstui-u-sm-3 hstui-form-label">{{ lzs_lang('lzscms::install.confirm.password') }}</label>
                                <input type="password" name="confirm_password" value="{!! old('confirm_password') !!}">
                                <label  class="Validform_checktip point-out">{{ lzs_lang('lzscms::install.confirm.password.tips') }}</label>
                            </div>
                            <!-- <div class="radio">
                                <label class="title"></label>
                                <label>
                                    <input type="radio" name="is_data" id="optionsRadios1" value="1" checked="checked">
                                    带有演示数据
                                </label>
                            </div>
                            <div class="radio">
                                <label class="title"></label>
                                <label>
                                    <input type="radio" name="is_data" id="optionsRadios2" value="0">
                                    纯净版（不包括文章的演示数据，一般不推荐使用）
                                </label>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="footer">
            <div class="btn-group shadow_con">
                <button onclick="window.location.href='{!! url('install?step=' . Crypt::encrypt(2)) !!}'" type="button" class="btn-white dropdown-toggle">
                    {{ lzs_lang('lzscms::install.go.back') }}
                </button>
            </div>
            <button class="btn-orange shadow_con J_ajax_submit_btn" >{{ lzs_lang('lzscms::install.submit') }}</button>
        </div>
    </footer>
</form>
<script>
lzscms.use('jquery', 'common', function(){
});
</script>
<script>
    function showModal(){
        /*获取宽度*/
        var windowWidth = $(window).width();
        /*获取高度*/
        var windowHeight = $(window).height();
        $('.overlay').css('width',windowWidth);
        $('.overlay').css('height',windowHeight);
        $('.overlay').fadeIn(1000);
    }
</script>
</body>
</html>