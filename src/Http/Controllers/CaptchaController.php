<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers;

use Leizhishang\Lzscms\Http\Controllers\GlobalBasicController as BaseController;

use Gregwar\Captcha\CaptchaBuilder;

use Illuminate\Http\Request;


class CaptchaController extends BaseController
{

    public function get(Request $request) 
    {
    	$w = (int)$request->get('w');
        $h = (int)$request->get('h');
    	$l = (int)$request->get('l');
    	$width = $w ? $w : config('lzscms.captcha.width');
        $height = $h ? $h : config('lzscms.captcha.height');
    	$length = $l ? $l : config('lzscms.captcha.length');
        $str = lzs_random($length);
        $builder = new CaptchaBuilder($str);
		$builder->build($width, $height);
		$_SESSION['phrase'] = $builder->getPhrase();
		header('Content-type: image/jpeg');
		$builder->output();
		exit;
    }
}