<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Api;

use Leizhishang\Lzscms\Http\Controllers\Api\BasicController as ApiBaseController;

use Illuminate\Http\Request;

class TestController extends ApiBaseController
{

    public function index(Request $request) 
    {
    	$apps = lzs_api_app();
        return $this->notFond();
    }
}