<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Leizhishang\Lzscms\Model\ManageUserModel;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class FounderController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
        $this->navs = [
            'add'=>['name'=>lzs_lang('lzscms::manage.founder.add'), 'url'=>'manageFounderAdd', 'class'=>'J_dialog', 'title'=>lzs_lang('lzscms::manage.founder.add')]
        ];
    }

    public function index(Request $request)
    {
        $founders = ManageUserModel::getFounder();
        $view = [
            'founders'=>$founders,
            'navs'=>$this->getNavs('index', true)
        ];
    	return $this->loadTemplate('founder.index', $view);
    }

    public function add(Request $request)
    {
        return $this->loadTemplate('founder.add');
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|between:6,16|string',
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
        ],[
            'username.required'=>lzs_lang('lzscms::public.username.empty'),
            'password.required'=>lzs_lang('lzscms::public.password.empty'),
            'password.between' => lzs_lang('lzscms::public.password.length.tips'),
            'name.required' => lzs_lang('lzscms::public.realname.empty'),
            'mobile.required'=>lzs_lang('lzscms::public.mobile.empty'),
            'email.required'=>lzs_lang('lzscms::public.email.empty'),
            'email.email'=>lzs_lang('lzscms::public.email.error')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $user = ManageUserModel::where('username', trim($request->get('username')))->first();
        if($user) {
            return $this->showError('lzscms::manage.founder.username.noone');
        }
        $salt = lzs_random(6);
        $postData = [
            'username'=>trim($request->get('username')),
            'password'=>trim(lzs_md5(trim($request->get('password')), $salt)),
            'salt'=>$salt,
            'name'=>trim($request->get('name')),
            'mobile'=>trim($request->get('mobile')),
            'email'=>trim($request->get('email')),
            'weixin'=>trim($request->get('weixin')),
            'qq'=>trim($request->get('qq')),
            'status'=>lzs_switch($request, 'status', true),
            'gid'=>99
        ];
        ManageUserModel::insert($postData);
        ManageUserModel::setCache();
        $this->addOperationLog(lzs_lang('lzscms::manage.founder.add').':'.trim($request->get('username')), '', $postData, array());
        return $this->showMessage('lzscms::public.add.success'); 
    }

    public function edit($uid)
    {
        if(!$uid) {
            return $this->showError('lzscms::public.no.id');
        }
        $user = ManageUserModel::getUser($uid);
        if(!$user) {
            return $this->showError('lzscms::public.no.data');
        }
        $view = [
            'info'=>$user,
            'uid'=>$uid
        ];
        return $this->loadTemplate('founder.edit', $view);
    }

    public function editSave(Request $request)
    {
        $uid = (int)$request->get('uid');
        if(!$uid) {
            return $this->showError('lzscms::public.no.id');
        }
        $user = ManageUserModel::where('uid', $uid)->first();
        if(!$user) {
            return $this->showError('lzscms::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            //'password' => 'between:6,16|string',
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
        ],[
            //'password.required'=>lzs_lang('lzscms::manage.user.password.empty'),
            //'password.between' => lzs_lang('lzscms::manage.user.password.length.tips'),
            'name.required' => lzs_lang('lzscms::public.realname.empty'),
            'mobile.required'=>lzs_lang('lzscms::public.mobile.empty'),
            'email.required'=>lzs_lang('lzscms::public.email.empty'),
            'email.email'=>lzs_lang('lzscms::public.email.error')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $editData = [
            'name'=>trim($request->get('name')),
            'mobile'=>trim($request->get('mobile')),
            'email'=>trim($request->get('email')),
            'weixin'=>trim($request->get('weixin')),
            'qq'=>trim($request->get('qq')),
            'status'=>lzs_switch($request, 'status', true)
        ];
        if($request->get('password')) {
            $editData['password'] = trim(lzs_md5(trim($request->get('password')), $user['salt']));
        }
        ManageUserModel::where('uid', $uid)->update($editData);
        ManageUserModel::setCache();
        $this->addOperationLog(lzs_lang('lzscms::manage.founder.edit').':'.$user['username'], '', $editData, $user->toArray());
        return $this->showMessage('lzscms::public.edit.success'); 
    }

    public function delete($uid)
    {
        if(!$uid) {
            return $this->showError('lzscms::public.no.id');
        }
        $user = ManageUserModel::getUser($uid);
        if(!$user) {
            return $this->showError('lzscms::public.no.data');
        }
        if($uid == lzs_manager('uid')) {
            return $this->showError('lzscms::manage.founder.delete.my');
        }
        $count = ManageUserModel::where('gid', 99)->count();
        if($count < 2) {
            return $this->showError('lzscms::manage.founder.one');
        }
        ManageUserModel::where('uid', $uid)->delete();
        ManageUserModel::setCache();
        $this->addOperationLog(lzs_lang('lzscms::manage.founder.delete').':'.$user['username'], '', array(), $user->toArray());
        return $this->showMessage('lzscms::public.delete.success'); 
    }
}

