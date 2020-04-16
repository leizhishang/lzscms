<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Leizhishang\Lzscms\Model\CommonFormModel;
use Leizhishang\Lzscms\Model\CommonFieldsModel;

use Leizhishang\Lzscms\Libraries\LzscmsFields;


use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class FieldsController extends BasicController
{
    public $rname = 'form';
    public $relatedid = 0;
    public $lzscmsFields = null;
    public $formInfo = null;
    public $relatedtable = '';
    public $module = '';

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->rname = $request->get('rname');
        $this->relatedtable = $request->get('relatedtable');
        $this->relatedid = (int)$request->get('relatedid');
        $this->viewData['rname'] = $this->rname;
        $this->viewData['relatedid'] = $this->relatedid;
        $this->viewData['relatedtable'] = $this->relatedtable;
        $this->lzscmsFields = new LzscmsFields();
        if($this->rname == 'form') {
            $this->formInfo = CommonFormModel::getForm($this->relatedid);
            if($this->formInfo) {
                $this->relatedtable = $this->formInfo['table'];
                $this->module = $this->formInfo['module'];
            }
        } else {
            $this->module = $this->rname;
        }
        $this->navs = [
            'index'=>['name'=>lzs_lang('lzscms::manage.fields.manage'), 'url'=>route('manageFieldsIndex', [
                'rname' => $this->rname,
                'relatedid' => $this->relatedid,
                'relatedtable' => $this->relatedtable
            ])],
            'add'=>['name'=>lzs_lang('lzscms::manage.fields.add'), 'url'=>route('manageFieldsAdd', [
                'rname' => $this->rname,
                'relatedid' => $this->relatedid,
                'relatedtable' => $this->relatedtable
            ])]
        ];
    }

    public function index(Request $request)
    {
        if($this->rname == 'form') {
            if(!$this->formInfo) {
                    return $this->showError('lzscms::manage.form.no.info');
            }
            $fields = CommonFieldsModel::getFields($this->formInfo['table'], $this->formInfo['module']);
        } else {
            $fields = CommonFieldsModel::getFields($this->relatedtable, $this->module);
        }
        $view = [
            'list'=>$fields,
            'navs'=>$this->getNavs('index')
        ];
    	return $this->loadTemplate('lzscms::manage.fields.index', $view);
    }

    public function save(Request $request)
    {
        $vieworder = $request->get('vieworder');
        foreach ($vieworder as $id => $value) {
            CommonFieldsModel::where('id', $id)->update(['vieworder'=>$value]);
        }
        CommonFieldsModel::setCache($this->relatedtable);
        CommonFieldsModel::setCache('all');
        $this->addOperationLog(lzs_lang('lzscms::manage.fields.update.vieworder'), '', [], []);
        return $this->showMessage('lzscms::public.add.success', 5); 
    }

    public function add(Request $request)
    {
        $view = [
            'fieldTypes'=> $this->LzscmsFields->type(),
            'navs'=>$this->getNavs('add')
        ];
        return $this->loadTemplate('lzscms::manage.fields.add', $view);
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'fieldname' => 'required',
            'fieldtype' => 'required'
        ],[
            'name.required'=>lzs_lang('lzscms::manage.fields.name.empty'),
            'fieldname.required'=>lzs_lang('lzscms::manage.fields.fieldname.empty'),
            'fieldtype.required'=>lzs_lang('lzscms::manage.fields.type.empty')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $ismain = $request->get('ismain');
        if($this->rname == 'form') {
            if(!$this->formInfo) {
                return $this->showError('lzscms::manage.form.no.info');
            }
            $ismain = 1;
        }
        if(!CommonFieldsModel::hasFieldOrColumn([
            'relatedtable'=>$this->relatedtable,
            'module'=>$this->module,
            'fieldname'=>$request->get('fieldname')
        ])) {
            return $this->showError('lzscms::manage.fields.one');
        }
        if (!$this->relatedtable) {
            return $this->showError('lzscms::fields.relatedtable.error');
        }
        $setting = $request->get('setting');
        $setting['validate']['isedit'] = (int)lzs_switch($request->all(), 'isedit');
        $setting['option']['isfrontshow'] = (int)lzs_switch($request->all(), 'isfrontshow');
        $psotData = [
            'name'=>$request->get('name'),
            'fieldtype'=>$request->get('fieldtype'),
            'fieldname'=>$request->get('fieldname'),
            'vieworder'=>(int)$request->get('vieworder'),
            'ismshow'=>(int)lzs_switch($request->all(), 'ismshow'),
            'issearch'=>(int)lzs_switch($request->all(), 'issearch'),
            'disabled'=>(int)lzs_switch($request->all(), 'disabled', true),
            'ismain'=>$ismain,
            'relatedtable'=>$this->relatedtable,
            'module'=>$this->module,
            'relatedid'=>$this->relatedid,
            'setting'=>$setting
        ];
        CommonFieldsModel::addField($psotData);
        CommonFieldsModel::setCache('all');
        CommonFieldsModel::setCache($this->relatedtable);
        $this->addOperationLog(lzs_lang('lzscms::manage.fields.add').':'.trim($request->get('name')), '', $psotData, []);
        return $this->showMessage('lzscms::public.add.success', '', 5); 
    }

    public function edit($id)
    {
        if(!$id) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = CommonFieldsModel::getField($id);
        if(!$info) {
            return $this->showError('lzscms::public.no.data');
        }
        $this->navs['edit'] = ['name'=>lzs_lang('lzscms::manage.fields.edit'), 'url'=>route('manageFieldsEdit', [
                'id' => $id,
                'rname' => $this->rname,
                'relatedtable' => $this->relatedtable,
                'relatedid' => $this->relatedid
            ])];
        $view = [
            'id'=> $id,
            'info'=> $info,
            'fieldTypes'=> $this->lzscmsFields->type(),
            'navs'=>$this->getNavs('edit')
        ];
        return $this->loadTemplate('lzscms::manage.fields.edit', $view);
    }

    public function editSave(Request $request)
    {
        $id = $request->get('id');
        if(!$id) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = CommonFieldsModel::getField($id);
        if(!$info) {
            return $this->showError('lzscms::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ],[
            'name.required'=>lzs_lang('lzscms::manage.fields.name.empty')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        if($this->rname == 'form') {
            $formInfo = CommonFormModel::getForm($this->relatedid);
            if(!$formInfo) {
                return $this->showError('lzscms::manage.form.no.info');
            }
        }
        $setting = $request->get('setting');
        $setting['validate']['isedit'] = (int)lzs_switch($request->all(), 'isedit');
        $setting['option']['isfrontshow'] = (int)lzs_switch($request->all(), 'isfrontshow');
        $psotData = [
            'name'=>$request->get('name'),
            'vieworder'=>(int)$request->get('vieworder'),
            'ismshow'=>(int)lzs_switch($request->all(), 'ismshow'),
            'issearch'=>(int)lzs_switch($request->all(), 'issearch'),
            'disabled'=>(int)lzs_switch($request->all(), 'disabled', true),
            'setting'=>lzs_array2str($setting)
        ];
        CommonFieldsModel::where('id', $id)->update($psotData);
        CommonFieldsModel::setCache('all');
        CommonFieldsModel::setCache($this->relatedtable);
        $this->addOperationLog(lzs_lang('lzscms::manage.fields.edit').':'.$id, '', [
            'name'=>$request->get('name'),
            'vieworder'=>$request->get('vieworder'),
            'ismshow'=>(int)lzs_switch($request->all(), 'ismshow'),
            'issearch'=>(int)lzs_switch($request->all(), 'issearch'),
            'disabled'=>(int)lzs_switch($request->all(), 'disabled', true)
        ], []);
        return $this->showMessage('lzscms::public.edit.success'); 
    }

    public function delete($id)
    {
        if(!$id) {
            return $this->showError('lzscms::public.no.id', 5);
        }
        $info = CommonFieldsModel::getField($id);
        if(!$info) {
            return $this->showError('lzscms::public.no.data', 5);
        }
        CommonFieldsModel::deleteField($id);
        CommonFieldsModel::setCache('all');
        CommonFieldsModel::setCache($info['relatedtable']);
        $this->addOperationLog(lzs_lang('lzscms::manage.fields.delete').':'.$id, '', [], $info);
        return $this->showMessage('lzscms::public.delete.success', 5); 
    }

    public function cache() 
    {
        CommonFieldsModel::setCache('all');
        $this->addOperationLog(lzs_lang('lzscms::manage.fields.cache'));
        return $this->showMessage('lzscms::public.successful', 5); 
    }
}

