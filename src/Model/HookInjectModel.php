<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Model;

use Illuminate\Database\Eloquent\Model;
use Cache;

class HookInjectModel extends Model
{
    protected $table = 'hook_inject';

    protected $fillable = [
        'hook_name', 'alias', 'files', 'class', 'fun', 'description', 'issystem'
    ];
    public $timestamps = false;

    static function addInfo($hook_name, $alias, $files, $class, $fun, $description = '', $issystem = 0)
    {
        $postData = [
            'times'=> lzs_time(),
            'hook_name'=> $hook_name,
            'alias'=> 'mod_'.$alias,
            'files'=> $files,
            'class'=> $class,
            'fun'=> $fun,
            'description'=> $description,
            'issystem'=> $issystem
        ];
        HookInjectModel::insert($postData);
        HookInjectModel::setAllCache();
        HookInjectModel::setCache();
    }

    static function editInfo($id, $hook_name, $alias, $files, $class, $fun, $description = '')
    {
        $postData = [
            'hook_name'=> $hook_name,
            'alias'=> 'mod_'.$alias,
            'files'=> $files,
            'class'=> $class,
            'fun'=> $fun,
            'description'=> $description
        ];
        HookInjectModel::where('id', $id)->update($postData);
        HookInjectModel::setAllCache();
        HookInjectModel::setCache();
    }

    static function del($t = 'id', $v = '')
    {
        if(!in_array($t, ['id', 'hook_name', 'alias'])) {
            return false;
        }
        HookInjectModel::where($t, $v)->delete();
        HookInjectModel::setAllCache();
        HookInjectModel::setCache();
        return true;
    }

    static function getAll()
    {
        if (!Cache::has('hookInjectAll')) {
            $data = self::setAllCache();
        } else {
            $data = Cache::get('hookInjectAll');
        }
        return $data;
    }

    static function setAllCache()
    {
        $hookInject = HookInjectModel::where('id', '>', 0)->orderBy('id', 'desc')->get()->toArray();
        Cache::forever('hookInjectAll', $hookInject);
        return $hookInject;
    }

    static function setCache()
    {
        $hook = HookModel::getAll(2);
        $data = [];
        foreach ($hook as $key => $value) {
            if(HookInjectModel::where('hook_name', $value['name'])->count()) {
                $data[$value['name']] = HookInjectModel::where('hook_name', $value['name'])->select(['hook_name','files', 'class', 'fun'])->get()->toArray();
            }
        }
        Cache::forever('hookInject', $data);
        return $data;
    }
}
