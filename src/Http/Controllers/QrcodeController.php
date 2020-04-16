<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers;

use Leizhishang\Lzscms\Http\Controllers\GlobalBasicController as BaseController;

use Illuminate\Http\Request;


class QrcodeController extends BaseController
{

	public function generate(Request $request)
	{
		$size = $request->get('size');
		$format = $request->get('format');
		$content = $request->get('content');
	}

}