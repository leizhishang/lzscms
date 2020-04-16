<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Hook;

/**
* 
*/
class LzscmsConfigHook 
{
	/**
     * 后台菜单钩子
     *
     * @param array $data 菜单数组
     * @return array
     */
    public function getManageMenu($data)
    {
        $data['content'] = [
            'name' => lzs_lang('lzscms::public.content'),
            'ename' => 'content',
            'icon' => '',
            'url' => '',
            'parent' => 'system',
            'parents' => '',
            'level' => 2,
            'module' => 'Lzscms'
        ];
        $data['manageHookIndex'] = [
            'name' => 'Hook',
            'ename' => 'manageHookIndex',
            'icon' => '',
            'url' => 'manageHookIndex',
            'parent' => 'system',
            'parents' => 'tool',
            'level' => 3,
            'module' => 'Lzscms'
        ];
        $data['manageSms'] = [
            'name' => lzs_lang('lzscms::manage.sms.service'),
            'ename' => 'manageSms',
            'icon' => '',
            'url' => 'manageSms',
            'parent' => 'system',
            'parents' => 'config',
            'level' => 3,
            'module' => 'Lzscms'
        ];
        $data['manageAttach'] = [
            'name' => lzs_lang('lzscms::manage.attach.service'),
            'ename' => 'manageAttach',
            'icon' => '',
            'url' => 'manageAttach',
            'parent' => 'system',
            'parents' => 'config',
            'level' => 3,
            'module' => 'Lzscms'
        ];
        // $data['manageApi'] = [
        //     'name' => lzs_lang('lzscms::manage.api.service'),
        //     'ename' => 'manageApi',
        //     'icon' => '',
        //     'url' => 'manageApi',
        //     'parent' => 'system',
        //     'parents' => 'tool',
        //     'level' => 3,
        //     'module' => 'Lzscms'
        // ];
        $data['manageModules'] = [
            'name' => lzs_lang('lzscms::manage.modules.manage'),
            'ename' => 'manageModules',
            'icon' => '',
            'url' => 'manageModules',
            'parent' => 'system',
            'parents' => 'tool',
            'level' => 3,
            'module' => 'Lzscms'
        ];
        $data['manageCaches'] = [
            'name' => lzs_lang('lzscms::manage.caches.manage'),
            'ename' => 'manageCaches',
            'icon' => '',
            'url' => 'manageCaches',
            'parent' => 'system',
            'parents' => 'tool',
            'level' => 3,
            'module' => 'Lzscms'
        ];
        $data['manageCheckIndex'] = [
            'name' => lzs_lang('lzscms::manage.check.manage'),
            'ename' => 'manageCheckIndex',
            'icon' => '',
            'url' => 'manageCheckIndex',
            'parent' => 'system',
            'parents' => 'tool',
            'level' => 3,
            'module' => 'Lzscms'
        ];

        $data['manageCaptchaIndex'] = [
            'name' => lzs_lang('lzscms::captcha.name'),
            'ename' => 'manageCaptchaIndex',
            'icon' => '',
            'url' => 'manageCaptchaIndex',
            'parent' => 'system',
            'parents' => 'config',
            'level' => 3,
            'module' => 'Lzscms'
        ];
        $data['manageFormIndex'] = [
            'name' => lzs_lang('lzscms::manage.form').lzs_lang('lzscms::public.manage'),
            'ename' => 'manageFormIndex',
            'icon' => '',
            'url' => 'manageFormIndex',
            'parent' => 'system',
            'parents' => 'content',
            'level' => 3,
            'module' => 'Lzscms'
        ];
        $data['manageSpecialIndex'] = [
            'name' => lzs_lang('lzscms::manage.special.manage'),
            'ename' => 'manageSpecialIndex',
            'icon' => '',
            'url' => 'manageSpecialIndex',
            'parent' => 'system',
            'parents' => 'content',
            'level' => 3,
            'module' => 'Lzscms'
        ];
        $data['manageAreaIndex'] = [
            'name' => lzs_lang('lzscms::manage.area.manage'),
            'ename' => 'manageAreaIndex',
            'icon' => '',
            'url' => 'manageAreaIndex',
            'parent' => 'system',
            'parents' => 'config',
            'level' => 3,
            'module' => 'Lzscms'
        ];
        $data['manageBlockIndex'] = [
            'name' => lzs_lang('lzscms::manage.block'),
            'ename' => 'manageBlockIndex',
            'icon' => '',
            'url' => 'manageBlockIndex',
            'parent' => 'system',
            'parents' => 'content',
            'level' => 3,
            'module' => 'Lzscms'
        ];
        return $data;
    }

