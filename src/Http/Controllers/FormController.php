<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers;

use Leizhishang\Lzscms\Http\Controllers\GlobalBasicController as BaseController;
use Leizhishang\Lzscms\Model\CommonFormModel;
use Leizhishang\Lzscms\Libraries\LzscmsFields;
use Leizhishang\Lzscms\Model\CommonFieldsModel;
use Leizhishang\Lzscms\Model\CommonFormContentModel;

use Auth;
use Illuminate\Http\Request;


class FormController extends BaseController
{
    public function show($formid, Request $request)
    {
        if(!$formid) {
            return $this->showError('lzscms::public.no.id', '', 5);
        }
        $info = CommonFormModel::getForm($formid);
        if(!$info) {
            return $this->showError('lzscms::public.no.data', '', 5);
        }
        $lzscmsFields = new LzscmsFields();
        $fields = CommonFieldsModel::getFields($info['table']);
        $inputHtml = $lzscmsFields->input_html($fields);
        $view = [
            'formid'=> $formid,
            'info'=> $info,
            'inputHtml'=>$inputHtml
        ];
        return $this->loadTemplate('lzscms::form.show', $view);
    }

    public function save(Request $request) 
    {
        $formid = $request->get('formid');
        if(!$formid) {
            return $this->showError('lzscms::public.no.id', '', 5);
        }
        $info = CommonFormModel::getForm($formid);
        if(!$info) {
            return $this->showError('lzscms::public.no.data', '', 5);
        }
        $LzscmsFields = new LzscmsFields();
        $fields = CommonFieldsModel::getFields($info['table']);
        $result = $LzscmsFields->validate_filter($request, $fields);
        if($result['status'] == 'error') {
            return $this->showError($result['error'], 2);
        }
        $psotData = $result['data'][$info['table']];
        $psotData['created_uid'] = (int)Auth::id();
        $psotData['created_time'] = lzs_time();
        $psotData['created_ip'] = lzs_ip();
        $psotData['created_port'] = lzs_port();
        $psotData['vieworder'] = 0;
        $commonFormContentModel = new CommonFormContentModel();
        $commonFormContentModel->setTable($info['table']);
        $id = $commonFormContentModel->insertGetId($psotData);
        if($id) {
            $LzscmsFields->saveAttach($id, $request, $fields);
        }
        return $this->showMessage('lzscms::public.add.success'); 
    }
}