<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers;

use Leizhishang\Lzscms\Model\CommonSpecialModel;
use Illuminate\Http\Request;

/**
* 
*/
class SpecialController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function view($v, Request $request) 
    {
        if(!$v) {
            return $this->showError('lzscms::public.no.data', env('APP_URL'));
        }
        if(!is_numeric($v)) {
            $v = CommonSpecialModel::getIdByDir($v);
        }
        $info = CommonSpecialModel::getInfo($v);
        if(!$info) {
            return $this->showError('lzscms::public.no.data', env('APP_URL'));
        }
        $view = [
            'info'=>$info
        ];
        if($info['style']) {
            if($info['module'] == 'site') {
                return $this->loadTemplate($info['style'], $view);
            }
            return $this->loadTemplate($info['module'].'::'.$info['style'], $view);
        }
        if(config('websys.version')) {
            $SeoBo = websys_seoBo('area', 'custom', $info['id']);
            $SeoBo->set('{pagename}', $info['name']);
            $seo = $SeoBo->getData();
            $this->setSeo($seo['title'], $seo['keywords'], $seo['description']);
        } else {
            $this->setSeo($info['title'], $info['keywords'], $info['description']);
        }
        if($this->isMobile) {
            $view['css'] = url('theme/special/'.$v.'/wap/css');
            $view['images'] = url('theme/special/'.$v.'/wap/images');
            $view['js'] = url('theme/special/'.$v.'/wap/js');
            return $this->loadTemplate('special::'.$v.'.wap.index', $view);
        }
        $view['css'] = url('theme/special/'.$v.'/css');
        $view['images'] = url('theme/special/'.$v.'/images');
        $view['js'] = url('theme/special/'.$v.'/js');
        return $this->loadTemplate('special::'.$v.'.index', $view);
    }
    
}