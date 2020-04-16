<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Open;

use App\Modules\Openapi\Http\Controllers\Open\OpenapiBasicController as OpenApiBasicController;

use Illuminate\Http\Request;

class TestController extends OpenApiBasicController
{

    public function index() 
    {
        return $this->notFond();
    }
}