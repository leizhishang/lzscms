<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Leizhishang\Lzscms\Model\AttachmentModel;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class AttachmentController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
        $this->navs = [
            'index'=>['name'=>lzs_lang('lzscms::manage.attach.setting'),'url'=>'manageAttach'],
            'manage'=>['name'=>lzs_lang('lzscms::manage.attach.service'),'url'=>'manageAttachManage'],
        ];
        $this->paginate = 50;
    }

    public function index(Request $request)
    {
    	$config = lzs_config('attachment');
        if(!isset($config['storage']) || !$config['storage']) {
            $config['storage'] = 'public';
        }
        $storages = AttachmentModel::getStorages();
        $this->viewData['navs'] = $this->getNavs('index');
        !($post_max_size = ini_get('post_max_size')) && $post_max_size = '2M';
        !($upload_max_filesize = ini_get('upload_max_filesize')) && $upload_max_filesize = '2M';
        $maxSize = min($post_max_size, $upload_max_filesize);
    	return $this->loadTemplate('attachment.index', [
            'config'=>$config, 
            'storages'=>$storages,
            'maxSize'=>$maxSize
        ]);
    }

    public function save(Request $request)
    {
        $arrRequest = $request->all();
        $_extsize = array();
        if(isset($arrRequest['extsize']) && $arrRequest['extsize']) {
            foreach ($arrRequest['extsize'] as $key => $value) 
            {
                if (!empty($value['ext'])) $_extsize[$value['ext']] = abs(intval($value['size']));
            }
        }
        $arrRequest['storage'] = $arrRequest['storage'] ? $arrRequest['storage'] : 'public';
        $arrRequest['dirs'] = $arrRequest['dirs'] ? $arrRequest['dirs'] : 'ymd';
        $data =[
            ['name'=>'extsize', 'value'=>$_extsize, 'issystem'=>1],
            ['name'=>'storage', 'value'=>$arrRequest['storage'] ? trim($arrRequest['storage']) : 'public'],
            ['name'=>'dirs', 'value'=>trim($arrRequest['dirs'])]
        ];
        $configData = [
            'FILESYSTEM_DEFAULT' => $arrRequest['storage']
        ];

        $oldConfig = lzs_config('attachment');
        lzs_save_config('attachment', $data);
        lzs_updateEnvInfo($configData);
        $this->addOperationLog(lzs_lang('lzscms::manage.attach.setting'),'', lzs_config('attachment'), $oldConfig);
        return $this->showMessage('lzscms::public.save.success');
    }

    public function manage(Request $request)
    {
        $type = (int)$request->get('type');
        $app = (string)$request->get('app');
        $name = (string)$request->get('name');
        $appid = (int)$request->get('appid');
        $aid = (int)$request->get('aid');
        $uid = (int)$request->get('uid');
        $listQuery = AttachmentModel::where('aid', '>', 0);
        $args = [
            'type'=>$type
        ];
        if($app) {
            $args['app'] = $app;
            $listQuery->where('app', $app);
        }
        if($appid) {
            $args['appid'] = $appid;
            $listQuery->where('appid', $appid);
        }
        if($aid) {
            $args['aid'] = $aid;
            $listQuery->where('aid', $aid);
        }
        if($uid) {
            $args['uid'] = $uid;
            $listQuery->where('created_userid', $uid);
        }
        if($name) {
            $args['name'] = $name;
            $listQuery->where('name', 'like', '%'.$name.'%');
        }
        $list = $listQuery->orderby('created_time', 'desc')->paginate($this->paginate);
        $this->navs['manage'] = ['name'=>lzs_lang('lzscms::manage.attach.service'),'url'=>route('manageAttachManage', $args)];
        if(count($list)) {
            foreach ($list as $key => $value) {
                $list[$key]['url'] = lzs_storage_url($value['path'], $value['disk']);
            }
        }
        $view = [
            'list'=>$list,
            'type'=>$type,
            'args'=>$args,
            'navs'=>$this->getNavs('manage')
        ];
        return $this->loadTemplate('lzscms::manage.attachment.manage', $view);
    }

    public function view($aid, Request $request)
    {
        if(!$aid) {
            return $this->showError('lzscms::public.no.id');
        }
        $info = AttachmentModel::getAttach($aid);
        if(!$info) {
            return $this->showError('lzscms::public.no.data');
        }
        $view = [
            'aid'=>$aid,
            'info'=>$info,
        ];
        return $this->loadTemplate('lzscms::manage.attachment.view', $view);
    }

}
