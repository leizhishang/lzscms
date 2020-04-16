<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Leizhishang\Lzscms\Libraries\LzscmsSign;
use Leizhishang\Lzscms\Helpers\Api\ApiResponse;

class ApiService
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $appid = $request->headers->get('appid') ? $request->headers->get('appid') : $request->get('appid');
        if(!$appid) {
            return $this->message('Appid does not exist', '-1');
        }
        $apps = lzs_api_app();
        if(!isset($apps[$appid]) || !$apps[$appid]) {
            return $this->message('Appid does not exist', '-2');
        }
        $app = $apps[$appid];
        if($app && $app['status']) {
            return $this->message('Appid A suspension of use', '-3');
        }
        if(config('lzscms.apiSign')) {
            $sign = $request->get('sign');
            if(!$sign) {
                return $this->message('Sign Error', '-4');
            }
            $all = $request->all();
            $checkSign = false;
            $LzscmsSign = new LzscmsSign();
            $checkSign = $LzscmsSign->verifySign($all, $app['secret']);
            if(!$checkSign) {
                return $this->message('Sign Error', '-5');
            }
        }
        $request->attributes->add(['apiAppInfo'=>$app]);    //添加参数
        return $next($request);
    }
}
