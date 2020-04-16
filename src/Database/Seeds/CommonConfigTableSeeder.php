<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Database\Seeds;

use Illuminate\Database\Seeder;

class CommonConfigTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('common_config')->delete();
        \DB::table('common_config')->insert([
                [   
                    'name' => 'name',
                    'namespace' => 'site',
                    'value' => '我的网站',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1
                ],[
                    'name' => 'icp',
                    'namespace' => 'site',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1
                ], [
                    'name' => 'headerhtml',
                    'namespace' => 'site',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1
                ], [
                    'name' => 'footerhtml',
                    'namespace' => 'site',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1
                ], [
                    'name' => 'timezone',
                    'namespace' => 'site',
                    'value' => 'Asia/Shanghai',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1
                ], [
                    'name' => 'timecv',
                    'namespace' => 'site',
                    'value' => '0',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1
                ], [
                    'name' => 'vstate',
                    'namespace' => 'site',
                    'value' => '0',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1
                ], [
                    'name' => 'vmessage',
                    'namespace' => 'site',
                    'value' => '网站正关闭维护中，请稍微访问',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1
                ], [
                    'name' => 'vmtemplate',
                    'namespace' => 'site',
                    'value' => 'Lzscms::common.close',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1
                ], [
                    'name' => 'url',
                    'namespace' => 'site',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1
                ], [
                    'name' => 'host',
                    'namespace' => 'email',
                    'value' => 'smtp.ym.163.com',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'port',
                    'namespace' => 'email',
                    'value' => '25',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'from',
                    'namespace' => 'email',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'from.name',
                    'namespace' => 'email',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'auth',
                    'namespace' => 'email',
                    'value' => '1',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'user',
                    'namespace' => 'email',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'password',
                    'namespace' => 'email',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'manage.request',
                    'namespace' => 'safe',
                    'value' => '1',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1
                ], [
                    'name' => 'manage.operation',
                    'namespace' => 'safe',
                    'value' => '1',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1
                ], [
                    'name' => 'manage.login.ips',
                    'namespace' => 'safe',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1
                ], [
                    'name' => 'manage.login.ctime',
                    'namespace' => 'safe',
                    'value' => '60',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1
                ], [
                    'name' => 'extsize',
                    'namespace' => 'attachment',
                    'value' => 'a:7:{s:3:"jpg";i:2048;s:3:"gif";i:2048;s:3:"png";i:2048;s:3:"bmp";i:2048;s:3:"xls";i:2048;s:4:"jpeg";i:2048;s:3:"zip";i:2048;}',
                    'vtype' => 'array',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'storage',
                    'namespace' => 'attachment',
                    'value' => 'local',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'dirs',
                    'namespace' => 'attachment',
                    'value' => 'ymd',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'key',
                    'namespace' => 'api',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'codelength',
                    'namespace' => 'sms',
                    'value' => '6',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'types',
                    'namespace' => 'sms',
                    'value' => 'a:3:{s:8:"register";a:2:{s:6:"status";i:1;s:7:"content";N;}s:5:"login";a:2:{s:6:"status";i:1;s:7:"content";N;}s:6:"findpw";a:2:{s:6:"status";i:1;s:7:"content";N;}}',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'platform',
                    'namespace' => 'sms',
                    'value' => 'Leizhishang',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'hstsmsdaima',
                    'namespace' => 'sms',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'hstsmskey',
                    'namespace' => 'sms',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ], [
                    'name' => 'hstsmssign',
                    'namespace' => 'sms',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ],[
                    'name' => 'width',
                    'namespace' => 'captcha',
                    'value' => '120',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ],[
                    'name' => 'height',
                    'namespace' => 'captcha',
                    'value' => '60',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ],[
                    'name' => 'length',
                    'namespace' => 'captcha',
                    'value' => '5',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 0
                ]
            ]
        );
    }
}