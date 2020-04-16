<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Requests;

class ConfigController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->navs = [
            'index'=>['name'=>lzs_lang('lzscms::manage.config.site'),'url'=>'manageConfigIndex'],
        ];
    	$config = lzs_config('site');
        $this->viewData['navs'] = $this->getNavs('index');
    	return $this->loadTemplate('config.index', ['config'=>$config]);
    }

    public function save(Request $request)
    {
    	$arrRequest = $request->all();
    	$data =[
    		['name'=>'name', 'value'=>$arrRequest['name'], 'issystem'=>1],
    		['name'=>'icp', 'value'=>$arrRequest['icp'], 'issystem'=>1],
    		['name'=>'headerhtml', 'value'=>$arrRequest['headerhtml'], 'issystem'=>1],
    		['name'=>'footerhtml', 'value'=>$arrRequest['footerhtml'], 'issystem'=>1],
    		['name'=>'vstate', 'value'=>$arrRequest['state'], 'issystem'=>1],
    		['name'=>'vmessage', 'value'=>$arrRequest['visitMessage'], 'issystem'=>1],
    		['name'=>'vmtemplate', 'value'=>$arrRequest['visitMessageTemplate'], 'issystem'=>1],
    	];
        $configData = [
            'APP_NAME'=>$arrRequest['name']
        ];
        $oldConfig = lzs_config('site');
    	lzs_save_config('site', $data);
        lzs_updateEnvInfo($configData);
        $this->addOperationLog(lzs_lang('lzscms::manage.config.site.update'),'', lzs_config('site'), $oldConfig);
        return $this->showMessage('lzscms::public.save.success');
    }

    public function globals(Request $request)
    {
        $this->navs = [
            'global'=>['name'=>lzs_lang('lzscms::manage.config.global'),'url'=>'manageConfigGlobal'],
        ];
        $config = lzs_config('site');
        $config['debug'] = isset($config['debug']) ? $config['debug'] : 0;
        $config['timecv'] = isset($config['timecv']) ? $config['timecv'] : 0;
        $config['url'] = isset($config['url']) && $config['url'] ? $config['url'] : env('APP_URL');
        $config['timezone'] = isset($config['timezone']) && $config['timezone'] ? $config['timezone'] : 'Asia/Shanghai';
        $this->viewData['navs'] = $this->getNavs('global');
        return $this->loadTemplate('config.global', ['config'=>$config]); 
    }

    public function globalsSave(Request $request)
    {
        $arrRequest = $request->all();
        $arrRequest['timezone'] = isset($arrRequest['timezone']) ? $arrRequest['timezone'] : 'Asia/Shanghai';
        $arrRequest['timecv'] = isset($arrRequest['timecv']) ? $arrRequest['timecv'] : 0;
        $arrRequest['debug'] = isset($arrRequest['debug']) ? $arrRequest['debug'] : 0;
        $data =[
            ['name'=>'url', 'value'=>$arrRequest['url'], 'issystem'=>1],
            ['name'=>'timezone', 'value'=>$arrRequest['timezone'], 'issystem'=>1],
            ['name'=>'timecv', 'value'=>$arrRequest['timecv'], 'issystem'=>1],
            ['name'=>'debug', 'value'=>$arrRequest['debug'], 'issystem'=>1]
        ];
        $configData = [
            'APP_URL'=>$arrRequest['url'],
            'APP_DEBUG'=> lzs_switch($arrRequest, 'debug') == 1 ? 'true' : 'false',
            'APP_TIMEZONE'=>isset($arrRequest['timezone']) ? $arrRequest['timezone'] : 'Asia/Shanghai'
        ];
        $oldConfig = lzs_config('site');
        lzs_save_config('site', $data);
        lzs_updateEnvInfo($configData);
        $this->addOperationLog(lzs_lang('lzscms::manage.config.global.update'),'', lzs_config('site'), $oldConfig);
        return $this->showMessage('lzscms::public.save.success');
    }
}

