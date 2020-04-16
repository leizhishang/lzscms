<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Leizhishang\Lzscms\Model\ManageUserModel;
use Leizhishang\Lzscms\Model\CommonRoleModel;
use Leizhishang\Lzscms\Model\CommonRoleUriModel;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class UserController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
        $this->navs = [
            'user'=>['name'=>lzs_lang('lzscms::public.user'), 'url'=>'manageUserIndex'],
            'role'=>['name'=>lzs_lang('lzscms::public.role'), 'url'=>'manageRoleIndex']
        ];
    }

    public function index(Request $request)
    {
        $users = ManageUserModel::getUsers();
        $roles = CommonRoleModel::getRoles();
        $this->navs['add'] = ['name'=>lzs_lang('lzscms::public.add').lzs_lang('lzscms::public.user'), 'url'=>'manageUserAdd', 'class'=>'J_dialog', 'title'=>lzs_lang('lzscms::public.add').lzs_lang('lzscms::public.user')];
        $view = [
            'users'=>$users,
            'roles'=>$roles,
            'navs'=>$this->getNavs('user')
        ];
    	return $this->loadTemplate('user.index', $view);
    }

    public function add(Request $request)
    {
        $roles = CommonRoleModel::getRoles();
        $view = [
            'roles'=>$roles,
        ];
        return $this->loadTemplate('user.add', $view);
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gid' => 'required',
            'username' => 'required',
            'password' => 'required|between:6,16|string',
            'name' => 'required',
            //'email' => 'required|email',
            'mobile' => 'required'
        ],[
            'gid.required'=>lzs_lang('lzscms::manage.enter.one.role.name'),
            'username.required'=>lzs_lang('lzscms::public.username.empty'),
            'password.required'=>lzs_lang('lzscms::public.password.empty'),
            'password.between' => lzs_lang('lzscms::public.password.length.tips'),
            'name.required' => lzs_lang('lzscms::public.realname.empty'),
            'mobile.required'=>lzs_lang('lzscms::public.mobile.empty'),
            //'email.required'=>lzs_lang('lzscms::public.email.empty'),
            //'email.email'=>lzs_lang('lzscms::public.email.error')
        ]);

        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }

        if ($request->get('gid') < 1) {
            return $this->showError(lzs_lang('lzscms::manage.select.role'));
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
            'gid'=>trim($request->get('gid'))
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
        $user = ManageUserModel::where('uid', $uid)->first();
        if(!$user) {
            return $this->showError('lzscms::public.no.data');
        }
        $roles = CommonRoleModel::getRoles();
        $view = [
            'info'=>$user,
            'uid'=>$uid,
            'roles'=>$roles,
        ];
        return $this->loadTemplate('user.edit', $view);
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
            //'email' => 'required|email',
            'mobile' => 'required',
        ],[
            //'password.required'=>lzs_lang('lzscms::public.password.empty'),
            //'password.between' => lzs_lang('lzscms::public.password.length.tips'),
            'name.required' => lzs_lang('lzscms::public.realname.empty'),
            'mobile.required'=>lzs_lang('lzscms::public.mobile.empty'),
            //'email.required'=>lzs_lang('lzscms::public.email.empty'),
            //'email.email'=>lzs_lang('lzscms::public.email.empty')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        if ($request->get('gid') < 1) {
            return $this->showError(lzs_lang('lzscms::manage.select.role'));
        }
        $editData = [
            'name'=>trim($request->get('name')),
            'mobile'=>trim($request->get('mobile')),
            'email'=>trim($request->get('email')),
            'weixin'=>trim($request->get('weixin')),
            'qq'=>trim($request->get('qq')),
            'status'=>lzs_switch($request, 'status', true),
            'gid'=>trim($request->get('gid'))
        ];
        if($request->get('password')) {
            $editData['password'] = trim(lzs_md5(trim($request->get('password')), $user['salt']));
        }
        ManageUserModel::where('uid', $uid)->update($editData);
        ManageUserModel::setCache();
        $this->addOperationLog(lzs_lang('lzscms::manage.founder.user.edit').':'.$user['username'], '', $editData, $user->toArray());
        return $this->showMessage('lzscms::public.save.success'); 
    }

    public function delete($uid)
    {
        if(!$uid) {
            return $this->showError('lzscms::public.no.id');
        }
        $user = ManageUserModel::where('uid', $uid)->first();
        if(!$user) {
            return $this->showError('lzscms::public.no.data');
        }
        if($uid == lzs_manager('uid')) {
            return $this->showError('lzscms::manage.founder.delete.my');
        }
        ManageUserModel::where('uid', $uid)->delete();
        ManageUserModel::setCache();
        $this->addOperationLog(lzs_lang('lzscms::manage.founder.user.delete').':'.$user['username'], '', array(), $user->toArray());
        return $this->showMessage('lzscms::public.delete.success'); 
    }
}

