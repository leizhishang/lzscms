<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Model;

use Illuminate\Database\Eloquent\Model;
use Leizhishang\Lzscms\Libraries\LzscmsStorage;
use Cache;

class AttachmentModel extends Model
{
    protected $table = 'attachs';

    protected $fillable = [
        'aid', 'name', 'type', 'size', 'path', 'ifthumb', 'created_userid', 'created_time', 'app', 'app_id', 'descrip', 'disk'
    ];
    public $timestamps = false;

    static function getStorages($k = '') 
    {
        $storages = [
            'local' => [
                'name'=>lzs_lang('lzscms::manage.attachment.local'),
                'desc'=>'',
                'manageurl'=>''
            ],
            'public' => [
                'name'=>lzs_lang('lzscms::manage.attachment.public'),
                'desc'=>'',
                'manageurl'=>''
            ],
            'ftp' => [
                'name'=>lzs_lang('lzscms::manage.attachment.ftp'),
                'desc'=>'',
                'manageurl'=>''
            ]
        ];
        $storages = lzscms_hook('s_attach', $storages, true);
        if($k) {
            return $storages[$k];
        }
        return $storages;
    }

    static function getAttach($aid = 0)
    {
        if(!$aid) {
            return [];
        }
        $cacheName = 'lzscms:attachment:info:'.$aid;
        if (!Cache::has($cacheName)) {
            $info = self::setCacheInfo($aid);
        } else {
            $info = Cache::get($cacheName, []);
        }
        if(!$info) {
            return [];
        }
        $info['url'] = Lzs_storage_url($info['path'], $info['disk']);
        return $info;
    }

    static function setCacheInfo($aid = 0)
    {
        $info = AttachmentModel::where('aid', $aid)->first();
        $cacheName = 'lzscms:attachment:info:'.$aid;
        if($info) {
            Cache::forever($cacheName, $info->toArray());
            return $info->toArray();
        }
        // Cache::forever($cacheName, []);
        return [];
    }

    static function delCacheInfo($aid = 0)
    {
        $cacheName = 'lzscms:attachment:info:'.$aid;
        Cache::forget($cacheName);
    }

    static function getAttachs($aids = [])
    {
        if(!$aids) {
            return [];
        }
        foreach ($aids as $aid) {
            $attachs[] = self::getAttach($aid);
        }
        return $attachs;
    }

    static function deleteAttach($aid) 
    {
        $attachInfo = AttachmentModel::where('aid', $aid)->first();
        if($attachInfo) {
            $LzscmsStorage = new LzscmsStorage();
            $LzscmsStorage->disk = $attachInfo['disk'];
            $LzscmsStorage->delete($attachInfo['path']);
            AttachmentModel::where('aid', $aid)->delete();
        }
        return true;
    }

    static function deleteAttachByAppId($app = '', $app_id) 
    {
        $attachs = AttachmentModel::where('app', $app)->where('app_id', $app_id)->select('aid')->get();
        if($attachs) {
            foreach ($attachs as $key => $value) {
                self::deleteAttach($value['aid']);
            }
        }
        return true;
    }

    static function updateAttach($aid, $app_id)
    {
        if(!$aid) {
            return true;
        }
        if(is_array($aid)) {
            AttachmentModel::whereIn('aid', $aid)->update([
                'app_id'=>$app_id
            ]);
            return true;
        }
        AttachmentModel::where('aid', $aid)->update([
            'app_id'=>$app_id
        ]);
        return true;
    }

    static function setTempData($tempid = '', $aid = 0)
    {
        if(!$tempid || !$aid) {
            return true;
        }
        $cacheName = 'lzscms:attachment:temp:'.$tempid;
        $data = Cache::get($cacheName, []);
        array_push($data, $aid);
        Cache::forever($cacheName, $data);
        return true;
    }

    static function handleTempData($tempid = '', $app_id = 0) 
    {
        if(!$tempid) {
            return true;
        }
        $cacheName = 'lzscms:attachment:temp:'.$tempid;
        if($app_id) {
            $aids = Cache::get($cacheName, []);
            if($aids) {
                AttachmentModel::whereIn('aid', $aids)->update([
                    'app_id'=>$app_id
                ]);
            }
        }
        Cache::forget($cacheName);
        return true;
    }
}
