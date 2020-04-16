<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Leizhishang\Lzscms\Model\CommonSpecialModel;

use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;

class SpecialController extends BasicController
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
            'index'=>['name'=>lzs_lang('lzscms::manage.special.manage'), 'url'=>route('manageSpecialIndex', ['module'=>$this->module])],
            'add'=>['name'=>lzs_lang('lzscms::manage.special.add'), 'url'=>route('manageSpecialAdd', ['module'=>$this->module]), 'class'=>'J_dialog', 'title'=>lzs_lang('lzscms::manage.special.add')],
            'cache'=>['name'=>lzs_lang('lzscms::public.update.cache'), 'class'=>'J_ajax_refresh', 'url'=>route('manageSpecialCache', ['module'=>$this->module])]
        ];
        $this->viewData['module'] = $this->module;
    }

    public function index(Request $request)
    {
        $data = CommonSpecialModel::getData($this->module, 'lists');
        $view = [
            'list'=>$data,
            'navs'=>$this->getNavs('index')
        ];
    	return $this->loadTemplate('lzscms::manage.special.index', $view);
    }

    public function add(Request $request)
    {
        $view = [
        ];
        return $this->loadTemplate('lzscms::manage.special.add', $view);
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'dir' => 'required'
        ],[
            'name.required'=>lzs_lang('lzscms::manage.special.name.empty'),
            'dir.required'=>lzs_lang('lzscms::manage.special.dir.empty')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $dirinfo = CommonSpecialModel::hasSpecial($request->get('dir'), $this->module);
        if($dirinfo) {
            return $this->showError('lzscms::manage.special.dir.one');
        }
        $psotData = [
            'name'=>$request->get('name'),
            'title'=>$request->get('title'),
            'module'=>$this->module,
            'keywords'=>$request->get('keywords'),
            'description'=>$request->get('description'),
            'domain'=>$request->get('domain'),
            'style'=>$request->get('style'),
            'dir'=>$request->get('dir'),
            'content'=>(string)$request->get('content'),
            'isopen'=>(int)lzs_switch($request->all(), 'isopen'),
            'header'=>(int)lzs_switch($request->all(), 'header'),
            'footer'=>(int)lzs_switch($request->all(), 'footer'),
        ];
        $id = CommonSpecialModel::insertGetId($psotData);
        if(!$id) {
            return $this->showError('lzscms::public.error');
        }
        CommonSpecialModel::setCache($this->module);
        CommonSpecialModel::setCache('all');
        CommonSpecialModel::addInfo($id, $psotData);
        $this->addOperationLog(lzs_lang('lzscms::manage.special.add').':'.trim($request->get('name')), '', $psotData, []);
        return $this->showMessage('lzscms::public.add.success'); 
    }

    public function edit($id, Request $request)
    {
        if(!$id) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = CommonSpecialModel::getInfo($id, $this->module);
        if(!$info) {
            return $this->showError('lzscms::public.no.data');
        }
        $view = [
            'id'=> $id,
            'info'=> $info,
        ];
        return $this->loadTemplate('lzscms::manage.special.edit', $view);
    }

    public function editSave(Request $request)
    {
        $id = $request->get('id');
        if(!$id) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = CommonSpecialModel::getInfo($id, $this->module);
        if(!$info) {
            return $this->showError('lzscms::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ],[
            'name.required'=>lzs_lang('lzscms::manage.special.name.empty')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $dirinfo = CommonSpecialModel::hasSpecial($request->get('dir'), $this->module, $id);
        if($dirinfo) {
            return $this->showError('lzscms::manage.special.dir.one');
        }
        $psotData = [
            'name'=>$request->get('name'),
            'title'=>$request->get('title'),
            'keywords'=>$request->get('keywords'),
            'description'=>$request->get('description'),
            'style'=>$request->get('style'),
            'domain'=>$request->get('domain'),
            'dir'=>$request->get('dir'),
            'content'=>(string)$request->get('content'),
            'isopen'=>(int)lzs_switch($request->all(), 'isopen'),
            'header'=>(int)lzs_switch($request->all(), 'header'),
            'footer'=>(int)lzs_switch($request->all(), 'footer'),
        ];
        CommonSpecialModel::where('id', $id)->update($psotData);
        CommonSpecialModel::setCache($this->module);
        CommonSpecialModel::setCache('all');
        $this->updateSeo($id, $psotData['title'], $psotData['keywords'], $psotData['description']);
        $this->addOperationLog(lzs_lang('lzscms::manage.special.edit').':'.$id, '', $psotData, $info);
        return $this->showMessage('lzscms::public.edit.success'); 
    }

    public function delete($id)
    {

        if(!$id) {
            return $this->showError('lzscms::public.no.id', 5);
        }
        $info = CommonSpecialModel::getInfo($id, $this->module);
        if(!$info) {
            return $this->showError('lzscms::public.no.data', 5);
        }
        CommonSpecialModel::deleteSpecial($id);
        CommonSpecialModel::setCache($this->module);
        CommonSpecialModel::setCache('all');
        $this->addOperationLog(lzs_lang('lzscms::manage.special.delete').':'.$id, '', [], $info);
        return $this->showMessage('lzscms::public.delete.success', 5); 
    }

    public function cache() 
    {
        CommonSpecialModel::setCache($this->module);
        CommonSpecialModel::setCache('all');
        $this->addOperationLog(lzs_lang('lzscms::manage.special.cache'));
        return $this->showMessage('lzscms::public.successful', 5); 
    }

    public function updateSeo($param = 0, $title = '', $keywords = '', $description = '') 
    {
        if(config('websys.version')) {
            return websys_updateSeo('area', 'custom', $param, $title, $keywords, $description);
        } 
        return false;
    }
}

