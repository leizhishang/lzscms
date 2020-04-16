<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Leizhishang\Lzscms\Model\HookModel;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class HookController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
        $this->navs = [
            'index'=>['name'=>lzs_lang('lzscms::public.hook'), 'url'=>'manageHookIndex'],
            'add'=>['name'=>lzs_lang('lzscms::hook.add'), 'url'=>'manageHookAdd', 'class'=>'J_dialog', 'title'=>lzs_lang('lzscms::hook.add')],
            'cache'=>['name'=>lzs_lang('lzscms::public.update.cache'), 'url'=>'manageHookCache']
        ];
    }

    public function index(Request $request)
    {
        $list = HookModel::getAll(1);
        $view = [
            'list'=>$list,
            'navs'=>$this->getNavs('index')
        ];
    	return $this->loadTemplate('lzscms::manage.hook.index', $view);
    }

    public function add(Request $request)
    {
        return $this->loadTemplate('lzscms::manage.hook.add');
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'document' => 'required'
        ],[
            'name.required'=>lzs_lang('lzscms::public.name.empty'),
            'document.required'=>lzs_lang('lzscms::hook.document.empty')
        ]);

        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $hook = HookModel::where('name', trim($request->get('name')))->first();
        if($hook) {
            return $this->showError('lzscms::name.noone');
        }
        HookModel::addInfo(trim($request->get('name')), trim($request->get('description')), trim($request->get('document')));
        $this->addOperationLog(lzs_lang('lzscms::hook.add').':'.trim($request->get('name')), '', ['name'=>trim($request->get('name')), 'description'=>trim($request->get('description')), 'document'=>trim($request->get('document'))], array());
        return $this->showMessage('lzscms::public.add.success'); 
    }

    public function edit($name)
    {
        if(!$name) {
            return $this->showError('lzscms::public.no.id');
        }
        $hook = HookModel::where('name', $name)->first();
        if(!$hook) {
            return $this->showError('lzscms::public.no.data');
        }
        $view = [
            'name'=> $name,
            'info'=> $hook,
        ];
        return $this->loadTemplate('hook::manage.hook.edit', $view);
    }

    public function editSave(Request $request)
    {
        $name = $request->get('name');
        if(!$name) {
            return $this->showError('lzscms::public.no.id');
        }
        $hook = HookModel::where('name', $name)->first();
        if(!$hook) {
            return $this->showError('lzscms::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'document' => 'required'
        ],[
            'document.required'=>lzs_lang('lzscms::hook.document.empty')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }

        HookModel::editInfo(trim($request->get('name')), trim($request->get('description')), trim($request->get('document')));
        $this->addOperationLog(lzs_lang('lzscms::hook.edit').':'.$hook['name'], '', ['name'=>trim($request->get('name')), 'description'=>trim($request->get('description')), 'document'=>trim($request->get('document'))], $hook->toArray());
        return $this->showMessage('lzscms::public.edit.success'); 
    }

    public function delete($name)
    {
        if(!$name) {
            return $this->showError('lzscms::public.no.id');
        }
        $hook = HookModel::where('name', $name)->first();
        if(!$hook) {
            return $this->showError('lzscms::public.no.data');
        }
        HookModel::del(trim($name));
        $this->addOperationLog(lzs_lang('lzscms::hook.delete').':'.$name, '', array(), $hook->toArray());
        return $this->showMessage('lzscms::public.delete.success'); 
    }

    public function cache() {
        HookModel::setCache();
        $this->addOperationLog(lzs_lang('lzscms::hook.cache'));
        return $this->showMessage('lzscms::public.successful', 'manageHookIndex', 1); 
    }
}

