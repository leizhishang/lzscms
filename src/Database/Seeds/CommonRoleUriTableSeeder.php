<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Database\Seeds;

use Illuminate\Database\Seeder;

class CommonRoleUriTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('common_role_uri')->delete();
        \DB::table('common_role_uri')->insert([
            [
                'name' => '配置',
                'uri' => 'custom/set',
                'parent' => 'customSet',
                'module' => 'manage',
                'ename' => 'customSet',
                'remark' => '常用设置'
            ],[
                'name' => '保存',
                'uri' => 'custom/set/save',
                'parent' => 'customSet',
                'module' => 'manage',
                'ename' => 'customSetSave',
                'remark' => '常用设置'
            ],
            [
                'name' => '配置',
                'uri' => 'safe/index',
                'parent' => 'manageSafeIndex',
                'module' => 'manage',
                'ename' => 'manageSafeIndex',
                'remark' => '安全配置'
            ],[
                'name' => '保存',
                'uri' => 'safe/save',
                'parent' => 'manageSafeIndex',
                'module' => 'manage',
                'ename' => 'manageSafeSave',
                'remark' => '安全配置'
            ],[
                'name' => '请求日志',
                'uri' => 'log/request',
                'parent' => 'manageLogRequest',
                'module' => 'manage',
                'ename' => 'manageLogRequest',
                'remark' => '日志管理'
            ],[
                'name' => '操作日志',
                'uri' => 'log/operation',
                'parent' => 'manageLogRequest',
                'module' => 'manage',
                'ename' => 'manageLogOperation',
                'remark' => '日志管理'
            ],[
                'name' => '登录日志',
                'uri' => 'log/login',
                'parent' => 'manageLogRequest',
                'module' => 'manage',
                'ename' => 'manageLogLogin',
                'remark' => '日志管理'
            ],[
                'name' => '查看操作日志',
                'uri' => 'log/operation/view/{id}',
                'parent' => 'manageLogRequest',
                'module' => 'manage',
                'ename' => 'manageLogOperationView',
                'remark' => '日志管理'
            ],[
                'name' => '管理',
                'uri' => 'founder/index',
                'parent' => 'manageFounderIndex',
                'module' => 'manage',
                'ename' => 'manageFounderIndex',
                'remark' => '创始人'
            ],[
                'name' => '添加',
                'uri' => 'founder/add',
                'parent' => 'manageFounderIndex',
                'module' => 'manage',
                'ename' => 'manageFounderAdd',
                'remark' => '创始人'
            ],[
                'name' => '添加保存',
                'uri' => 'founder/add/save',
                'parent' => 'manageFounderIndex',
                'module' => 'manage',
                'ename' => 'manageFounderAddSave',
                'remark' => '创始人'
            ],[
                'name' => '编辑',
                'uri' => 'founder/edit/{uid}',
                'parent' => 'manageFounderIndex',
                'module' => 'manage',
                'ename' => 'manageFounderEdit',
                'remark' => '创始人'
            ],[
                'name' => '编辑保存',
                'uri' => 'founder/edit/save',
                'parent' => 'manageFounderIndex',
                'module' => 'manage',
                'ename' => 'manageFounderEditSave',
                'remark' => '创始人'
            ],[
                'name' => '删除',
                'uri' => 'founder/delete',
                'parent' => 'manageFounderIndex',
                'module' => 'manage',
                'ename' => 'manageFounderDelete',
                'remark' => '创始人'
            ],[
                'name' => '管理',
                'uri' => 'user/index',
                'parent' => 'manageUserIndex',
                'module' => 'manage',
                'ename' => 'manageUserIndex',
                'remark' => '工作人员'
            ],[
                'name' => '添加',
                'uri' => 'user/add',
                'parent' => 'manageUserIndex',
                'module' => 'manage',
                'ename' => 'manageUserAdd',
                'remark' => '工作人员'
            ],[
                'name' => '添加保存',
                'uri' => 'user/add/save',
                'parent' => 'manageUserIndex',
                'module' => 'manage',
                'ename' => 'manageUserAddSave',
                'remark' => '工作人员'
            ],[
                'name' => '编辑',
                'uri' => 'user/edit/{id}',
                'parent' => 'manageUserIndex',
                'module' => 'manage',
                'ename' => 'manageUserEdit',
                'remark' => '工作人员'
            ],[
                'name' => '编辑保存',
                'uri' => 'user/edit/save',
                'parent' => 'manageUserIndex',
                'module' => 'manage',
                'ename' => 'manageUserEditSave',
                'remark' => '工作人员'
            ],[
                'name' => '删除',
                'uri' => 'user/delete',
                'parent' => 'manageUserIndex',
                'module' => 'manage',
                'ename' => 'manageUserDelete',
                'remark' => '工作人员'
            ],[
                'name' => '管理',
                'uri' => 'menu/nav',
                'parent' => 'manageMenuNav',
                'module' => 'manage',
                'ename' => 'manageMenuNav',
                'remark' => '菜单'
            ],[
                'name' => '添加',
                'uri' => 'menu/nav/add',
                'parent' => 'manageMenuNav',
                'module' => 'manage',
                'ename' => 'manageMenuNavAdd',
                'remark' => '菜单'
            ],[
                'name' => '添加保存',
                'uri' => 'menu/nav/add/save',
                'parent' => 'manageMenuNav',
                'module' => 'manage',
                'ename' => 'manageMenuNavAddSave',
                'remark' => '菜单'
            ],[
                'name' => '编辑',
                'uri' => 'menu/nav/edit/{id}',
                'parent' => 'manageMenuNav',
                'module' => 'manage',
                'ename' => 'manageMenuNavEdit',
                'remark' => '菜单'
            ],[
                'name' => '编辑保存',
                'uri' => 'menu/nav/edit/save',
                'parent' => 'manageMenuNav',
                'module' => 'manage',
                'ename' => 'manageMenuNavEditSave',
                'remark' => '菜单'
            ],[
                'name' => '删除',
                'uri' => 'menu/nav/delete',
                'parent' => 'manageMenuNava',
                'module' => 'manage',
                'ename' => 'manageMenuNavDelete',
                'remark' => '菜单'
            ],[
                'name' => '角色',
                'uri' => 'role/index',
                'parent' => 'manageUserIndex',
                'module' => 'manage',
                'ename' => 'manageRoleIndex',
                'remark' => '工作人员角色'
            ],[
                'name' => '角色添加',
                'uri' => 'role/add',
                'parent' => 'manageUserIndex',
                'module' => 'manage',
                'ename' => 'manageRoleAdd',
                'remark' => '工作人员角色'
            ],[
                'name' => '角色添加保存',
                'uri' => 'role/add/save',
                'parent' => 'manageUserIndex',
                'module' => 'manage',
                'ename' => 'manageRoleAddSave',
                'remark' => '工作人员角色'
            ],[
                'name' => '角色编辑',
                'uri' => 'role/edit/{id}',
                'parent' => 'manageUserIndex',
                'module' => 'manage',
                'ename' => 'manageRoleEdit',
                'remark' => '工作人员角色'
            ],[
                'name' => '角色编辑保存',
                'uri' => 'role/edit/save',
                'parent' => 'manageUserIndex',
                'module' => 'manage',
                'ename' => 'manageRoleEditSave',
                'remark' => '工作人员角色'
            ],[
                'name' => '角色删除',
                'uri' => 'role/delete/{id}',
                'parent' => 'manageUserIndex',
                'module' => 'manage',
                'ename' => 'manageRoleDelete',
                'remark' => '工作人员角色'
            ],[
                'name' => '邮箱配置',
                'uri' => 'config/email',
                'parent' => 'manageConfigEmailIndex',
                'module' => 'manage',
                'ename' => 'manageConfigEmailIndex',
                'remark' => '邮箱配置'
            ],[
                'name' => '保存',
                'uri' => 'config/email/save',
                'parent' => 'manageConfigEmailIndex',
                'module' => 'manage',
                'ename' => 'manageConfigEmailSave',
                'remark' => '邮箱配置'
            ],[
                'name' => '测试',
                'uri' => 'config/email/test',
                'parent' => 'manageConfigEmailIndex',
                'module' => 'manage',
                'ename' => 'manageConfigEmailTest',
                'remark' => '邮箱配置'
            ],[
                'name' => '测试发送',
                'uri' => 'config/email/test/submit',
                'parent' => 'manageConfigEmailIndex',
                'module' => 'manage',
                'ename' => 'manageConfigEmailTestSubmit',
                'remark' => '邮箱配置'
            ],[
                'name' => 'FTP配置',
                'uri' => 'config/ftp',
                'parent' => 'manageConfigFtpIndex',
                'module' => 'manage',
                'ename' => 'manageConfigFtpIndex',
                'remark' => 'FTP配置'
            ],[
                'name' => '保存',
                'uri' => 'config/ftp/save',
                'parent' => 'manageConfigFtpIndex',
                'module' => 'manage',
                'ename' => 'manageConfigFtpSave',
                'remark' => 'FTP配置'
            ]
        ]);
    }
}