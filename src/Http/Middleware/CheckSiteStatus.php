<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Closure;

class CheckSiteStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!lzs_config('site', 'vstate')) {
            return redirect()->route('LzscmsClose');
        }
        return $next($request);
    }
}
