<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers;

use Leizhishang\Lzscms\Http\Controllers\GlobalBasicController as BaseController;

use Leizhishang\Lzscms\Model\CommonFormModel;
use Leizhishang\Lzscms\Model\CommonFieldsModel;
use Leizhishang\Lzscms\Libraries\LzscmsFields;
use Leizhishang\Lzscms\Libraries\LzscmsPinYin;
use Leizhishang\Lzscms\Model\CommonAreaModel;
use Illuminate\Http\Request;


class PublicController extends BaseController
{

    public function lzscmsClose(Request $request) 
    {
        $closeTmpl = lzs_config('site', 'vmtemplate') ? lzs_config('site', 'vmtemplate') : 'lzscms::common.close';
        $message = lzs_config('site', 'vmessage') ? lzs_config('site', 'vmessage') : lzs_lang('lzscms::public.site.close.tips');
        return view($closeTmpl, [
            'referer'=>'',
            'with'=>0,
            'message'=>$message
        ]);
    }

    public function fieldsTypeHtml(Request $request) 
    {
        $id = $request->get('id');
        $type = $request->get('type');
        $rname = $request->get('rname');
        $relatedid = $request->get('relatedid');
    	$fieldInfo = CommonFieldsModel::getField($id);
        if ($fieldInfo) {
            $option = isset($fieldInfo['setting']['option']) ? $fieldInfo['setting']['option'] : [];
        } else {
            $option = [];
        }
        $fields = [];
        if($rname == 'form') {
            $formInfo = CommonFormModel::getForm($relatedid);
            $fields = CommonFieldsModel::getFields($formInfo['table'], $formInfo['module']);
        }
        $lzscmsFields = new LzscmsFields();
        $return = $lzscmsFields->option($type, $option, $fields);
        if ($return !== 0) {
            return $return;
        }
        return '';
    }

    public function topinyin(Request $request) 
    {
        $str = $request->get('str', TRUE);
        if (!$str) {
            return '';
        }
        $lzscmsPinYin = new LzscmsPinYin();
        exit($lzscmsPinYin->result($str));
    }

    public function getAreaSubList(Request $request)
    {
        $areaid = $request->get('areaid');
        if(!$areaid) {
            echo json_encode([]);
            exit;
        }
        $list = CommonAreaModel::getSubByAreaid($areaid, false);
        echo json_encode($list);
        exit;
    } 

    public function viewpw(Request $request)
    {
        $viewpw = $request->get('viewpw');
        $password = $request->get('password');
        if(!$password) {
            return $this->showError('lzscms::public.viewpw.password.empty');
        }
        $result = lzs_decrypt($viewpw, $password);
        if(lzs_message_verify($result)) {
            return $this->showError($result['message']);
        }
        $this->addMessage($result, 'viewpw');
        return $this->showMessage('lzscms::public.successfull');
    }
}