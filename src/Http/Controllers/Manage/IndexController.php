<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Leizhishang\Lzscms\Model\ManageMenuModel;
use Leizhishang\Lzscms\Model\ManageUserModel;
use Leizhishang\Lzscms\Model\CommonRoleModel;
use Leizhishang\Lzscms\Model\ManageLoginLogModel;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class IndexController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $user = lzs_manager();
        $menus = ManageMenuModel::getMenu($user);
        $view = [
            'menus' => json_encode($menus),
            'userInfo'=>$user
        ];
        $locked = Session::get('manager_locked');
        if($locked) {
            return redirect()->route('manageLocked');
        }
    	return $this->loadTemplate('index', $view);
    }

    public function main(Request $request)
    {
        $user = lzs_manager();
        $view = [
            'userInfo'=>$user
        ];
        return $this->loadTemplate('home', $view);
    }

    public function locked(Request $request)
    {
        $user = lzs_manager();
        $menus = ManageMenuModel::getMenu($user);
        $view = [
            'menus' => json_encode($menus),
            'userInfo'=>$user
        ];
        $locked = Session::get('manager_locked');
        return $this->loadTemplate('locked', $view);  
    }

    public function doLocked(Request $request)
    {
        Session::put('manager_locked', 1);
        return $this->showMessage('lzscms::public.successful');       
    }

    public function unLocked(Request $request)
    {
        $uid =lzs_manager('uid');
        $user = ManageUserModel::getUser($uid);
        if(!$user) {
            return $this->showError('lzscms::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'password' => 'required|between:6,16|string'
        ],[
            'password.required'=> lzs_lang('lzscms::public.password.empty'),
            'password.between' => lzs_lang('lzscms::public.password.length.tips')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator, 'manageLocked', 2);
        }
        if (!ManageUserModel::checkPassword($user['username'], $request->get('password'))) {
            ManageLoginLogModel::addLog(['uid'=>$user['uid'], 'username'=>$user['username']], lzs_lang('lzscms::public.unLocked.password.error'));
            return $this->showError(['password'=> lzs_lang('lzscms::public.unLocked.password.error')], 'manageLocked', 2);
        }
        ManageLoginLogModel::addLog($user, lzs_lang('lzscms::public.unLocked.success'));
        Session::put('manager_locked', 0);
        return redirect()->route('manageIndex');
    }

    public function customSet(Request $request)
    {

    }

    public function userInfoEdit($uid, Request $request)
    {
        if(!$uid) {
            return $this->showError('lzscms::public.no.id');
        }
        $user = ManageUserModel::getUser($uid);
        if(!$user) {
            return $this->showError('lzscms::public.no.data');
        }
        if($user['uid'] != lzs_manager('uid')) {
            return $this->showError('lzscms::public.no.id');
        }
        $view = [
            'info'=>$user,
            'uid'=>$uid
        ];
        return $this->loadTemplate('user.edit_info', $view);
    }

    public function userInfoEditSave(Request $request)
    {
        $uid = (int)$request->get('uid');
        if(!$uid) {
            return $this->showError('lzscms::public.no.id');
        }
        $user = ManageUserModel::where('uid', $uid)->first();
        if(!$user) {
            return $this->showError('lzscms::public.no.data');
        }
        if($user['uid'] != lzs_manager('uid')) {
            return $this->showError('lzscms::public.no.id');
        }
        $validator = Validator::make($request->all(), [
            //'password' => 'between:6,16|string',
            'name' => 'required',
            'mobile' => 'required',
        ],[
            //'password.required'=>lzs_lang('lzscms::manage.user.password.empty'),
            //'password.between' => lzs_lang('lzscms::manage.user.password.length.tips'),
            'name.required' => lzs_lang('lzscms::public.realname.empty'),
            'mobile.required'=>lzs_lang('lzscms::public.mobile.empty')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $editData = [
            'name'=>trim($request->get('name')),
            'mobile'=>trim($request->get('mobile')),
            'email'=>trim($request->get('email')),
            'weixin'=>trim($request->get('weixin')),
            'qq'=>trim($request->get('qq'))
        ];
        if($request->get('password')) {
            $editData['password'] = trim(lzs_md5(trim($request->get('password')), $user['salt']));
        }
        ManageUserModel::where('uid', $uid)->update($editData);
        ManageUserModel::setCache();
        $this->addOperationLog(lzs_lang('lzscms::manage.founder.user.edit').':'.$user['username'], '', $editData, $user);
        if($request->get('password')) {
            ManageLoginLogModel::addLog(lzs_manager(), lzs_lang('lzscms::manage.founder.user.edit').lzs_lang('lzscms::manage.logout.success'));
            Session::forget('manager');
            return $this->showMessage('lzscms::public.edit.success', route('manageAuthLogin')); 
        }
        return $this->showMessage('lzscms::public.edit.success'); 
    }
}

