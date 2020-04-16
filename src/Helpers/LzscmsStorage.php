<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Leizhishang\Lzscms\Libraries\LzscmsStorage;
use Leizhishang\Lzscms\Model\AttachmentModel;
use Illuminate\Support\Facades\Storage;
use Gregwar\Image\Image;

if ( ! function_exists('lzs_storage_url'))
{    
    function lzs_storage_url($v = '', $disk = '')
    {
    	if(is_numeric($v)) {
    		$attachInfo = AttachmentModel::getAttach($v);
    		if(!$attachInfo) {
    			return '';
    		}
    		return storage::disk($attachInfo['disk'])->url($attachInfo['path']);
    	} else {
    		if(!$disk) {
    			$disk = lzs_config('attachment', 'storage');
    		}
    		return storage::disk($disk)->url($v);
    	}
    }
}

if ( ! function_exists('lzs_storage_delete'))
{    
    function lzs_storage_delete($v = '', $disk = '')
    {
    	if(is_numeric($v)) {
    		return AttachmentModel::deleteAttach($v);
    	} else {
            $lzscmsStorage = new LzscmsStorage();
    		if($disk) {
            	$lzscmsStorage->disk = $disk;
    		}
    		return $lzscmsStorage->delete($v);
    	}
    }
}

if ( ! function_exists('lzs_storage_download'))
{    
    function lzs_storage_download($v = '', $disk = '')
    {
        $lzscmsStorage = new LzscmsStorage();
        if(is_numeric($v)) {
            $lzscmsStorage->aid = $v;
        } else {
            if($disk) {
                $lzscmsStorage->disk = $disk;
            }
        }
        $result = $lzscmsStorage->download();
        if(lzs_message_verify($result)) {
            return $result;
        }
        return $result;
    }
}


if ( ! function_exists('lzs_image_resize'))
{    
    function lzs_image_resize($v = '', $option = [], $disk = '')
    {
        $type = isset($option['type']) && $option['type'] ? $option['type'] : '';
        $width = isset($option['width']) && $option['width'] ? (int)$option['width'] : 0;
        $height = isset($option['height']) && $option['height'] ? (int)$option['height'] : 0;
        $background = isset($option['background']) && $option['background'] ? $option['background'] : 'transparent';
        $xPos = isset($option['xPos']) && $option['xPos'] ? (int)$option['xPos'] : 0;
        $yPos = isset($option['yPos']) && $option['yPos'] ? (int)$option['yPos'] : 0;
        if(is_numeric($v)) {
            $attachInfo = AttachmentModel::where('aid', $v)->first();
            if(!$attachInfo) {
                return '';
            }
            $url = storage::disk($attachInfo['disk'])->url($attachInfo['path']);
        } else {
            if(!$disk) {
                $disk = lzs_config('attachment', 'storage');
            }
            $url = storage::disk($disk)->url($v);
        }
        if(!$width || !$height) {
            return $url;
        }
        $image = Image::open($url);
        switch ($type) {
            case 'scale':
                $image->scaleResize($width, $height, $background);
                break;
            case 'force':
                $image->forceResize($width, $height, $background);
                break;
            case 'crop':
                $image->cropResize($width, $height, $background);
                break;
            case 'zoom':
                $image->zoomResize($width, $height, $background, $xPos, $yPos);
                break;
            default:  //resize
                $image->resize($width, $height, $background);
                break;
        }
        if($background === 'transparent') {
            // $image->negate();
        }
        $url = $image->guess(100);
        return url($url);
    }
}

