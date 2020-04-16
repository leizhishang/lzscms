<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Development;

use Leizhishang\Lzscms\Http\Controllers\GlobalBasicController as BaseController;

use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Cache;

class DebugbarController extends BaseController
{

	public function index(Request $request)
	{
		$this->editContent();
		$view = [
			'seo_title'=>'开发调试中心'
		];
		return $this->loadTemplate('lzscms::development.debugbar_index', $view);
	}

	public function editContent()
	{
                $cacheName = 'development:debugbar';
        	$files = new Filesystem();
        	$path = realpath(__DIR__.'/../../../../../../barryvdh/laravel-debugbar/src/LaravelDebugbar.php');
        	$content = $files->get($path);
                if(!substr_count($content, 'by Leizhishang.com')) {
                $content = str_replace("use Symfony\Component\HttpFoundation\Response;","use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;//20180907 by Leizhishang.com",$content);
                $content = str_replace('$renderedContent = $renderer->renderHead() . $renderer->render();','$renderedContent = $renderer->renderHead() . $renderer->render();
        if(Route::currentRouteName() != \'developmentDebugbarIndex\') $renderedContent = \'\';//20180907 by Leizhishang.com',$content);
                $files->put($path, $content);
                }
        	Cache::forever($cacheName, 1);
       }

        public function deleteContent()
        {
                $cacheName = 'development:debugbar';
                $files = new Filesystem();
                $path = realpath(__DIR__.'/../../../../../../barryvdh/laravel-debugbar/src/LaravelDebugbar.php');
                $content = $files->get($path);
                $content = str_replace("use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;//20180907 by Leizhishang.com","use Symfony\Component\HttpFoundation\Response;",$content);
                $content = str_replace('$renderedContent = $renderer->renderHead() . $renderer->render();
        if(Route::currentRouteName() != \'developmentDebugbarIndex\') $renderedContent = \'\';//20180907 by Leizhishang.com','$renderedContent = $renderer->renderHead() . $renderer->render();',$content);
                $files->put($path, $content);
                Cache::forever($cacheName, 0);
                Cache::forget($cacheName);
	}
}