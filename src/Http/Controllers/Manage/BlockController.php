<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Leizhishang\Lzscms\Model\CommonBlockModel;
use Leizhishang\Lzscms\Model\AttachmentModel;

use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;

class BlockController extends BasicController
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
            'index'=>['name'=>lzs_lang('lzscms::manage.block'), 'url'=>route('manageBlockIndex', ['module'=>$this->module])],
            'add'=>['name'=>lzs_lang('lzscms::public.add'), 'url'=>route('manageBlockAdd', ['module'=>$this->module]), 'class'=>'J_dialog', 'title'=>lzs_lang('lzscms::manage.special.add')],
            'cache'=>['name'=>lzs_lang('lzscms::public.update.cache'), 'class'=>'J_ajax_refresh', 'url'=>route('manageSpecialCache', ['module'=>$this->module])]
        ];
        $this->viewData['module'] = $this->module;
    }

    public function index(Request $request)
    {
        $listQuery = CommonBlockModel::where('id', '>', 0);
        $args = [];
        $list = $listQuery->orderby('times', 'desc')->paginate($this->paginate);
        $view = [
            'list'=>$list,
            'args'=>$args,
            'navs'=>$this->getNavs('index')
        ];
    	return $this->loadTemplate('lzscms::manage.block.index', $view);
    }

    public function add(Request $request)
    {
        return $this->loadTemplate('lzscms::manage.block.add', [
        ]);
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required'
        ],[
            'name.required'=>lzs_lang('lzscms::manage.block.name.empty'),
            'type.required'=>lzs_lang('lzscms::manage.type.empty')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $content = $request->get('content');
        $type = $request->get('type');
        $image = $request->get('image');
        $link = $request->get('link');
        $contents = [
            'image'=>$image ? $image['aid'] : 0,
            'link'=>$link
        ];
        if($type == 'image') {
            $content = serialize($contents);
        }
        if($type == 'html') {
            $content = $request->get('contentv');
        }
        $psotData = [
            'name'=>$request->get('name'),
            'type'=>$type,
            'content'=>$content,
            'isopen'=>(int)lzs_switch($request->all(), 'isopen'),
            'times'=>lzs_time()
        ];
        $id = CommonBlockModel::insertGetId($psotData);
        if(!$id) {
            return $this->showError('lzscms::public.error');
        }
        if($contents['image']) {
            AttachmentModel::updateAttach($contents['image'], $id);
        }
        CommonBlockModel::setCache($id);
        $this->addOperationLog(lzs_lang('lzscms::public.add','lzscms::public.block').':'.trim($request->get('name')), '', $psotData, []);
        return $this->showMessage('lzscms::public.add.success'); 
    }

    public function edit($id, Request $request)
    {
        if(!$id) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = CommonBlockModel::getInfo($id);
        if(!$info) {
            return $this->showError('lzscms::public.no.data');
        }
        $view = [
            'id'=> $id,
            'info'=> $info,
        ];
        return $this->loadTemplate('lzscms::manage.block.edit', $view);
    }

    public function editSave(Request $request)
    {
        $id = $request->get('id');
        if(!$id) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = CommonBlockModel::getInfo($id);
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
        $content = $request->get('content');
        $type = $request->get('type');
        $image = $request->get('image');
        $link = $request->get('link');
        $contents = [
            'image'=>isset($image['aid']) && $image['aid'] ? $image['aid'] : 0,
            'link'=>$link
        ];
        if($type == 'image') {
            $content = serialize($contents);
        }
        if($type == 'html') {
            $content = $request->get('contentv');
        }
        $psotData = [
            'name'=>$request->get('name'),
            'type'=>$type,
            'content'=>$content,
            'isopen'=>(int)lzs_switch($request->all(), 'isopen'),
            'times'=>lzs_time()
        ];
        CommonBlockModel::where('id', $id)->update($psotData);
        if($contents['image']) {
            AttachmentModel::updateAttach($contents['image'], $id);
        }
        CommonBlockModel::setCache($id);
        $this->addOperationLog(lzs_lang('lzscms::manage.edit').':'.$id, '', $psotData, $info);
        return $this->showMessage('lzscms::public.edit.success'); 
    }

    public function delete($id, Request $request)
    {
        if(!$id) {
            return $this->showError('lzscms::public.no.id', 5);
        }
        $info = CommonBlockModel::getCache($id);
        if(!$info) {
            return $this->showError('lzscms::public.no.data', 5);
        }
        CommonBlockModel::deleteBlock($id);
        AttachmentModel::deleteAttachByAppId('block', $info['id']);
        $this->addOperationLog(lzs_lang('lzscms::public.delete').':'.$id, '', [], $info);
        return $this->showMessage('lzscms::public.delete.success', 5); 
    }

    public function cache() 
    {
        CommonBlockModel::setCache(0);
        $this->addOperationLog(lzs_lang('lzscms::public.cache'));
        return $this->showMessage('lzscms::public.successful', 5); 
    }

}

