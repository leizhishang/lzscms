<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Database\Seeds;

use Illuminate\Database\Seeder;

class ManageMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('manage_menu')->delete();
        \DB::table('manage_menu')->insert([
            [
                'name' => '系统配置',
                'ename' => 'system',
                'icon' => '',
                'url' => '',
                'parent' => 'root',
                'parents' => '',
                'level' => 1,
                'module' => 'manage'
            ],
            [
                'name' => '管理中心',
                'ename' => 'manage',
                'icon' => '',
                'url' => '',
                'parent' => 'system',
                'parents' => '',
                'level' => 2,
                'module' => 'manage'
            ],
            [
                'name' => '创始人',
                'ename' => 'manageFounderIndex',
                'icon' => '',
                'url' => 'manageFounderIndex',
                'parent' => 'system',
                'parents' => 'manage',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => '工作人员',
                'ename' => 'manageUserIndex',
                'icon' => '',
                'url' => 'manageUserIndex',
                'parent' => 'system',
                'parents' => 'manage',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => '安全配置',
                'ename' => 'manageSafeIndex',
                'icon' => '',
                'url' => 'manageSafeIndex',
                'parent' => 'system',
                'parents' => 'manage',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => '日志管理',
                'ename' => 'manageLogRequest',
                'icon' => '',
                'url' => 'manageLogRequest',
                'parent' => 'system',
                'parents' => 'manage',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => '菜单权限',
                'ename' => 'manageMenuNav',
                'icon' => '',
                'url' => 'manageMenuNav',
                'parent' => 'system',
                'parents' => 'manage',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => '全局',
                'ename' => 'config',
                'icon' => '',
                'url' => '',
                'parent' => 'system',
                'parents' => '',
                'level' => 2,
                'module' => 'manage'
            ],
            [
                'name' => Lzs_lang('Lzscms::manage.config.site'),
                'ename' => 'manageConfigIndex',
                'icon' => '',
                'url' => 'manageConfigIndex',
                'parent' => 'system',
                'parents' => 'config',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => Lzs_lang('Lzscms::manage.config.global'),
                'ename' => 'manageConfigGlobal',
                'icon' => '',
                'url' => 'manageConfigGlobal',
                'parent' => 'system',
                'parents' => 'config',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => '电子邮箱',
                'ename' => 'manageConfigEmailIndex',
                'icon' => '',
                'url' => 'manageConfigEmailIndex',
                'parent' => 'system',
                'parents' => 'config',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => '工具',
                'ename' => 'tool',
                'icon' => '',
                'url' => '',
                'parent' => 'system',
                'parents' => '',
                'level' => 2,
                'module' => 'manage'
            ]

        ]);
    }
}