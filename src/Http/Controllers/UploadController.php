<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers;

use Leizhishang\Lzscms\Http\Controllers\GlobalBasicController as BaseController;
use Leizhishang\Lzscms\Libraries\LzscmsUpload;
use Leizhishang\Lzscms\Libraries\LzscmsStorage;
use Leizhishang\Lzscms\Model\AttachmentModel;
use Illuminate\Http\Request;
use Auth;

/**
* 
*/
class UploadController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function save(Request $request)
    {
        $file = $request->file('filedata');
        $upapp = $request->get('upapp');
        $appid = $request->get('appid');
        $dir = $request->get('dir');
        $aid = (int)$request->get('aid');
        $name = (string)$request->get('name');
        $tempid = (string)$request->get('tempid');
        $islogin = (int)$request->get('islogin');
        $uid = (int)$request->get('uid');
        if($islogin) {
            $uid = Auth::id();
        }
        $lzscmsUpload = new LzscmsUpload();
        if($upapp) {
            $lzscmsUpload->app = $upapp;
        }
        if($appid) {
            $lzscmsUpload->appid = $appid;
        }
        if($uid) {
            $lzscmsUpload->uid = $uid;
        }
        if($tempid) {
            $lzscmsUpload->tempid = $tempid;
        }
        if($aid) {
            $attachInfo = AttachmentModel::getAttach($aid);
            if($attachInfo) {
                $name = basename($attachInfo['path'], ".".$attachInfo['type']);
            }
            $lzscmsUpload->aid = $aid;
        }
        $lzscmsUploads = $lzscmsUpload->setFile($file);
        if (lzs_message_verify($lzscmsUploads) ) return $this->showError($lzscmsUploads['message']);
        if($dir) {
            $lzscmsUploads->setDirs($dir);
        }
        if($name) {
            $lzscmsUploads->setFileName($name);
        }
        $lzscmsUploads->doSave();
        $data = $lzscmsUploads->getData();
        $this->viewData['data'] = $data;
        return $this->showMessage('success');
    }

    public function imageSave(Request $request)
    {
        $file = $request->file('filedata');
        $upapp = $request->get('upapp');
        $appid = $request->get('appid');
        $dir = $request->get('dir');
        $aid = (int)$request->get('aid');
        $name = (string)$request->get('name');
        $tempid = (string)$request->get('tempid');
        $islogin = (int)$request->get('islogin');
        $uid = (int)$request->get('uid');
        if($islogin) {
            $uid = Auth::id();
        }
        $lzscmsUpload = new LzscmsUpload();
        if($upapp) {
            $lzscmsUpload->app = $upapp;
        }
        if($appid) {
            $lzscmsUpload->appid = $appid;
        }
        if($uid) {
            $lzscmsUpload->uid = $uid;
        }
        if($tempid) {
            $lzscmsUpload->tempid = $tempid;
        }
        if($aid) {
            $attachInfo = AttachmentModel::getAttach($aid);
            if($attachInfo) {
                $name = basename($attachInfo['path'], ".".$attachInfo['type']);
            }
            $lzscmsUpload->aid = $aid;
        }
        $lzscmsUploads = $lzscmsUpload->setFile($file);
        if (lzs_message_verify($lzscmsUploads) ) return $this->showError($lzscmsUploads['message']);
        if($name) {
            $lzscmsUploads->setFileName($name);
        }
        if($dir) {
            $lzscmsUploads->setDirs($dir);
        }
        $lzscmsUploads->doSave();
        $data = $lzscmsUploads->getData();
        $this->viewData['data'] = $data;
        return $this->showMessage('success');
    }

    public function kindeditorImage(Request $request)
    {
        $file = $request->file('filedata');
        $upapp = $request->get('upapp');
        $appid = $request->get('appid');
        $dir = $request->get('dirs');
        $aid = (int)$request->get('aid');
        $name = (string)$request->get('name');
        $tempid = (string)$request->get('tempid');
        $islogin = (int)$request->get('islogin');
        $uid = (int)$request->get('uid');
        if($islogin) {
            $uid = Auth::id();
        }
        $lzscmsUpload = new LzscmsUpload();
        if($upapp) {
            $lzscmsUpload->app = $upapp;
        }
        if($appid) {
            $lzscmsUpload->appid = $appid;
        }
        if($uid) {
            $lzscmsUpload->uid = $uid;
        }
        if($tempid) {
            $lzscmsUpload->tempid = $tempid;
        }
        if($aid) {
            $attachInfo = AttachmentModel::getAttach($aid);
            if($attachInfo) {
                $name = basename($attachInfo['path'], ".".$attachInfo['type']);
            }
            $lzscmsUpload->aid = $aid;
        }
        $lzscmsUploads = $lzscmsUpload->setFile($file);
        if (Lzs_message_verify($lzscmsUploads) ) {
            return response()->json(['error'=>1, 'message'=>$lzscmsUploads['message']]);
        };
        if($name) {
            $lzscmsUploads->setFileName($name);
        }
        if($dir) {
            $lzscmsUploads->setDirs($dir);
        }
        $lzscmsUploads->doSave();
        $data = $lzscmsUploads->getData();
        return response()->json([
            'error'=>0,
            'url'=>$data['url']
        ]);
    }
}