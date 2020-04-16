<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Leizhishang\Lzscms\Model\CommonFormModel;
use Leizhishang\Lzscms\Libraries\LzscmsFields;
use Leizhishang\Lzscms\Model\CommonFieldsModel;
use Leizhishang\Lzscms\Model\CommonFormContentModel;

use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;

class FormController extends BasicController
{
    public $module = 'site';
    public $relatedid = 0;
    public function __construct(Request $request)
    {
        parent::__construct();
        $module = $request->get('module');
        $relatedid = (int)$request->get('relatedid');
        if($module) {
            $this->module = $module;
        }
        if($relatedid) {
            $this->relatedid = $relatedid;
        }
        $this->navs = [
            'index'=>['name'=>lzs_lang('lzscms::manage.form'), 'url'=>route('manageFormIndex', ['module'=>$this->module, 'relatedid'=>$this->relatedid])],
            'add'=>['name'=>lzs_lang('lzscms::manage.form.add'), 'url'=>route('manageFormAdd', ['module'=>$this->module, 'relatedid'=>$this->relatedid]), 'class'=>'J_dialog', 'title'=>lzs_lang('lzscms::hook.add')],
            'cache'=>['name'=>lzs_lang('lzscms::public.update.cache'), 'class'=>'J_ajax_refresh', 'url'=>route('manageFormCache', ['module'=>$this->module, 'relatedid'=>$this->relatedid])]
        ];
        $this->viewData['module'] = $this->module;
        $this->viewData['relatedid'] = $this->relatedid;
    }

    public function index(Request $request)
    {
        $data = CommonFormModel::getForms($this->module);
        $view = [
            'list'=>$data['list'],
            'navs'=>$this->getNavs('index')
        ];
    	return $this->loadTemplate('lzscms::manage.form.index', $view);
    }

    public function add(Request $request)
    {
        return $this->loadTemplate('lzscms::manage.form.add');
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'table' => 'required'
        ],[
            'name.required'=>lzs_lang('lzscms::manage.form.name.empty'),
            'table.required'=>lzs_lang('lzscms::manage.form.table.empty')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $form = CommonFormModel::hasFormOrTable('form_'.$request->get('table'), $this->module, $this->relatedid);
        if(!$form) {
            return $this->showError('lzscms::manage.form.one');
        }
        $setting = [
            'mobile'=>$request->get('mobile'),
            'email'=>$request->get('email'),
            'email_content'=>$request->get('emailcontent')
        ];
        $psotData = [
            'name'=>$request->get('name'),
            'table'=>'form_'.$request->get('table'),
            'module'=>$this->module,
            'relatedid'=>$this->relatedid,
            'setting'=>$setting
        ];
        CommonFormModel::addForm($psotData);
        CommonFormModel::setCache($this->module);
        CommonFormModel::setCache('all');
        $this->addOperationLog(lzs_lang('lzscms::manage.form.add').':'.trim($request->get('name')), '', $psotData, [], array());
        return $this->showMessage('lzscms::public.add.success'); 
    }

    public function edit($id, Request $request)
    {
        if(!$id) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = CommonFormModel::getForm($id);
        if(!$info) {
            return $this->showError('lzscms::public.no.data');
        }
        $view = [
            'id'=> $id,
            'info'=> $info,
        ];
        return $this->loadTemplate('lzscms::manage.form.edit', $view);
    }

