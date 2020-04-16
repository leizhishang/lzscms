<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//后台路由
Route::group([
    'domain'=> config('lzscms.manage.route.domain'),
    'prefix' => config('lzscms.manage.route.domain') ? '' : config('lzscms.manage.route.prefix'),
    'middleware' => 'manage.request.log',
    'namespace'=>'Manage'
], function() {
    Route::get('/login', 'AuthController@login')->name('manageAuthLogin');
    Route::post('/dologin', 'AuthController@dologin')->name('manageAuthDoLogin');
    Route::get('/logout', 'AuthController@logout')->name('manageAuthLogout');
});

Route::group([
    'domain'=> config('lzscms.manage.route.domain'),
    'prefix' => config('lzscms.manage.route.domain') ? '' : config('lzscms.manage.route.prefix'),
    'middleware'=>['web','manage.auth.check', 'manage.request.log'],
    'namespace'=>'Manage'
], function() {
    //框架                                        
    Route::get('/', 'IndexController@index')->name('manageIndex');    
    //首页
    Route::get('/home', 'IndexController@main')->name('manageHome'); 
    //锁屏功能
    Route::get('/locked', 'IndexController@locked')->name('manageLocked');  
    Route::post('/do/locked', 'IndexController@doLocked')->name('manageDoLocked');  
    Route::post('/unlocked', 'IndexController@unLocked')->name('manageUnLocked');  
    //常用设置
    Route::get('/custom/set', 'IndexController@customSet')->name('manageCustomSet');  
    //修改资料
    Route::get('/user/info/edit/{uid}', 'IndexController@userInfoEdit')->name('manageUserInfoEdit');
    Route::post('/user/info/edit/save', 'IndexController@userInfoEditSave')->name('manageUserInfoEditSave');
    //创始人
    Route::get('/founder', 'FounderController@index')->name('manageFounderIndex');
    Route::get('/founder/add', 'FounderController@add')->name('manageFounderAdd');
    Route::post('/founder/add/save', 'FounderController@addSave')->name('manageFounderAddSave');
    Route::get('/founder/edit/{uid}', 'FounderController@edit')->name('manageFounderEdit');
    Route::post('/founder/edit/save', 'FounderController@editSave')->name('manageFounderEditSave');
    Route::any('/founder/delete/{uid}', 'FounderController@delete')->name('manageFounderDelete')->where('uid', '[0-9]+');
    //员工账号
    Route::get('/user', 'UserController@index')->name('manageUserIndex');
    Route::get('/user/add', 'UserController@add')->name('manageUserAdd');
    Route::post('/user/add/save', 'UserController@addSave')->name('manageUserAddSave');
    Route::get('/user/edit/{uid}', 'UserController@edit')->name('manageUserEdit')->where('uid', '[0-9]+');
    Route::post('/user/edit/save', 'UserController@editSave')->name('manageUserEditSave');
    Route::post('/user/delete/{uid}', 'UserController@delete')->name('manageUserDelete')->where('uid', '[0-9]+');
    //角色
    Route::get('/role', 'RoleController@index')->name('manageRoleIndex');
    Route::get('/role/add', 'RoleController@add')->name('manageRoleAdd');
    Route::post('/role/add/save', 'RoleController@addSave')->name('manageRoleAddSave');
    Route::get('/role/edit/{id}', 'RoleController@edit')->name('manageRoleEdit')->where('id', '[0-9]+');
    Route::post('/role/edit/save', 'RoleController@editSave')->name('manageRoleEditSave');
    Route::post('/role/delete/{id}', 'RoleController@delete')->name('manageRoleDelete')->where('id', '[0-9]+');
    //菜单
    Route::get('/menu/nav', 'MenuController@nav')->name('manageMenuNav');
    Route::get('/menu/nav/add', 'MenuController@navAdd')->name('manageMenuNavAdd');
    Route::post('/menu/nav/add/save', 'MenuController@navAddSave')->name('manageMenuNavAddSave');
    Route::get('/menu/nav/edit/{id}', 'MenuController@navEdit')->name('manageMenuNavEdit')->where('id', '[0-9]+');
    Route::post('/menu/nav/edit/save', 'MenuController@navEditSave')->name('manageMenuNavEditSave');
    Route::post('/menu/nav/delete/{id}', 'MenuController@navDelete')->name('manageMenuNavDelete')->where('id', '[0-9]+');
    //权限点
    Route::get('/menu/role', 'MenuController@role')->name('manageMenuRole');
    Route::get('/menu/role/add', 'MenuController@roleAdd')->name('manageMenuRoleAdd');
    Route::post('/menu/role/add/save', 'MenuController@roleAddSave')->name('manageMenuRoleAddSave');
    Route::get('/menu/role/edit/{id}', 'MenuController@roleEdit')->name('manageMenuRoleEdit')->where('id', '[0-9]+');
    Route::post('/menu/role/edit/save', 'MenuController@roleEditSave')->name('manageMenuRoleEditSave');
    Route::post('/menu/role/delete/{id}', 'MenuController@roleDelete')->name('manageMenuRoleDelete')->where('id', '[0-9]+');
    //安全配置
    Route::get('/safe', 'SafeController@index')->name('manageSafeIndex');
    Route::post('/safe/save', 'SafeController@save')->name('manageSafeSave');
    //日志
    Route::get('/log/request', 'LogController@logRequest')->name('manageLogRequest');
    Route::get('/log/operation', 'LogController@logOperation')->name('manageLogOperation');
    Route::get('/log/operation/view/{id}', 'logController@LogOperationView')->name('manageLogOperationView')->where('id', '[0-9]+');
    Route::get('/log/login', 'LogController@logLogin')->name('manageLogLogin');
    //全局配置
    Route::get('/config/index', 'ConfigController@index')->name('manageConfigIndex');
    Route::post('/config/save', 'ConfigController@save')->name('mymanageConfigSave');
    Route::get('/config/global', 'ConfigController@globals')->name('manageConfigGlobal');
    Route::post('/config/global/save', 'ConfigController@globalsSave')->name('manageConfigGlobalSave');
    //邮箱配置
    Route::get('/config/email', 'EmailController@index')->name('manageConfigEmailIndex');
    Route::post('/config/email/save', 'EmailController@save')->name('manageConfigEmailSave');
    Route::get('/config/email/test', 'EmailController@test')->name('manageConfigEmailTest');
    Route::post('/config/email/test/submit', 'EmailController@testSubmit')->name('manageConfigEmailTestSubmit');
    //FTP配置
    //Route::get('/config/ftp', 'FtpController@index')->name('manageConfigFtpIndex');
    //Route::post('/config/ftp/save', 'FtpController@save')->name('manageConfigFtpSave');
    //短信服务
    Route::get('/sms', 'SmsController@index')->name('manageSms');
    Route::post('/sms/save', 'SmsController@save')->name('manageSmsSave');
    Route::get('/sms/config', 'SmsController@config')->name('manageSmsConfig');
    Route::post('/sms/config/save', 'SmsController@configSave')->name('manageSmsConfigSave');
    Route::get('/sms/hstsms/config', 'SmsController@hstsmsConfig')->name('manageSmsHstsmsConfig');
    Route::post('/sms/hstsms/config/save', 'SmsController@hstsmsConfigSave')->name('manageSmsHstsmsConfigSave');
    Route::get('/sms/hstsms/buy', 'SmsController@hstsmsBuy')->name('manageSmsHstsmsBuy');
    Route::get('/sms/hstsms/buys', 'SmsController@hstsmsBuys')->name('manageSmsHstsmsBuys');
    Route::get('/sms/log', 'SmsController@log')->name('manageSmsLog');
    Route::get('/sms/log/view/{id}', 'SmsController@logView')->name('manageSmsLogView')->where('id', '[0-9]+');
    //附件服务
    Route::get('/attachments', 'AttachmentController@index')->name('manageAttach');
    Route::post('/attachments/save', 'AttachmentController@save')->name('manageAttachSave');
    Route::get('/attachments/manage', 'AttachmentController@manage')->name('manageAttachManage');
    Route::get('/attachments/view/{aid}', 'AttachmentController@view')->name('manageAttachView')->where('aid', '[0-9]+');
    //模块管理
    Route::get('/modules', 'ModulesController@index')->name('manageModules');
    Route::get('/modules/uninstalls', 'ModulesController@uninstalls')->name('manageModulesUninstalls');
    Route::post('/modules/doinstalls', 'ModulesController@doinstalls')->name('manageModulesDoinstalls');
    Route::post('/modules/enableds', 'ModulesController@enableds')->name('manageModulesEnableds');
    Route::any('/modules/douninstall', 'ModulesController@douninstall')->name('manageModulesDouninstall');
    Route::get('/modules/cache', 'ModulesController@cache')->name('manageModulesCache');
    //缓存管理
    Route::get('/caches', 'CachesController@index')->name('manageCaches');
    Route::post('/caches/save', 'CachesController@save')->name('manageCachesSave');
    Route::get('/caches/memcached/config', 'CachesController@memcachedConfig')->name('manageCachesMemcachedConfig');
    Route::post('/caches/memcached/config/save', 'CachesController@memcachedConfigSave')->name('manageCachesMemcachedConfigSave');
    Route::get('/caches/redis/config', 'CachesController@redisConfig')->name('manageCachesRedisConfig');
    Route::post('/caches/redis/config/save', 'CachesController@redisConfigSave')->name('manageCachesRedisConfigSave');
    //Hook 服务
    Route::get('/hook', 'HookController@index')->name('manageHookIndex');
    Route::get('/hook/add', 'HookController@add')->name('manageHookAdd');
    Route::post('/hook/add/save', 'HookController@addSave')->name('manageHookAddSave');
    Route::get('/hook/edit/{name}', 'HookController@edit')->name('manageHookEdit');
    Route::post('/hook/edit/save', 'HookController@editSave')->name('manageHookEditSave');
    Route::post('/hook/delete/{name}', 'HookController@delete')->name('manageHookDelete');
    Route::get('/hook/cache', 'HookController@cache')->name('manageHookCache');
    Route::get('/inject/{name}', 'HookInjectController@index')->name('manageHookInjectIndex');
    Route::get('/inject/{name}/add', 'HookInjectController@add')->name('manageHookInjectAdd');
    Route::post('/inject/{name}/add/save', 'HookInjectController@addSave')->name('manageHookInjectAddSave');
    Route::get('/inject/{name}/edit/{id}', 'HookInjectController@edit')->name('manageHookInjectEdit');
    Route::post('/inject/{name}/edit/save', 'HookInjectController@editSave')->name('manageHookInjectEditSave');
    Route::post('/inject/{name}/delete/{id}', 'HookInjectController@delete')->name('manageHookInjectDelete');
    //验证码服务
    Route::get('/captcha', 'CaptchaController@index')->name('manageCaptchaIndex');
    Route::post('/captcha/save', 'CaptchaController@save')->name('manageCaptchaSave');
    //表单服务
    Route::get('/form', 'FormController@index')->name('manageFormIndex');
    Route::get('/form/add', 'FormController@add')->name('manageFormAdd');
    Route::post('/form/add/save', 'FormController@addSave')->name('manageFormAddSave');
    Route::get('/form/edit/{id}', 'FormController@edit')->name('manageFormEdit')->where('id', '[0-9]+');
    Route::post('/form/edit/save', 'FormController@editSave')->name('manageFormEditSave');
    Route::post('/form/cache', 'FormController@cache')->name('manageFormCache');
    Route::post('/form/delete/{id}', 'FormController@delete')->name('manageFormDelete');
    // Route::get('/form/view/{id}', 'FormController@view')->name('manageFormView');

    Route::get('/form/content/{formid}', 'FormController@content')->name('manageFormContent')->where('formid', '[0-9]+');
    Route::get('/form/content/add/{formid}', 'FormController@contentAdd')->name('manageFormContentAdd')->where('formid', '[0-9]+');
    Route::post('/form/content/add/save/{formid}', 'FormController@contentAddSave')->name('manageFormContentAddSave')->where('formid', '[0-9]+');
    Route::get('/form/content/edit/{formid}/{id}', 'FormController@contentEdit')->name('manageFormContentEdit');
    Route::post('/form/content/edit/save/{formid}', 'FormController@contentEditSave')->name('manageFormContentEditSave')->where('formid', '[0-9]+');
    Route::post('/form/content/delete/{formid}/{id}', 'FormController@contentDelete')->name('manageFormContentDelete');
    //字段服务
    Route::get('/fields', 'FieldsController@index')->name('manageFieldsIndex');
    Route::post('/fields/save', 'FieldsController@save')->name('manageFieldsSave');
    Route::get('/fields/add', 'FieldsController@add')->name('manageFieldsAdd');
    Route::post('/fields/add/save', 'FieldsController@addSave')->name('manageFieldsAddSave');
    Route::get('/fields/edit/{id}', 'FieldsController@edit')->name('manageFieldsEdit')->where('id', '[0-9]+');
    Route::post('/fields/edit/save', 'FieldsController@editSave')->name('manageFieldsEditSave');
    Route::get('/fields/cache', 'FieldsController@cache')->name('manageFieldsCache');
    Route::post('/fields/delete/{id}', 'FieldsController@delete')->name('manageFieldsDelete')->where('id', '[0-9]+');
    //单页服务
    Route::get('/special', 'SpecialController@index')->name('manageSpecialIndex');
    Route::get('/special/add', 'SpecialController@add')->name('manageSpecialAdd');
    Route::post('/special/save', 'SpecialController@addSave')->name('manageSpecialAddSave');
    Route::post('/special/cache', 'SpecialController@cache')->name('manageSpecialCache');
    Route::get('/special/edit/{id}', 'SpecialController@edit')->name('manageSpecialEdit')->where('id', '[0-9]+');
    Route::post('/special/edit/save', 'SpecialController@editSave')->name('manageSpecialEditSave');
    Route::post('/special/delete/{id}', 'SpecialController@delete')->name('manageSpecialDelete')->where('id', '[0-9]+');
    //区域管理
    Route::get('/area', 'AreaController@index')->name('manageAreaIndex');
    Route::post('/area/cache', 'AreaController@cache')->name('manageAreaCache');
    Route::get('/area/add', 'AreaController@add')->name('manageAreaAdd');
    Route::post('/area/save', 'AreaController@addSave')->name('manageAreaAddSave');
    Route::get('/area/edit/{areaid}', 'AreaController@edit')->name('manageAreaEdit')->where('areaid', '[0-9]+');
    Route::post('/area/edit/save', 'AreaController@editSave')->name('manageAreaEditSave');
    Route::post('/area/delete/{areaid}', 'AreaController@delete')->name('manageAreaDelete')->where('areaid', '[0-9]+');
    //数据块
    Route::get('/block', 'BlockController@index')->name('manageBlockIndex');
    Route::get('/block/add', 'BlockController@add')->name('manageBlockAdd');
    Route::post('/block/add/save', 'BlockController@addSave')->name('manageBlockAddSave');
    Route::get('/block/edit/{id}', 'BlockController@edit')->name('manageBlockEdit')->where('id', '[0-9]+');
    Route::post('/block/edit/save', 'BlockController@editSave')->name('manageBlockEditSave');
    Route::post('/block/delete/{id}', 'BlockController@delete')->name('manageBlockDelete')->where('id', '[0-9]+');
    //系统检测
    Route::get('/check/index', 'CheckController@index')->name('manageCheckIndex');
    Route::get('/check/do', 'CheckController@do')->name('manageCheckDo');
    Route::get('/check/info', 'CheckController@info')->name('manageCheckInfo');
});

