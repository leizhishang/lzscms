<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Model;

use Cache; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;

class CommonSpecialModel extends Model
{
    protected $table = 'common_special';

    protected $fillable = [
        'name', 'isopen', 'header', 'footer', 'title', 'keywords', 'description', 'domain', 'style', 'dir', 'content', 'module'
    ];
    public $timestamps = false;

    static function addInfo($id, $postData) 
    {
        $files = new Filesystem();
        $path = realpath(__DIR__.'/../../views/special/default');
        $files->copyDirectory($path, public_path('theme/special/'.$id));
    }

    static function deleteSpecial($id)
    {
        $data = self::getData('all', 'lists');
        if(!isset($data[$id])) {
            return false;
        }
        CommonSpecialModel::where('id', $id)->delete();
        $files = new Filesystem();
        @$files->deleteDirectory(public_path('theme/special/'.$id));
    }

    static function hasSpecial($dir = '', $module = 'all', $id = 0) 
    {
        $data = self::getData($module, 'dirs');
        if($id) {
            if(!isset($data[$dir])) {
                return false;
            }
            if(isset($data[$dir]) && $data[$dir] == $id) {
                return false;
            }
            return true;
        }
        return isset($data[$dir]) ? true : false;
    }

    static function getInfo($id, $module = 'all') 
    {
        $data = self::getData($module, 'lists');
        return isset($data[$id]) ? $data[$id] : [];
    }

    static function getIdByDir($dir, $module = 'all') 
    {
        $data = self::getData($module, 'dirs');
        return isset($data[$dir]) ? $data[$dir] : 0;
    }
   
    static function getData($module = 'all', $result = '')
    {
        $cacheName = 'special:'.$module;
        if (!Cache::has($cacheName)) {
            $data = self::setCache($module);
        } else {
            $data = Cache::get($cacheName);
        }
        if($result) {
            return isset($data[$result]) ? $data[$result] : [];
        }
        return $data;
    }

    static function setCache($module = 'all', $result = true) 
    {
        $cacheData = [
            'lists'=>[],
            'dirs'=>[],
            'domains'=>[]
        ];
        if($module === 'all') {
            $data = CommonSpecialModel::where('id', '>', 0)->orderBy('id', 'desc')->get();
        } else {
            $data = CommonSpecialModel::where('module', $module)->orderBy('id', 'desc')->get();
        }
        foreach ($data as $key => $value) {
            $cacheData['lists'][$value['id']] = [
                'id'=>trim($value['id']),
                'name'=>trim($value['name']),
                'isopen'=>trim($value['isopen']),
                'header'=>trim($value['header']),
                'footer'=>$value['footer'],
                'ismobile'=>$value['ismobile'],
                'keywords'=>$value['keywords'],
                'description'=>$value['description'],
                'domain'=>$value['domain'],
                'style'=>$value['style'],
                'dir'=>$value['dir'],
                'content'=>$value['content'],
                'module'=>$value['module'],
                'title'=>trim($value['title'])
            ];
            $cacheData['dirs'][$value['dir']] = $value['id'];
            $cacheData['domain'][$value['domain']] = $value['id'];
        }
        $cacheName = 'special:'.$module;
        Cache::forget($cacheName);
        Cache::forever($cacheName, $cacheData);
        if(!$result) {
            unset($cacheData);
            return '';
        }
        return $cacheData;
    }

}
