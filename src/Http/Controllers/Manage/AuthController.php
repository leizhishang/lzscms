<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Leizhishang\Lzscms\Http\Controllers\Manage\BasicController;

use Leizhishang\Lzscms\Model\ManageUserModel;
use Leizhishang\Lzscms\Model\ManageLoginLogModel;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends BasicController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 后台登录页面
     */
    public function login()
    {
        if (Session::get('manager')) {
            return redirect()->route('manageIndex');
        }
        $this->addMessage(lzs_lang('lzscms::manage.login.title'), 'seo_title');
        return $this->loadTemplate('login');
    }

    /**
     * @param Request $request
     */
    public function doLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|between:6,16|string'
        ],[
            'username.required'=>lzs_lang('lzscms::public.username.empty'),
            'password.required'=> lzs_lang('lzscms::public.password.empty'),
            'password.between' => lzs_lang('lzscms::public.password.length.tips')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator, 'manageAuthLogin', 2);
        }
        if (!ManageUserModel::checkPassword($request->get('username'), $request->get('password'))) {
            ManageLoginLogModel::addLog(['uid'=>0, 'username'=>$request->get('username')], lzs_lang('lzscms::public.password.error'));
            return $this->showError(['password'=> lzs_lang('lzscms::public.password.error')], 'manageAuthLogin', 2);
        }
        $user = ManageUserModel::where('username', $request->get('username'))->first();
        if($user['status'] == 1) {
            ManageLoginLogModel::addLog($user, lzs_lang('lzscms::manage.user.disable'));
            return $this->showError(['password'=> lzs_lang('lzscms::manage.user.disable')], 'manageAuthLogin', 2);
        }
        ManageLoginLogModel::addLog($user, lzs_lang('lzscms::public.login.success'));
        ManageUserModel::managerDoLogin($user);
        return redirect()->route('manageIndex');
    }

    /**
     * 后台登出
     */
    public function logout()
    {
        ManageLoginLogModel::addLog(Lzs_manager(), lzs_lang('lzscms::public.logout.success'));
        Session::forget('manager');
        return redirect()->route('manageAuthLogin');
    }
}
