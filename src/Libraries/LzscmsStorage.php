<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries;

use Leizhishang\Lzscms\Model\AttachmentModel;

use Illuminate\Support\Facades\Storage;
use League\Flysystem\Util\MimeType;
use Illuminate\Support\Facades\DB;

class LzscmsStorage
{

	public $aid = 0;
	public $file = '';
	public $name = '';
	public $headers = [];

    public $disks = 'public';

	public function __construct() 
    {
		self::setStorage();
	}

    public function setStorage($disks = '')
    {
        if($disks) {
        	$this->disks = $disks;
            return $this;
        }
        $this->disks = lzs_config('attachment', 'storage');
        return $this;
    }

    public function download() 
    {
    	if($this->aid) {
    		$attachInfo = AttachmentModel::where('aid', $this->aid)->first();
    		if(!$attachInfo) {
    			return lzs_message('lzscms::public.download.file.error.001');
    		}
    		$name = $this->name ? $this->name : $attachInfo['name'];
    		$disk = $attachInfo['disk'] ? $attachInfo['disk'] : $this->disks;
    		if(!Storage::disk($disk)->exists($attachInfo['path'])) {
    			return lzs_message('lzscms::public.download.file.error.001');
    		}
    		return Storage::disk($disk)->download($attachInfo['path'], '中国.txt', $this->headers);
    	} else {
    		if(!$this->file) {
    			return lzs_message('lzscms::public.download.file.error.001');
    		}
    		if(!Storage::disk($this->disks)->exists($this->file)) {
    			return lzs_message('lzscms::public.download.file.error.001');
    		}
    		return Storage::disk($disk)->download($this->file, $this->name, $this->headers);
    	}
    }

    public function delete($file) 
    {	
    	return Storage::disk($this->disk)->delete($file);
    }


}