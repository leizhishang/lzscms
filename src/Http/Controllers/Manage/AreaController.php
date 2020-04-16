<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Leizhishang\Lzscms\Model\CommonAreaModel;

use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;

class AreaController extends BasicController
{
    public $module = 'site';
    public $relatedid = 0;

    public function __construct(Request $request)
    {
        parent::__construct();
        $module = $request->get('module');
        if($module) {
            $this->module = $module;
        }
        $this->navs = [
            'index'=>['name'=>lzs_lang('lzscms::manage.area.manage'), 'url'=>route('manageAreaIndex')],
            'update'=>['name'=>lzs_lang('lzscms::manage.area.update'), 'url'=>route('manageAreaIndex', ['isupdate'=>1,'areaid'=>$request->get('areaid')])],
            'cache'=>['name'=>lzs_lang('lzscms::public.update.cache'), 'class'=>'J_ajax_refresh', 'url'=>route('manageAreaCache')]
        ];
        $this->viewData['module'] = $this->module;
    }

    public function index(Request $request)
    {
        $areaid = (int)$request->get('areaid');
        $areaInfo = [];
        if($areaid) {
            $areaInfo = CommonAreaModel::getInfoByAreaid($areaid);
            if($areaInfo) {
                foreach ($areaInfo['joinids'] as $key => $value) {
                    $this->navs['index'.$value] = ['name'=>$areaInfo['joinnames'][$key], 'url'=>route('manageAreaIndex', ['areaid'=>$value])];
                }
            }
        }
        $this->navs['add'] = ['name'=>lzs_lang('lzscms::public.add'), 'url'=>route('manageAreaAdd', ['areaid'=>$areaid]), 'class'=>'J_dialog', 'title'=>lzs_lang('lzscms::public.add')];
        $list = CommonAreaModel::getSubByAreaid($areaid);
        if($request->get('isupdate')) {
            $pinfo = CommonAreaModel::getInfoByAreaid($areaid);
            foreach ($list as $key => $value) {
                CommonAreaModel::where('areaid', $value['areaid'])->update([
                    'joinname'=>trim(isset($pinfo['joinname']) ? $pinfo['joinname'] . '|' . $value['name'] : $value['name'] , '|'),
                    'initials'=>lzs_word2pinyin($value['name'], false, true, false, true)
                ]);
            }
            return $this->showMessage('lzscms::manage.area.update.success', 5);
        }
        $view = [
            'list'=>$list,
            'navs'=>$this->getNavs('index'.($areaid ? $areaid : ''))
        ];
	return $this->loadTemplate('lzscms::manage.area.index', $view);
    }

    public function add(Request $request)
    {
        $view = [
            'areaid'=>$request->get('areaid')
        ];
        return $this->loadTemplate('lzscms::manage.area.add', $view);
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'areaid' => 'required',
            'name' => 'required'
        ],[
            'areaid.required'=>lzs_lang('lzscms::manage.area.areaid.empty'),
            'name.required'=>lzs_lang('lzscms::manage.area.name.empty')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $parentid = $request->get('parentid');
        $areaid = $request->get('areaid');
        $info = CommonAreaModel::getInfoByAreaid($areaid);
        if($info) {
            return $this->showError('lzscms::manage.area.areaid.one');
        }
        $pinfo = CommonAreaModel::getInfoByAreaid($parentid);
        $psotData = [
            'name'=>$request->get('name'),
            'areaid'=>$request->get('areaid'),
            'parentid'=>$request->get('parentid'),
            'zip'=>(int)$request->get('zip'),
            'vieworder'=>0,
            'joinname'=>isset($pinfo['joinname']) ? trim($pinfo['joinname'] . '|' . $request->get('name'), '|') : $request->get('name'),
            'initials'=>lzs_word2pinyin($request->get('name'), false, true, false, true)
        ];
        CommonAreaModel::updateData($areaid, $psotData);
        CommonAreaModel::setCacheInfo($areaid);
        CommonAreaModel::setCacheSubByAreaid(0);
        CommonAreaModel::setCacheSubByAreaid($areaid);
        CommonAreaModel::setCacheCityAll();
        $this->addOperationLog(lzs_lang('lzscms::manage.area.add').':'.trim($request->get('name')), '', $psotData, []);
        return $this->showMessage('lzscms::public.add.success'); 
    }

    public function edit($areaid, Request $request)
    {
        if(!$areaid) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = CommonAreaModel::where('areaid', $areaid)->first();
        if(!$info) {
            return $this->showError('lzscms::public.no.data');
        }
        $view = [
            'areaid'=> $areaid,
            'info'=> $info,
        ];
        return $this->loadTemplate('lzscms::manage.area.edit', $view);
    }

    public function editSave(Request $request)
    {
        $areaid = $request->get('areaid');
        if(!$areaid) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = CommonAreaModel::getInfo($areaid);
        if(!$info) {
            return $this->showError('lzscms::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ],[
            'name.required'=>lzs_lang('lzscms::manage.area.name.empty')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $pinfo = CommonAreaModel::getInfoByAreaid($info['parentid']);
        $psotData = [
            'name'=>$request->get('name'),
            'zip'=>(int)$request->get('zip'),
            'joinname'=>trim(isset($pinfo['joinname']) ? $pinfo['joinname'] . '|' . $request->get('name') : $request->get('name') , '|'),
            'initials'=>lzs_word2pinyin($request->get('name'), false, true, false, true)
        ];
        CommonAreaModel::where('areaid', $areaid)->update($psotData);
        CommonAreaModel::setCacheInfo($areaid);
        CommonAreaModel::setCacheSubByAreaid(0);
        CommonAreaModel::setCacheSubByAreaid($areaid);
        CommonAreaModel::setCacheCityAll();
        $this->addOperationLog(lzs_lang('lzscms::manage.area.edit').':'.$areaid, '', $psotData, $info);
        return $this->showMessage('lzscms::public.edit.success'); 
    }

    public function delete($areaid, Request $request)
    {
        if(!$areaid) {
            return $this->showError('lzscms::public.no.id', 5);
        }
        $info = CommonAreaModel::getInfoByAreaid($areaid, true);
        if(!$info) {
            return $this->showError('lzscms::public.no.data', 5);
        }
        if($info['sublist']) {
            return $this->showError('lzscms::manage.area.delete.001', 5);
        }
        unset($info['sublist']);
        CommonAreaModel::where('areaid', $areaid)->delete();
        CommonAreaModel::setCacheInfo($areaid);
        CommonAreaModel::setCacheSubByAreaid(0);
        CommonAreaModel::setCacheSubByAreaid($areaid);
        CommonAreaModel::setCacheCityAll();
        $this->addOperationLog(lzs_lang('lzscms::manage.area.delete').':'.$info['name'], '', [], $info);
        return $this->showMessage('lzscms::public.delete.success', 5); 
    }

    public function cache(Request $request)
    {
        CommonAreaModel::setCacheSubByAreaid(0, true);
        CommonAreaModel::setCacheCityAll();
        return $this->showMessage('lzscms::public.successful', 5); 
    }
}