    public function editSave(Request $request)
    {
        $id = $request->get('id');
        if(!$id) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = CommonFormModel::getForm($id);
        if(!$info) {
            return $this->showError('lzscms::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ],[
            'name.required'=>lzs_lang('lzscms::manage.form.name.empty')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $setting = [
            'mobile'=>$request->get('mobile'),
            'email'=>$request->get('email'),
            'email_content'=>$request->get('emailcontent')
        ];
        $psotData = [
            'name'=>$request->get('name'),
            'setting'=>lzs_array2str($setting)
        ];
        CommonFormModel::where('id', $id)->update($psotData);
        CommonFormModel::setCache($this->module);
        CommonFormModel::setCache('all');
        $this->addOperationLog(lzs_lang('lzscms::manage.form.edit').':'.$id, '', [
            'name'=>$request->get('name'),
            'mobile'=>$request->get('mobile'),
            'email'=>$request->get('email'),
            'email_content'=>$request->get('emailcontent')
        ], []);
        return $this->showMessage('lzscms::public.edit.success'); 
    }

    public function delete($id)
    {
        if(!$id) {
            return $this->showError('lzscms::public.no.id', 5);
        }
        $info = CommonFormModel::getForm($id);
        if(!$info) {
            return $this->showError('lzscms::public.no.data', 5);
        }
        CommonFormModel::deleteForm(trim($info['table']), $info['module'], $info['relatedid']);
        CommonFormModel::setCache($this->module);
        CommonFormModel::setCache('all');
        $this->addOperationLog(lzs_lang('lzscms::manage.form.delete').':'.$id, '', array(), $info);
        return $this->showMessage('lzscms::public.delete.success', 5); 
    }

    public function cache() 
    {
        CommonFormModel::setCache($this->module);
        CommonFormModel::setCache('all');
        $this->addOperationLog(lzs_lang('lzscms::manage.form.cache'));
        return $this->showMessage('lzscms::public.successful', 5); 
    }

    // 内容管理
    public function content($formid, Request $request) 
    {
        if(!$formid) {
            return $this->showError('lzscms::public.no.id', '', 5);
        }
        $info = CommonFormModel::getForm($formid);
        if(!$info) {
            return $this->showError('lzscms::public.no.data', '', 5);
        }
        $commonFormContentModel = new CommonFormContentModel();
        $commonFormContentModel->setTable($info['table']);
        $type = $request->input('type');
        $uid = $request->input('uid');
        $stime = $request->input('stime');
        $etime = $request->input('etime');
        $listQuery = $commonFormContentModel->where('id', '>', 0);
        $args = ['status'=>0, 'type'=>''];
        if($uid) {
            $args['uid'] = $uid;
            $listQuery->where('created_uid', $uid);
        }
        if($stime) {
            $args['stime'] = $stime;
            $stime = lzs_str2time($stime);
            $listQuery->where('created_time', '>=', $stime);
        }
        if($etime) {
            $args['etime'] = $etime;
            $etime = lzs_str2time($etime);
            $listQuery->where('created_time', '<=', $etime);
        }
        $list = $listQuery->orderby('created_time', 'desc')->paginate($this->paginate);
        $showFields = CommonFieldsModel::getManageContentListShowFields($info['table']);
        $fields = CommonFieldsModel::getFields($info['table'], true);
        $lzscmsFields = new LzscmsFields();
        foreach ($list as $key => $value) {
            $list[$key] = $lzscmsFields->field_format_value($fields, $value->toArray());
        }
        $this->navs = [];
        $this->navs['content'] = ['name'=>$info['name'].lzs_lang('lzscms::manage.form.content'), 'url'=>route('manageFormContent', ['formid'=>$formid])];
        $this->navs['contentAdd'] = ['name'=>$info['name'].lzs_lang('lzscms::public.add'), 'url'=>route('manageFormContentAdd', ['formid'=>$formid])];
        $view = [
            'formid'=> $formid,
            'info'=> $info,
            'list'=>$list,
            'args'=>$args,
            'showFields'=>$showFields,
            'navs'=>$this->getNavs('content')
        ];
        return $this->loadTemplate('lzscms::manage.form.content', $view);
    }

    public function contentAdd($formid, Request $request) 
    {
        if(!$formid) {
            return $this->showError('lzscms::public.no.id', '', 5);
        }
        $info = CommonFormModel::getForm($formid);
        if(!$info) {
            return $this->showError('lzscms::public.no.data', '', 5);
        }

        $LzscmsFields = new LzscmsFields();
        $LzscmsFields->isadmin = true;
        $fields = CommonFieldsModel::getFields($info['table']);
        $inputHtml = $LzscmsFields->input_html($fields);
        $this->navs = [];
        $this->navs['content'] = ['name'=>$info['name'].lzs_lang('lzscms::manage.form.content'), 'url'=>route('manageFormContent', ['formid'=>$formid])];
        $this->navs['contentAdd'] = ['name'=>$info['name'].lzs_lang('lzscms::public.add'), 'url'=>route('manageFormContentAdd', ['formid'=>$formid])];
        $view = [
            'id'=> $formid,
            'info'=> $info,
            'inputHtml'=>$inputHtml,
            'navs'=>$this->getNavs('contentAdd')
        ];
        return $this->loadTemplate('lzscms::manage.form.content_add', $view);
    }

    public function contentAddSave($formid, Request $request) 
    {
        if(!$formid) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = CommonFormModel::getForm($formid);
        if(!$info) {
            return $this->showError('lzscms::public.no.data');
        }
        $lzscmsFields = new LzscmsFields();
        $lzscmsFields->isadmin = true;
        $fields = CommonFieldsModel::getFields($info['table']);
        $result = $lzscmsFields->validate_filter($request, $fields);
        if($result['status'] == 'error') {
            return $this->showError($result['error'], 2);
        }
        $psotData = $result['data'][$info['table']];
        $psotData['created_time'] = lzs_time();
        $psotData['created_ip'] = lzs_ip();
        $psotData['created_port'] = lzs_port();
        $psotData['vieworder'] = 0;
        $commonFormContentModel = new CommonFormContentModel();
        $commonFormContentModel->setTable($info['table']);
        $id = $commonFormContentModel->insertGetId($psotData);
        if($id) {
            $lzscmsFields->saveAttach($id, $request, $fields);
        }
        return $this->showMessage('lzscms::public.add.success'); 
    }

    public function contentEdit($formid, $id, Request $request) 
    {
        if(!$formid || !$id) {
            return $this->showError('lzscms::public.no.id', '', 5);
        }
        $info = CommonFormModel::getForm($formid);
        if(!$info) {
            return $this->showError('lzscms::public.no.data', '', 5);
        }
        $commonFormContentModel = new CommonFormContentModel();
        $commonFormContentModel->setTable($info['table']);
        $infos = $commonFormContentModel->where('id', $id)->first();
        if(!$infos) {
            return $this->showError('lzscms::public.no.data', '', 5);
        }

        $LzscmsFields = new LzscmsFields();
        $LzscmsFields->isadmin = true;
        $fields = CommonFieldsModel::getFields($info['table']);
        $inputHtml = $LzscmsFields->input_html($fields, $infos, false, 'id');

        $this->navs = [];
        $this->navs['content'] = ['name'=>$info['name'].lzs_lang('lzscms::manage.form.content'), 'url'=>route('manageFormContent', ['formid'=>$formid])];
        $this->navs['contentAdd'] = ['name'=>$info['name'].lzs_lang('lzscms::public.add'), 'url'=>route('manageFormContentAdd', ['formid'=>$formid])];
        $this->navs['contentEdit'] = ['name'=>lzs_lang('lzscms::public.edit'), 'url'=>route('manageFormContentEdit', ['formid'=>$formid, 'id'=>$id])];
        $view = [
            'id'=> $id,
            'formid'=> $formid,
            'info'=> $info,
            'infos'=>$infos,
            'inputHtml'=>$inputHtml,
            'navs'=>$this->getNavs('contentEdit')
        ];
        return $this->loadTemplate('lzscms::manage.form.content_edit', $view);
    }

    public function contentEditSave($formid, Request $request) 
    {
        $id = $request->get('id');
        if(!$formid || !$id) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = CommonFormModel::getForm($formid);
        if(!$info) {
            return $this->showError('lzscms::public.no.data');
        }
        $commonFormContentModel = new CommonFormContentModel();
        $commonFormContentModel->setTable($info['table']);
        $fields = CommonFieldsModel::getFields($info['table']);
        $infos = $commonFormContentModel->where('id', $id)->first();
        if(!$infos) {
            return $this->showError('lzscms::public.no.data', '', 5);
        }

        $lzscmsFields = new LzscmsFields();
        $lzscmsFields->isadmin = true;
        $result = $lzscmsFields->validate_filter($request, $fields, $infos);
        if($result['status'] == 'error') {
            return $this->showError($result['error'], 2);
        }
        $psotData = $result['data'][$info['table']];
        $psotData['vieworder'] = 0;
        $commonFormContentModel->where('id', $id)->update($psotData);
        if($id) {
            $lzscmsFields->saveAttach($id, $request, $fields);
        }
        return $this->showMessage('lzscms::public.edit.success'); 
    }

    public function contentDelete($formid, $id, Request $request)
    {
        if(!$formid || !$id) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = CommonFormModel::getForm($formid);
        if(!$info) {
            return $this->showError('lzscms::public.no.data');
        }
        $commonFormContentModel = new CommonFormContentModel();
        $commonFormContentModel->setTable($info['table']);
        $commonFormContentModel->where('id', $id)->delete();
        return $this->showMessage('lzscms::public.delete.success', 5); 
    }

}

