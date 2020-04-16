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
    'middleware'=>['open.check.app', 'open.check.sign', 'lstsms.check.api']
], function() {
	// Route::get('/', function() {
	// 	echo '欢迎开放平台Cms Api接口';
	// })->name('openApiLzscms');
	Route::get('/test', 'TestController@index')->name('openApiLzscmsTest');						//测试接口
});