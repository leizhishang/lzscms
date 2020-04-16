<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers;

use Leizhishang\Lzscms\Http\Controllers\GlobalBasicController as BaseController;

use Illuminate\Http\Request;


class AmapController extends BaseController
{

	public function index(Request $request)
	{
		$lng = $request->get('lng');
		$lat = $request->get('lat');
		$zoom = (int)$request->get('zoom');
		$zoom = $zoom ? $zoom : 16;
		$city = $request->get('city');
		$name = $request->get('name');
		$title = $request->get('title');
		$isview = (int)$request->get('isview');
		$view =[
			'seo_title'=>'地图坐标选择器',
			'lng'=>$lng,
			'lat'=>$lat,
			'zoom'=>$zoom,
			'city'=>$city,
			'name'=>$name,
			'isview'=>$isview,
			'title'=>$title
		];
		return $this->loadTemplate('lzscms::amap.index', $view);
	}

}