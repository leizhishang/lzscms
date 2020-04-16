<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Leizhishang\Lzscms\Model\ManageUserModel;
use Leizhishang\Lzscms\Model\CommonRoleModel;
use Leizhishang\Lzscms\Model\ManageMenuModel;
use Leizhishang\Lzscms\Model\CommonRoleUriModel;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class RoleController extends BasicController
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
        $roles = CommonRoleModel::get();
        $this->navs['add'] = ['name'=>lzs_lang('lzscms::public.add', 'lzscms::public.role'), 'url'=>'manageRoleAdd'];
        $view = [
            'roles'=>$roles,
            'navs'=>$this->getNavs('role')
        ];
    	return $this->loadTemplate('role.index', $view);
    }

    public function add(Request $request)
    {
        $menus = ManageMenuModel::getMenu();
        $roleUriDatas = CommonRoleUriModel::getRoleUriDatas();
        // print_r($roleUriDatas);
        $this->navs['add'] = ['name'=>lzs_lang('lzscms::public.add', 'lzscms::public.role'), 'url'=>'manageRoleAdd'];
        $view = [
            'navs'=>$this->getNavs('add'),
            'menus'=>$menus,
            'roleUriDatas'=>$roleUriDatas
        ];
        return $this->loadTemplate('role.add', $view);
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ],[
            'name.required'=>lzs_lang('lzscms::manage.role.name.empty'),
        ]);
        if ($validator->fails())
        {
            return $this->showError($validator->errors(), 2);
        }
        $role = CommonRoleModel::where('name', trim($request->get('name')))->first();
        if($role) {
            return $this->showError('lzscms::manage.role.name.one');
        }
        $postData = [
            'module'=>'manage',
            'name'=>trim($request->get('name')),
            'auths'=>implode(',', (array) $request->get('auths'))
        ];
        CommonRoleModel::insert($postData);
        CommonRoleModel::setCache();
        $this->addOperationLog(lzs_lang('lzscms::public.add', 'lzscms::public.role').':'.trim($request->get('name')), '', $postData, array());
        return $this->showMessage('lzscms::public.add.success', 'manageRoleIndex');
    }

    public function edit($id)
    {
        if(!$id) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = CommonRoleModel::where('id', $id)->first();
        if(!$info) {
            return $this->showError('lzscms::public.no.data');
        }
        $info['auths'] = explode(',', $info['auths']);
        $this->navs['edit'] = ['name'=>lzs_lang('lzscms::manage.role.edit'), 'url'=>route('manageRoleEdit', ['id'=>$id])];
        $menus = ManageMenuModel::getMenu();
        $roleUriDatas = CommonRoleUriModel::getRoleUriDatas();
        $view = [
            'navs'=>$this->getNavs('edit'),
            'info'=>$info,
            'id'=>$id,
            'menus'=>$menus,
            'roleUriDatas'=>$roleUriDatas
        ];
        return $this->loadTemplate('role.edit', $view);
    }

    public function editSave(Request $request)
    {
        $id = $request->get('id');
        if(!$id) {
            return $this->showError('lzscms::public.no.id');
        }
        $role = CommonRoleModel::where('id', $id)->first();
        if(!$role) {
            return $this->showError('lzscms::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ],[
            'name.required'=>lzs_lang('lzscms::manage.role.name.empty'),
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $editData = [
            'name'=>trim($request->get('name')),
            'auths'=>implode(',', (array) $request->get('auths'))
        ];
        CommonRoleModel::where('id', $id)->update($editData);
        CommonRoleModel::setCache();
        $this->addOperationLog(lzs_lang('lzscms::manage.role.edit').':'.trim($request->get('name')), '', $editData, $role->toArray());
        return $this->showMessage('lzscms::public.edit.success');
    }

    public function delete($id)
    {
        if(!$id) {
            return $this->showError('lzscms::public.no.id');
        }
        $role = CommonRoleModel::where('id', $id)->first();
        if(!$role) {
            return $this->showError('lzscms::public.no.data');
        }
        $userCount = ManageUserModel::where('gid', $id)->count();
        if($userCount) {
            return $this->showError('lzscms::manage.role.delete.error.001');
        }
        CommonRoleModel::where('id', $id)->delete();
        CommonRoleModel::setCache();
        $this->addOperationLog(lzs_lang('lzscms::manage.role.delete').':'.$role['name'], '', [], $role->toArray());
        return $this->showMessage('lzscms::public.delete.success');
    }
}

