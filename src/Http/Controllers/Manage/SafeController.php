<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Requests;

class SafeController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
    	$config = lzs_config('safe');
    	return $this->loadTemplate('safe.index', ['config'=>$config]);
    }

    public function save(Request $request)
    {
    	$arrRequest = $request->all();
    	$data =[
    		['name'=>'manage.request', 'value'=>lzs_switch($arrRequest, 'request'), 'issystem'=>1],
    		['name'=>'manage.operation', 'value'=>lzs_switch($arrRequest, 'operation'), 'issystem'=>1],
    		['name'=>'manage.login.ips', 'value'=>$arrRequest['safeIps'], 'issystem'=>1],
            ['name'=>'manage.login.ctime', 'value'=>$arrRequest['loginCtime'], 'issystem'=>1],
    	];
        $oldConfig = lzs_config('safe');
    	lzs_save_config('safe', $data);
        $this->addOperationLog(lzs_lang('lzscms::manage.safe.update'),'', lzs_config('safe'), $oldConfig);
        return $this->showMessage('lzscms::public.save.success');
    }
}

