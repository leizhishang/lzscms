<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Leizhishang\Lzscms\Libraries\LzscmsEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class EmailController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
        $this->navs = [
            'index'=>['name'=>lzs_lang('lzscms::manage.email.config'),'url'=>'manageConfigEmailIndex'],
            'test'=>['name'=>lzs_lang('lzscms::manage.email.test'),'url'=>'manageConfigEmailTest'],
        ];
    }

    public function index(Request $request)
    {
    	$config = lzs_config('email');
        $this->viewData['navs'] = $this->getNavs('index');
    	return $this->loadTemplate('email.index', ['config'=>$config]);
    }

    public function save(Request $request)
    {
    	$arrRequest = $request->all();
    	$data =[
            ['name'=>'host', 'value'=>$arrRequest['host']],
            ['name'=>'port', 'value'=>$arrRequest['port']],
            ['name'=>'from', 'value'=>$arrRequest['from']],
            ['name'=>'from.name', 'value'=>$arrRequest['fromName']],
    		['name'=>'auth', 'value'=>lzs_switch($arrRequest, 'auth')],
    		['name'=>'user', 'value'=>$arrRequest['user']],
            ['name'=>'password', 'value'=>$arrRequest['password']],
    	];
        $configData = [
            'MAIL_HOST' => $arrRequest['host'] ? trim($arrRequest['host']) : '',
            'MAIL_PORT' => $arrRequest['port'] ? trim($arrRequest['port']) : 25,
            'MAIL_USERNAME' => $arrRequest['user'] ? trim($arrRequest['user']) : '',
            'MAIL_PASSWORD' => $arrRequest['password'] ? trim($arrRequest['password']) : '',
            'MAIL_FROM_ADDRESS' => $arrRequest['from'] ? trim($arrRequest['from']) : '',
            'MAIL_FROM_NAME' => $arrRequest['fromName'] ?  trim($arrRequest['fromName']) : ''
        ];
        $oldConfig = lzs_config('email');
    	lzs_save_config('email', $data);
        lzs_updateEnvInfo($configData);
        $this->addOperationLog(lzs_lang('lzscms::manage.config.email.update'),'', lzs_config('email'), $oldConfig);
        return $this->showMessage('lzscms::public.save.success');
    }

    public function test(Request $request)
    {
        $config = lzs_config('email');
        $this->viewData['navs'] = $this->getNavs('test');
        return $this->loadTemplate('email.test', ['config'=>$config]);
    }

    public function testSubmit(Request $request)
    {
        $toemail = $request->get('toemail');
        $validator = Validator::make($request->all(), [
            'toemail' => 'required|email'
        ],[
            'toemail.required'=>lzs_lang('lzscms::manage.email.toemail.empty'),
            'toemail.email'=>lzs_lang('lzscms::manage.email.toemail.error')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $flag = LzscmsEmail::sendMail(['email'=>$toemail, 'title'=>lzs_lang('lzscms::manage.email.test.title')], 'Lzscms::mail.test');
        if(!$flag) {
            $this->addOperationLog(lzs_lang('lzscms::public.to').$toemail.lzs_lang('lzscms::manage.email.test.success'));
            return $this->showMessage('lzscms::public.send.success');
        } else {
            $this->addOperationLog(lzs_lang('lzscms::public.to').$toemail.lzs_lang('lzscms::manage.email.test.error'));
            return $this->showMessage('lzscms::public.send.error');
        }
    }
}

