<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers;

use Leizhishang\Lzscms\Http\Controllers\GlobalBasicController as BaseController;
use Leizhishang\Lzscms\Model\AttachmentModel;
use Gregwar\Image\Image;
use Illuminate\Http\Request;
/**
* 
*/
class ImageController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function view($aid, Request $request)
    {
        if(!$aid) exit();
        if(!ini_get('safe_mode')) {
            ignore_user_abort(true);
            set_time_limit(0);
        }
        $attachInfo = AttachmentModel::getAttach($aid);
        if(!$attachInfo) {
            exit();
        }
        header("Cache-control: max-age=600");
        header('Location: ' . $attachInfo['url']);
        exit;
    }

    public function resize($aid, $type = '', $width = 0, $height = 0, Request $request)
    {
        if(!$aid) exit();
        if(!ini_get('safe_mode')) {
            ignore_user_abort(true);
            set_time_limit(0);
        }
        if(!$width || !$height) {
            $attachInfo = AttachmentModel::getAttach($aid);
            if(!$attachInfo) {
                exit();
            }
            header("Cache-control: max-age=600");
            header('Location: ' . $attachInfo['url']);
            exit;
        }
        $url = lzs_image_resize($aid, [
            'type'=>$type,
            'width'=>$width,
            'height'=>$height
        ]);
        header("Cache-control: max-age=600");
        header('Location: ' . $url);
        exit;
    }
}