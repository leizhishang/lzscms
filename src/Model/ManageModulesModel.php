<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Model;

use Leizhishang\Lzscms\Model\CommonRoleModel;

use Illuminate\Database\Eloquent\Model;
use Cache;

class ManageModulesModel extends Model
{

    protected $table = 'modules';
    protected $fillable = [
        'name', 'slug', 'description', 'times', 'version', 'enabled'
    ];
    public $timestamps = false;


    static function getData()
    {
        if (!Cache::has('hstmodules')) {
            $data = self::setCache();
        } else {
            $data = Cache::get('hstmodules');
        }
        return $data;
    }

    static function setCache($result = true) 
    {
        $cacheData = [];
        $data = ManageModulesModel::where('id', '>', '0')->get();
        foreach ($data as $key => $value) {
            $cacheData[$key] = [
                'id'=>trim($value['id']),
                'name'=>trim($value['name']),
                'slug'=>trim($value['slug']),
                'description'=>$value['description'],
                'times'=>$value['times'],
                'version'=>$value['version'],
                'enabled'=>$value['enabled'],
                'setting'=>lzs_config('mod'.$value['slug'])
            ];
        }
        Cache::forget('hstmodules');
        Cache::forever('hstmodules', $cacheData);
        if(!$result) {
            unset($cacheData);
            return '';
        }
        return $cacheData;
    }
}
