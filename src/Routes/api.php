<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'middleware'=>['api.service']
], function() {
	// Route::get('/', function(){
	// 	echo '欢迎Cms Api接口';
	// })->name('LzscmsApi');
	Route::get('/test', 'TestController@index')->name('lzscmsApiText');
	Route::post('/test', 'TestController@index')->name('lzscmsApiTextPost');
});

Route::group([
    'middleware'=>['api.service']
], function() {
    Route::get('/mobile/code/send', 'MobileController@send')->name('apiMobileSendCode');
    Route::get('/area/list', 'AreaController@list')->name('apiAreaList');
    Route::get('/area/citys', 'AreaController@citys')->name('apiAreaCitys');
    Route::get('/area/id/by/name', 'AreaController@getId')->name('apiAreaGetId');
});