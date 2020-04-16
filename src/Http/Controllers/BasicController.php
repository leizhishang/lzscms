<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Cache;

class BasicController extends GlobalBasicController
{

    public function __construct()
    {
        parent::__construct();
        lzs_checkInstall();
        //前端多彩主题
        $skin_color = lzs_config('site', 'skin_color');
        if($skin_color) {
            $this->viewData['skin_color'] = $skin_color;
        }
        $icp = lzs_config('site', 'icp') ? '<a href="http://www.miibeian.gov.cn/" target="_blank">'.Lzs_config('site', 'icp').'</a>' : '';
        $this->viewData['icp'] = $icp;
        $this->middleware('check.site.status');
    }

    public function setSeo($seo_title = '', $seo_keywords = '', $seo_description = '') 
    {
        if(is_array($seo_title)) {
            $this->viewData['seo_title'] = $seo_title['title'];
            $this->viewData['seo_keywords'] = $seo_title['description'];
            $this->viewData['seo_description'] = $seo_title['keywords'];
        } else {
            $this->viewData['seo_title'] = $seo_title;
            $this->viewData['seo_keywords'] = $seo_keywords;
            $this->viewData['seo_description'] = $seo_description;
        }
    }
}
