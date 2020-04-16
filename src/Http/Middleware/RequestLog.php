<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Middleware;

use Closure;
use Illuminate\Filesystem\Filesystem;

class RequestLog
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
        if(lzs_config('safe', 'manage.request')) {
            $RequestLogDir = base_path('storage/Lzscms/requestlog/'. lzs_time2str(lzs_time(), 'Ym') . '/');
            $file = $RequestLogDir . lzs_time2str(lzs_time(), 'd') . '.log';
            $files = new Filesystem();
            if (!$files->isDirectory($RequestLogDir)) {
                $files->makeDirectory($RequestLogDir, 0755, true);
            }
            $data = [
                'method'=> $request->method(),
                'uri'=> $request->path(),
                'url'=> url()->current(),
                'times'=> lzs_time(),
                'ip'=> lzs_ip(),
                'port'=> lzs_port(),
                'platform'=> lzs_agent()->platform(),
                'browser'=> lzs_agent()->browser(),
                'data'=> $request->all(),
                'username'=> 'admin'
            ];
            $log = is_file($file) ? @explode(PHP_EOL, file_get_contents($file)) : array();
            if ($log) {
                $end = empty(end($log)) ? unserialize(end($log)) : array();
                if ($end
                    && $end['method'] === $request->method()
                    && $end['uri'] === $request->path()
                    && $data['username'] === $end['username']
                    && ($data['times'] - $end['times']) < 1) {
                    unset($data);// 1s内的重复操作不记录
                }
            }
            if (isset($data)) {
                $_phpeol = $log ? PHP_EOL:"";
                file_put_contents($file, $_phpeol . serialize($data), FILE_APPEND);
            }
            unset($data, $RequestLogDir, $file, $log, $end);
        }
        return $next($request);
    }
}
