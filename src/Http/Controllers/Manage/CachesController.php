<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;

class CachesController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
        $this->navs = [
            'index'=>['name'=>lzs_lang('lzscms::manage.caches.setting'),'url'=>'manageCaches']
        ];
    }

    public function index(Request $request)
    {
    	$config = lzs_config('caches');
        if(!isset($config['driver']) || !$config['driver']) {
            $config['driver'] = 'file';
        }
        $this->viewData['navs'] = $this->getNavs('index');
    	return $this->loadTemplate('caches.index', ['config'=>$config]);
    }

    public function save(Request $request)
    {
        $arrRequest = $request->all();
        $oldConfig = lzs_config('caches');
        $arrRequest['driver'] = $arrRequest['driver'] ? $arrRequest['driver'] : 'file';
        if($arrRequest['driver'] == 'memcached') {
            if(!isset($oldConfig['memdusername']) || !$oldConfig['memdusername']) {
                return $this->showError('lzscms::manage.caches.save.error.001', 5);
            }
        }
        if($arrRequest['driver'] == 'redis') {
            if(!isset($oldConfig['redishost']) || !$oldConfig['redishost']) {
                return $this->showError('lzscms::manage.caches.save.error.002', 5);
            }
        }
        $data =[
            ['name'=>'driver', 'value'=>trim($arrRequest['driver'])]
        ];
        lzs_save_config('caches', $data);
        $configData = [
            'CACHE_DRIVER'=>$arrRequest['driver']
        ];
        lzs_updateEnvInfo($configData);
        $this->addOperationLog(lzs_lang('lzscms::manage.caches.driver'),'', lzs_config('caches'), $oldConfig);
        return $this->showMessage('lzscms::public.save.success', 5);
    }

    public function memcachedConfig(Request $request)
    {
        $config = lzs_config('caches');
        $this->navs['memcached'] = ['name'=>lzs_lang('lzscms::manage.caches.memcached.setting'),'url'=>'manageCachesMemcachedConfig'];
        $this->viewData['navs'] = $this->getNavs('memcached');
        return $this->loadTemplate('caches.memcached', ['config'=>$config]);
    }

    public function memcachedConfigSave(Request $request) 
    {
        $arrRequest = $request->all();
        $postData =[
            ['name'=>'memdpsid', 'value'=>$arrRequest['memdpsid'], 'issystem'=>1],
            ['name'=>'memdhost', 'value'=>$arrRequest['memdhost'], 'issystem'=>1],
            ['name'=>'memdport', 'value'=>$arrRequest['memdport'], 'issystem'=>1],
            ['name'=>'memdusername', 'value'=>$arrRequest['memdusername'], 'issystem'=>1],
            ['name'=>'memdpassword', 'value'=>$arrRequest['memdpassword'], 'issystem'=>1]
        ];
        $oldConfig = lzs_config('caches');
        lzs_save_config('caches', $postData);
        $configData = [
            'MEMCACHED_PERSISTENT_ID'=>$arrRequest['memdpsid'],
            'MEMCACHED_USERNAME'=>$arrRequest['memdusername'],
            'MEMCACHED_PASSWORD'=>$arrRequest['memdpassword'],
            'MEMCACHED_HOST'=>$arrRequest['memdhost'],
            'MEMCACHED_PORT'=>$arrRequest['memdport']
        ];
        lzs_updateEnvInfo($configData);
        $this->addOperationLog(lzs_lang('lzscms::manage.caches.memcached.update'),'', lzs_config('sms'), $oldConfig);
        return $this->showMessage('lzscms::public.save.success');
    }

    public function redisConfig(Request $request)
    {
        $config = Lzs_config('caches');
        $this->navs['redis'] = ['name'=>lzs_lang('lzscms::manage.caches.redis.setting'),'url'=>'manageCachesRedisConfig'];
        $this->viewData['navs'] = $this->getNavs('redis');
        return $this->loadTemplate('caches.redis', ['config'=>$config]);
    }

    public function redisConfigSave(Request $request) 
    {
        $arrRequest = $request->all();
        $postData =[
            ['name'=>'redishost', 'value'=>$arrRequest['host'], 'issystem'=>1],
            ['name'=>'redisport', 'value'=>$arrRequest['port'], 'issystem'=>1],
            ['name'=>'redispassword', 'value'=>$arrRequest['password'], 'issystem'=>1]
        ];
        $oldConfig = lzs_config('caches');
        lzs_save_config('caches', $postData);
        $configData = [
            'REDIS_PASSWORD'=>$arrRequest['password'],
            'REDIS_HOST'=>$arrRequest['host'],
            'REDIS_PORT'=>$arrRequest['port']
        ];
        lzs_updateEnvInfo($configData);
        $this->addOperationLog(lzs_lang('lzscms::manage.caches.redis.update'),'', lzs_config('sms'), $oldConfig);
        return $this->showMessage('lzscms::public.save.success');
    }
}

