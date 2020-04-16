<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Model;

use Illuminate\Database\Eloquent\Model;
use Cache;

class ApiModel extends Model
{
    protected $table = 'common_api';

    protected $fillable = [
        'id', 'name', 'appid', 'secret', 'addtimes', 'edittimes', 'status'
    ];
    public $timestamps = false;

    static function setCache() 
    {
        $cacheName = 'Lzscms:api';
        $data = ApiModel::where('id', '>', 0)->get();
        $vData = [];
        foreach ($data as $key => $value) {
            $vData[$value['appid']] = [
                'name'=>$value['name'],
                'appid'=>$value['appid'],
                'secret'=>$value['secret'],
                'addtimes'=>$value['addtimes'],
                'edittimes'=>$value['edittimes'],
                'status'=>$value['status']
            ];
        }
        Cache::forever($cacheName, $vData);
        return $vData;
    }
}