//安装路由器
Route::group([
    'domain'=> env('APP_URL') ,
    'prefix' => 'install', 
    'middleware'=>['web']
], function() {
    Route::get('/', 'Install\InstallController@index')->name('lzscmsInstallIndex');
    Route::post('/checkDatabase', 'Install\InstallController@checkDatabase')->name('lzscmsInstallCheckDatabase');
});

//测试路由
Route::group([
    'domain'=> env('APP_URL') ,
    'middleware'=>['web']
], function() {
    Route::get('/test', 'TestController@index')->name('lzscmsTextIndex');
    Route::get('/test/api', 'TestController@api')->name('lzscmsTextApi');
    Route::get('/test/captcha', 'TestController@captcha')->name('lzscmsTextCaptcha');
    Route::post('/test/captcha/check', 'TestController@captchaCheck')->name('lzscmsCaptchaTestCheck');
    Route::post('/test/post', 'TestController@pindex')->name('lzscmsTextIndexPost');
});

//前台路由
Route::group([
    'domain'=> env('APP_URL') ,
    'middleware'=>['web']
], function() {
    Route::post('/close', 'PublicController@LzscmsClose')->name('lzscmsClose');
    //解密查看内容
    Route::post('/viewpw', 'PublicController@viewpw')->name('publicViewpw');
    //发送验证码和验证验证码
    Route::post('/mobile/code/send', 'MobileController@send')->name('lzscmsMobileSendCode');
    Route::post('/mobile/code/verify', 'MobileController@verify')->name('lzscmsMobileVerifyCode');
    //拉取图形验证码
    Route::get('/captcha/get', 'CaptchaController@get')->name('captchaIndexGet');
    Route::get('/public/field/type/html', 'PublicController@fieldsTypeHtml')->name('publicFieldsTypeHtml');
    Route::get('/public/topinyin', 'PublicController@topinyin')->name('publicTopinyin');
    Route::get('/public/area/list', 'PublicController@getAreaSubList')->name('publicAreaList');
    //开发调试
    Route::get('development/debugbar', 'Development\DebugbarController@index')->name('developmentDebugbarIndex');
    //表单
    Route::get('/form/show/{id}', 'FormController@show')->name('formContentShow')->where('id', '[0-9]+');
    Route::post('/form/save', 'FormController@save')->name('formContentSave');
    //上传入口
    Route::post('/upload/image/save', 'UploadController@imageSave')->name('uploadImageSave');
    Route::post('/upload/kindeditor/image', 'UploadController@kindeditorImage')->name('uploadkindeditorImage');
    Route::post('/upload/save', 'UploadController@save')->name('uploadSave');
    //图片处理
    Route::get('/image/{aid}', 'ImageController@view')->name('imageView')->where('aid', '[0-9]+');
    Route::get('/image/{aid}/{type}/{width}/{height}', 'ImageController@resize')->name('imageResize');
    //单页多元化处理
    Route::get('/special/{id}', 'SpecialController@view')->name('specialView')->where('id', '[0-9]+');
    Route::get('/special/{dir}', 'SpecialController@view')->name('specialViewDir')->where('dir', '[0-9a-zA-Z\/]+');


    Route::get('/amap','AmapController@index')->name('amapIndex');
    Route::get('/qrcode/generate','QrcodeController@generate')->name('qrcodeGenerate');

});


