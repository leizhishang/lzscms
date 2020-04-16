<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Leizhishang\Lzscms\Model\CommonSmsModel;

use Leizhishang\Lzscms\Libraries\LzscmsSmsApi;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class SmsController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
        $this->navs = [
            'index'=>['name'=>lzs_lang('lzscms::manage.sms.platform'),'url'=>'manageSms'],
            'config'=>['name'=>lzs_lang('lzscms::manage.sms.setting'),'url'=>'manageSmsConfig'],
            'log'=>['name'=>lzs_lang('lzscms::manage.sms.send.log'),'url'=>'manageSmsLog'],
        ];
    }

    public function index(Request $request)
    {
    	$config = lzs_config('sms');
        if(!isset($config['platform']) || !$config['platform']) {
            $config['platform'] = 'Leizhishang';
        }
        $platforms = CommonSmsModel::getPlatform();
        $this->viewData['navs'] = $this->getNavs('index');
    	return $this->loadTemplate('sms.index', ['config'=>$config, 'platforms'=>$platforms]);
    }

    public function save(Request $request)
    {
        $arrRequest = $request->all();
        $arrRequest['platform'] = $arrRequest['platform'] ? $arrRequest['platform'] : 'Leizhishang';
        $data =[
            ['name'=>'platform', 'value'=>trim($arrRequest['platform'])]
        ];
        $oldConfig = lzs_config('sms');
        lzs_save_config('sms', $data);
        $this->addOperationLog(lzs_lang('lzscms::manage.sms.platform'),'', lzs_config('sms'), $oldConfig);
        return $this->showMessage('lzscms::public.save.success');
    }

    public function config(Request $request)
    {
        $config = lzs_config('sms');
        $this->viewData['navs'] = $this->getNavs('config');
        $types = CommonSmsModel::getType();
        return $this->loadTemplate('sms.config', ['config'=>$config, 'types'=>$types]);
    }

    public function configSave(Request $request) 
    {
        $arrRequest = $request->all();
        $types = CommonSmsModel::getType();
        $data = [];
        if($types){
            foreach ($types as $key => $value) {
                $data['types'][$key]['status'] = lzs_switch($arrRequest, $key);
                $data['types'][$key]['content'] = $request->get('types')[$key]['content'];
            }
        }
        $postData =[
            ['name'=>'types', 'value'=>$data['types'], 'issystem'=>1],
            ['name'=>'codelength', 'value'=>$arrRequest['codelength'], 'issystem'=>1],
            ['name'=>'product', 'value'=>$arrRequest['product'], 'issystem'=>1]
        ];
        $oldConfig = lzs_config('sms');
        lzs_save_config('sms', $postData);
        $this->addOperationLog(lzs_lang('lzscms::manage.sms.update'),'', lzs_config('sms'), $oldConfig);
        return $this->showMessage('lzscms::public.save.success');
    }

    public function hstsmsConfig(Request $request)
    {
        $config = lzs_config('sms');
        $this->navs = [
            'hstsmsConfig'=>['name'=>lzs_lang('lzscms::manage.sms.setting'),'url'=>'manageSmsHstsmsConfig'],
            'payHstsms'=>['name'=>lzs_lang('lzscms::manage.sms.purchase'),'url'=>'manageSmsHstsmsBuy'],
        ];
        $lzscmsSmsApi = new LzscmsSmsApi();
        $result = $lzscmsSmsApi->getSurplus();
        $this->viewData['navs'] = $this->getNavs('hstsmsConfig');
        return $this->loadTemplate('sms.hstsms', ['config'=>$config, 'surplus'=>$result]);
    }

    public function hstsmsConfigSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hstsmsappid' => 'required',
            'hstsmskey' => 'required',
            'hstsmssign' => 'required',
        ],[
            'hstsmsappid.required'=>lzs_lang('lzscms::manage.sms.hstsmsappid.empty'),
            'hstsmskey.required'=>lzs_lang('lzscms::manage.sms.hstsmskey.empty'),
            'hstsmssign.required'=>lzs_lang('lzscms::manage.sms.hstsmssign.empty'),
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $arrRequest = $request->all();
        $data =[
            ['name'=>'hstsmsappid', 'value'=>trim($arrRequest['hstsmsappid'])],
            ['name'=>'hstsmskey', 'value'=>trim($arrRequest['hstsmskey'])],
            ['name'=>'hstsmssign', 'value'=>trim($arrRequest['hstsmssign'])],
        ];
        $oldConfig = lzs_config('sms');
        lzs_save_config('sms', $data);
        $this->addOperationLog(lzs_lang('lzscms::manage.sms.hstsms.seeting'),'', lzs_config('sms'), $oldConfig);
        return $this->showMessage('lzscms::public.save.success');

    }

    public function hstsmsBuy(Request $request) 
    {
        $config = lzs_config('sms');
        $this->navs = [
            'hstsmsConfig'=>['name'=>lzs_lang('lzscms::manage.sms.setting'),'url'=>'manageSmsHstsmsConfig'],
            'payHstsms'=>['name'=>lzs_lang('lzscms::manage.sms.purchase'),'url'=>'manageSmsHstsmsBuy'],
        ];
        $lzscmsSmsApi = new LzscmsSmsApi();
        $result = $lzscmsSmsApi->getSurplus();

        $this->viewData['navs'] = $this->getNavs('payHstsms');
        return $this->loadTemplate('sms.hstsms_buy', ['config'=>$config, 'surplus'=>$result]);
    }

    public function hstsmsBuys(Request $request) 
    {
        $lzscmsSmsApi = new LzscmsSmsApi();
        $result = $lzscmsSmsApi->getPay($request->get('money'));
        return redirect($result);
    }

    public function log(Request $request)
    {
        $type = $request->input('type');
        $status = $request->input('status');
        $uid = $request->input('uid');
        $mobile = $request->input('mobile');
        $stime = $request->input('stime');
        $etime = $request->input('etime');
        $listQuery = CommonSmsModel::where('id', '>', 0);
        $args = ['status'=>0, 'type'=>''];
        if($uid) {
            $args['uid'] = $uid;
            $listQuery->where('uid', $uid);
        }
        if($mobile) {
            $args['mobile'] = $mobile;
            $listQuery->where('mobile', $mobile);
        }
        if($type) {
            $args['type'] = $type;
            $listQuery->where('type', $type);
        }
        if($status) {
            $args['status'] = $status;
            if ($status == 9) {
                $status = 0;
            }
            $listQuery->where('status', $status);
        }
        if($stime) {
            $args['stime'] = $stime;
            $stime = lzs_str2time($stime);
            $listQuery->where('times', '>=', $stime);
        }
        if($etime) {
            $args['etime'] = $etime;
            $etime = lzs_str2time($etime);
            $listQuery->where('times', '<=', $etime);
        }
        $list = $listQuery->orderby('times', 'desc')->paginate($this->paginate);
        $this->viewData['navs'] = $this->getNavs('log');
        $types = CommonSmsModel::getType();
        $view = [
            'list'=>$list,
            'args'=>$args,
            'types'=>$types
        ];
        return $this->loadTemplate('lzscms::manage.sms.log', $view);
    }

    public function logView($id, Request $request) 
    {
        if(!$id) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = CommonSmsModel::where('id', $id)->first();
        if(!$info) {
            return $this->showError('lzscms::public.no.data');
        }
        $this->navs['view'] = ['name'=>lzs_lang('lzscms::public.log.view'), 'url'=>route('manageHstsmsLogNoticesView', ['id'=>$id])];
        $this->viewData['navs'] = $this->getNavs('view');
        $view = [
            'info'=>$info
        ];
        return $this->loadTemplate('lzscms::manage.sms.log_view', $view);
    }
}