    /**
     * 后台权限点
     *
     * @param array $data 数组
     * @return array
     */
    public function getCommonRoleUri($data)
    {
        $data['manageHookIndex'] = [
            'name' => lzs_lang('lzscms::public.manage'),
            'remark' => 'HOOK',
            'ename' => 'manageHookIndex',
            'uri' => 'hook',
            'parent' => 'manageHookIndex',
            'module' => 'manage'
        ];
        $data['manageHookAdd'] = [
            'name' => lzs_lang('lzscms::public.add'),
            'remark' => 'HOOK',
            'ename' => 'manageHookAdd',
            'uri' => 'hook/add',
            'parent' => 'manageHookIndex',
            'module' => 'manage'
        ];
        $data['manageHookAddSave'] = [
            'name' => lzs_lang('lzscms::public.add', 'Lzscms::public.save'),
            'remark' => 'HOOK',
            'ename' => 'manageHookAddSave',
            'uri' => 'hook/add/save',
            'parent' => 'manageHookIndex',
            'module' => 'manage'
        ];
        $data['manageHookEdit'] = [
            'name' => lzs_lang('lzscms::public.edit'),
            'remark' => 'HOOK',
            'ename' => 'manageHookEdit',
            'uri' => 'hook/edit/{name}',
            'parent' => 'manageHookIndex',
            'module' => 'manage'
        ];
        $data['manageHookEditSave'] = [
            'name' => lzs_lang('lzscms::public.edit', 'Lzscms::public.save'),
            'remark' => 'HOOK',
            'ename' => 'manageHookEditSave',
            'uri' => 'hook/edit/save',
            'parent' => 'manageHookIndex',
            'module' => 'manage'
        ];
        $data['manageHookDelete'] = [
            'name' => lzs_lang('lzscms::public.delete'),
            'remark' => 'HOOK',
            'ename' => 'manageHookDelete',
            'uri' => 'hook/delete/{name}',
            'parent' => 'manageHookIndex',
            'module' => 'manage'
        ];
        $data['manageHookCache'] = [
            'name' => lzs_lang('lzscms::public.cache'),
            'remark' => 'HOOK',
            'ename' => 'manageHookCache',
            'uri' => 'hook/cache',
            'parent' => 'manageHookIndex',
            'module' => 'manage'
        ];
        $data['manageHookInjectIndex'] = [
            'name' => lzs_lang('lzscms::public.manage'),
            'remark' => 'Hook Inject',
            'ename' => 'manageHookInjectIndex',
            'uri' => 'hook/inject/{name}',
            'parent' => 'manageHookIndex',
            'module' => 'manage'
        ];
        $data['manageHookInjectIndex'] = [
            'name' => lzs_lang('lzscms::public.add'),
            'remark' => 'Hook Inject',
            'ename' => 'manageHookInjectIndex',
            'uri' => 'hook/inject/{name}/add',
            'parent' => 'manageHookIndex',
            'module' => 'manage'
        ];
        $data['manageHookInjectIndex'] = [
            'name' => lzs_lang('lzscms::public.add', 'Lzscms::public.save'),
            'remark' => 'Hook Inject',
            'ename' => 'manageHookInjectIndex',
            'uri' => 'hook/inject/{name}/add/save',
            'parent' => 'manageHookIndex',
            'module' => 'manage'
        ];
        $data['manageHookInjectIndex'] = [
            'name' => lzs_lang('lzscms::public.edit'),
            'remark' => 'Hook Inject',
            'ename' => 'manageHookInjectIndex',
            'uri' => 'hook/inject/{name}/edit/{id}',
            'parent' => 'manageHookIndex',
            'module' => 'manage'
        ];
        $data['manageHookInjectIndex'] = [
            'name' => lzs_lang('lzscms::public.edit', 'Lzscms::public.save'),
            'remark' => 'Hook Inject',
            'ename' => 'manageHookInjectIndex',
            'uri' => 'hook/inject/{name}/edit/save',
            'parent' => 'manageHookIndex',
            'module' => 'manage'
        ];
        $data['manageHookInjectDelete'] = [
            'name' => lzs_lang('lzscms::public.delete'),
            'remark' => 'Hook Inject',
            'ename' => 'manageHookInjectDelete',
            'uri' => 'hook/inject/{name}/delete/{id}',
            'parent' => 'manageHookIndex',
            'module' => 'manage'
        ];
        $data['manageSms'] = [
            'name' => lzs_lang('lzscms::manage.sms.service'),
            'remark' => 'Lzscms',
            'ename' => 'manageSms',
            'uri' => 'sms',
            'parent' => 'manageSms',
            'module' => 'Lzscms'
        ];
        $data['manageSmsSave'] = [
            'name' => lzs_lang('lzscms::manage.sms.service').lzs_lang('lzscms::public.save'),
            'remark' => 'Lzscms',
            'ename' => 'manageSmsSave',
            'uri' => 'sms/save',
            'parent' => 'manageSms',
            'module' => 'Lzscms'
        ];
        $data['manageAttach'] = [
            'name' => lzs_lang('lzscms::manage.attach.service'),
            'remark' => 'Lzscms',
            'ename' => 'manageAttach',
            'uri' => 'attachments',
            'parent' => 'manageAttach',
            'module' => 'Lzscms'
        ];
        $data['manageAttachSave'] = [
            'name' => lzs_lang('lzscms::manage.attach.service').lzs_lang('lzscms::public.save'),
            'remark' => 'Lzscms',
            'ename' => 'manageAttachSave',
            'uri' => 'attachments/save',
            'parent' => 'manageAttach',
            'module' => 'Lzscms'
        ];
        $data['manageApi'] = [
            'name' => lzs_lang('lzscms::manage.api.service'),
            'remark' => 'Lzscms',
            'ename' => 'manageApi',
            'uri' => 'api',
            'parent' => 'manageApi',
            'module' => 'Lzscms'
        ];
        $data['manageApiSave'] = [
            'name' => lzs_lang('lzscms::manage.api.service').lzs_lang('lzscms::public.save'),
            'remark' => 'Lzscms',
            'ename' => 'manageApiSave',
            'uri' => 'api/save',
            'parent' => 'manageApi',
            'module' => 'Lzscms'
        ];
        $data['manageConfigIndex'] = [
            'name' => lzs_lang('lzscms::manage.config.site'),
            'remark' => 'Lzscms',
            'ename' => 'manageConfigIndex',
            'uri' => 'index',
            'parent' => 'manageConfigIndex',
            'module' => 'Lzscms'
        ];
        $data['mymanageConfigSave'] = [
            'name' => lzs_lang('lzscms::manage.config.site').lzs_lang('lzscms::public.save'),
            'remark' => 'Lzscms',
            'ename' => 'mymanageConfigSave',
            'uri' => 'save',
            'parent' => 'manageConfigIndex',
            'module' => 'Lzscms'
        ];
        $data['manageConfigGlobal'] = [
            'name' => lzs_lang('lzscms::manage.config.global'),
            'remark' => 'Lzscms',
            'ename' => 'manageConfigGlobal',
            'uri' => 'index',
            'parent' => 'manageConfigGlobal',
            'module' => 'Lzscms'
        ];
        $data['manageConfigGlobalSave'] = [
            'name' => lzs_lang('lzscms::manage.config.global').lzs_lang('lzscms::public.save'),
            'remark' => 'Lzscms',
            'ename' => 'manageConfigGlobalSave',
            'uri' => 'index',
            'parent' => 'manageConfigGlobal',
            'module' => 'Lzscms'
        ];
        $data['manageModules'] = [
            'name' => lzs_lang('lzscms::public.manage'),
            'remark' => 'Lzscms',
            'ename' => 'manageModules',
            'uri' => 'modules',
            'parent' => 'manageModules',
            'module' => 'Lzscms'
        ];
        $data['manageModulesUninstalls'] = [
            'name' => lzs_lang('lzscms::manage.modules.uninstalls'),
            'remark' => 'Lzscms',
            'ename' => 'manageModulesUninstalls',
            'uri' => 'modules/uninstalls',
            'parent' => 'manageModules',
            'module' => 'Lzscms'
        ];
        $data['manageModulesDoinstalls'] = [
            'name' => lzs_lang('lzscms::public.install'),
            'remark' => 'Lzscms',
            'ename' => 'manageModulesDoinstalls',
            'uri' => 'modules/doinstalls',
            'parent' => 'manageModules',
            'module' => 'Lzscms'
        ];
        $data['manageModulesEnableds'] = [
            'name' => lzs_lang('lzscms::public.operation'),
            'remark' => 'Lzscms',
            'ename' => 'manageModulesEnableds',
            'uri' => 'modules/enableds',
            'parent' => 'manageModules',
            'module' => 'Lzscms'
        ];
        $data['manageModulesDouninstall'] = [
            'name' => lzs_lang('lzscms::public.uninstall'),
            'remark' => 'Lzscms',
            'ename' => 'manageModulesDouninstall',
            'uri' => 'modules/douninstall',
            'parent' => 'manageModules',
            'module' => 'Lzscms'
        ];
        $data['manageModulesCache'] = [
            'name' => lzs_lang('lzscms::public.cache'),
            'remark' => 'Lzscms',
            'ename' => 'manageModulesCache',
            'uri' => 'modules/cache',
            'parent' => 'manageModules',
            'module' => 'Lzscms'
        ];
        $data['manageCaches'] = [
            'name' => lzs_lang('lzscms::manage.caches.manage'),
            'remark' => 'Lzscms',
            'ename' => 'manageCaches',
            'uri' => 'caches',
            'parent' => 'manageCaches',
            'module' => 'Lzscms'
        ];
        $data['manageCachesSave'] = [
            'name' => lzs_lang('lzscms::public.save'),
            'remark' => 'Lzscms',
            'ename' => 'manageCachesSave',
            'uri' => 'caches/save',
            'parent' => 'manageCaches',
            'module' => 'Lzscms'
        ];
        $data['manageCachesMemcachedConfig'] = [
            'name' => lzs_lang('lzscms::manage.caches.memcached.setting'),
            'remark' => 'Lzscms',
            'ename' => 'manageCachesMemcachedConfig',
            'uri' => '/caches/memcached/config',
            'parent' => 'manageCaches',
            'module' => 'Lzscms'
        ];
        $data['manageCachesMemcachedConfigSave'] = [
            'name' => lzs_lang('lzscms::public.save', 'Lzscms::manage.caches.memcached.setting'),
            'remark' => 'Lzscms',
            'ename' => 'manageCachesMemcachedConfigSave',
            'uri' => '/caches/memcached/config/save',
            'parent' => 'manageCaches',
            'module' => 'Lzscms'
        ];
        $data['manageCachesRedisConfig'] = [
            'name' => lzs_lang('lzscms::manage.caches.redis.setting'),
            'remark' => 'Lzscms',
            'ename' => 'manageCachesRedisConfig',
            'uri' => '/caches/redis/config',
            'parent' => 'manageCaches',
            'module' => 'Lzscms'
        ];
        $data['manageCachesRedisConfigSave'] = [
            'name' => lzs_lang('lzscms::public.save', 'Lzscms::manage.caches.redis.setting'),
            'remark' => 'Lzscms',
            'ename' => 'manageCachesRedisConfigSave',
            'uri' => 'caches/redis/config/save',
            'parent' => 'manageCaches',
            'module' => 'Lzscms'
        ];
        $data['manageCaptchaIndex'] = [
            'name' => lzs_lang('lzscms::captcha.name'),
            'remark' => 'captcha',
            'ename' => 'manageCaptchaIndex',
            'uri' => 'captcha/index',
            'parent' => 'manageCaptchaIndex',
            'module' => 'Lzscms'
        ];
        $data['manageCaptchaSave'] = [
            'name' => lzs_lang('lzscms::captcha.save'),
            'remark' => 'captcha',
            'ename' => 'manageCaptchaSave',
            'uri' => 'captcha/save',
            'parent' => 'manageCaptchaIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFormIndex'] = [
            'name' => lzs_lang('lzscms::public.manage'),
            'remark' => 'form',
            'ename' => 'manageFormIndex',
            'uri' => 'form/index',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFormAdd'] = [
            'name' => lzs_lang('lzscms::public.add'),
            'remark' => 'form',
            'ename' => 'manageFormAdd',
            'uri' => 'form/add',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFormAddSave'] = [
            'name' => lzs_lang('lzscms::public.add').lzs_lang('lzscms::public.save'),
            'remark' => 'form',
            'ename' => 'manageFormAddSave',
            'uri' => 'form/save',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFormEdit'] = [
            'name' => lzs_lang('lzscms::public.edit'),
            'remark' => 'form',
            'ename' => 'manageFormEdit',
            'uri' => 'form/edit/{id}',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFormEditSave'] = [
            'name' => lzs_lang('lzscms::public.edit').lzs_lang('lzscms::public.save'),
            'remark' => 'form',
            'ename' => 'manageFormEditSave',
            'uri' => 'form/edit/save',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFormDelete'] = [
            'name' => lzs_lang('lzscms::public.delete'),
            'remark' => 'form',
            'ename' => 'manageFormDelete',
            'uri' => 'form/delete/{id}',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFormContent'] = [
            'name' => lzs_lang('lzscms::manage.form.content').lzs_lang('lzscms::public.manage'),
            'remark' => 'form',
            'ename' => 'manageFormContent',
            'uri' => 'form/content/{formid}',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFormContentAdd'] = [
            'name' => lzs_lang('lzscms::manage.form.content').lzs_lang('lzscms::public.add'),
            'remark' => 'form',
            'ename' => 'manageFormContentAdd',
            'uri' => 'form/content/add/{formid}',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFormContentAddSave'] = [
            'name' => lzs_lang('lzscms::manage.form.content').lzs_lang('lzscms::public.add', 'Lzscms::public.save'),
            'remark' => 'form',
            'ename' => 'manageFormContentAddSave',
            'uri' => 'form/content/add/save/{formid}',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFormContentEdit'] = [
            'name' => lzs_lang('lzscms::manage.form.content').lzs_lang('lzscms::public.edit'),
            'remark' => 'form',
            'ename' => 'manageFormContentEdit',
            'uri' => 'form/content/edit/{formid}/{id}',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFormContentEditSave'] = [
            'name' => lzs_lang('lzscms::manage.form.content').lzs_lang('lzscms::public.edit', 'Lzscms::public.save'),
            'remark' => 'form',
            'ename' => 'manageFormContentEditSave',
            'uri' => 'form/content/edit/save/{formid}',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFormContentDelete'] = [
            'name' => lzs_lang('lzscms::manage.form.content').lzs_lang('lzscms::public.delete'),
            'remark' => 'form',
            'ename' => 'manageFormContentDelete',
            'uri' => 'form/content/delete/{formid}/{id}',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFieldsIndex'] = [
            'name' => lzs_lang('lzscms::public.field').lzs_lang('lzscms::public.manage'),
            'remark' => 'form',
            'ename' => 'manageFieldsIndex',
            'uri' => 'fields',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFieldsSave'] = [
            'name' => lzs_lang('lzscms::public.field').lzs_lang('lzscms::public.save'),
            'remark' => 'form',
            'ename' => 'manageFieldsSave',
            'uri' => 'fields/save',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFieldsAdd'] = [
            'name' => lzs_lang('lzscms::public.field').lzs_lang('lzscms::public.add'),
            'remark' => 'form',
            'ename' => 'manageFieldsAdd',
            'uri' => 'fields/add',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFieldsAddSave'] = [
            'name' => lzs_lang('lzscms::public.field').lzs_lang('lzscms::public.add','Lzscms::public.save'),
            'remark' => 'form',
            'ename' => 'manageFieldsAddSave',
            'uri' => 'fields/add/save',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFieldsEdit'] = [
            'name' => lzs_lang('lzscms::public.field').lzs_lang('lzscms::public.edit'),
            'remark' => 'form',
            'ename' => 'manageFieldsEdit',
            'uri' => 'fields/edit',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFieldsEditSave'] = [
            'name' => lzs_lang('lzscms::public.field').lzs_lang('lzscms::public.edit','Lzscms::public.save'),
            'remark' => 'form',
            'ename' => 'manageFieldsEditSave',
            'uri' => 'fields/edit/save',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFieldsCache'] = [
            'name' => lzs_lang('lzscms::public.field').lzs_lang('lzscms::public.cache'),
            'remark' => 'form',
            'ename' => 'manageFieldsCache',
            'uri' => 'fields/cache',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageFieldsDelete'] = [
            'name' => lzs_lang('lzscms::public.field').lzs_lang('lzscms::public.delete'),
            'remark' => 'form',
            'ename' => 'manageFieldsDelete',
            'uri' => 'fields/delete',
            'parent' => 'manageFormIndex',
            'module' => 'Lzscms'
        ];
        $data['manageSpecialIndex'] = [
            'name' => lzs_lang('lzscms::manage.special.manage'),
            'remark' => 'special',
            'ename' => 'manageSpecialIndex',
            'uri' => 'special',
            'parent' => 'manageSpecialIndex',
            'module' => 'Lzscms'
        ];
        $data['manageSpecialCache'] = [
            'name' => lzs_lang('lzscms::public.cache'),
            'remark' => 'special cache',
            'ename' => 'manageSpecialCache',
            'uri' => 'special/cache',
            'parent' => 'manageSpecialIndex',
            'module' => 'Lzscms'
        ];
        $data['manageSpecialAdd'] = [
            'name' => lzs_lang('lzscms::public.add'),
            'remark' => 'special add',
            'ename' => 'manageSpecialAdd',
            'uri' => 'special/add',
            'parent' => 'manageSpecialIndex',
            'module' => 'Lzscms'
        ];
        $data['manageSpecialAddSave'] = [
            'name' => lzs_lang('lzscms::public.add','Lzscms::public.save'),
            'remark' => 'special add save',
            'ename' => 'manageSpecialAddSave',
            'uri' => 'special/add/save',
            'parent' => 'manageSpecialIndex',
            'module' => 'Lzscms'
        ];
        $data['manageSpecialEdit'] = [
            'name' => lzs_lang('lzscms::public.edit'),
            'remark' => 'special edit',
            'ename' => 'manageSpecialEdit',
            'uri' => 'special/edit/{id}',
            'parent' => 'manageSpecialIndex',
            'module' => 'Lzscms'
        ];
        $data['manageSpecialEditSave'] = [
            'name' => lzs_lang('lzscms::public.edit','Lzscms::public.save'),
            'remark' => 'special edit save',
            'ename' => 'manageSpecialEditSave',
            'uri' => 'special/edit/save',
            'parent' => 'manageSpecialIndex',
            'module' => 'Lzscms'
        ];
        $data['manageSpecialDelete'] = [
            'name' => lzs_lang('lzscms::public.delete'),
            'remark' => 'special delete',
            'ename' => 'manageSpecialDelete',
            'uri' => 'special/delete/{id}',
            'parent' => 'manageSpecialIndex',
            'module' => 'Lzscms'
        ];
        $data['manageAreaIndex'] = [
            'name' => lzs_lang('lzscms::manage.area.manage'),
            'remark' => 'area',
            'ename' => 'manageAreaIndex',
            'uri' => 'area',
            'parent' => 'manageAreaIndex',
            'module' => 'Lzscms'
        ];
        $data['manageAreaAdd'] = [
            'name' => lzs_lang('lzscms::public.add'),
            'remark' => 'area add',
            'ename' => 'manageAreaAdd',
            'uri' => 'area/add',
            'parent' => 'manageAreaIndex',
            'module' => 'Lzscms'
        ];
        $data['manageAreaAddSave'] = [
            'name' => lzs_lang('lzscms::public.add','Lzscms::public.save'),
            'remark' => 'area add save',
            'ename' => 'manageAreaAddSave',
            'uri' => 'area/add/save',
            'parent' => 'manageAreaIndex',
            'module' => 'Lzscms'
        ];
        $data['manageAreaEdit'] = [
            'name' => lzs_lang('lzscms::public.edit'),
            'remark' => 'area edit',
            'ename' => 'manageAreaEdit',
            'uri' => 'area/edit/{areaid}',
            'parent' => 'manageAreaIndex',
            'module' => 'Lzscms'
        ];
        $data['manageAreaEditSave'] = [
            'name' => lzs_lang('lzscms::public.edit','Lzscms::public.save'),
            'remark' => 'area edit save',
            'ename' => 'manageAreaEditSave',
            'uri' => 'area/edit/save',
            'parent' => 'manageAreaIndex',
            'module' => 'Lzscms'
        ];
        $data['manageSpecialDelete'] = [
            'name' => lzs_lang('lzscms::public.delete'),
            'remark' => 'area delete',
            'ename' => 'manageAreaDelete',
            'uri' => 'area/delete/{areaid}',
            'parent' => 'manageAreaIndex',
            'module' => 'Lzscms'
        ];
        return $data;
    }

    public function getManageHomeSystemInfo($html) 
    {
        $view = [
            'system_info'=>php_uname(),
            'http_host'=>$_SERVER['HTTP_HOST'],
            'server_port'=>$_SERVER['SERVER_PORT'],
            'sysos'=>$_SERVER["SERVER_SOFTWARE"],
            'sockets'=>extension_loaded('sockets'),
            'openssl'=>extension_loaded('openssl'),
            'curls'=>extension_loaded('curl'),
            'pdo'=>extension_loaded('pdo'),
            'upload_max_filesize'=>ini_get('upload_max_filesize'),
            'gd_info'=>gd_info(),
            'public_dir'=>Lzs_check_write_able(public_path().'/')
        ];
        echo view('Lzscms::manage.system_info', $view);
    }
}