<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Model;

use Cache; 
use Illuminate\Database\Eloquent\Model;
use Leizhishang\Lzscms\Libraries\LzscmsDb;
use Illuminate\Database\Schema\Blueprint;

class CommonFormModel extends Model
{
    protected $table = 'common_form';

    protected $fillable = [
        'module', 'relatedid', 'name', 'table', 'setting', 'times'
    ];
    public $timestamps = false;

    public static function addForm($data = [])
    {
        $data['relatedid'] = isset($data['relatedid']) ? $data['relatedid'] : 0;
    	$postData = [
    		'module'=> isset($data['module']) ? $data['module'] : 'site',
    		'relatedid'=> $data['relatedid'],
    		'name'=> $data['name'],
    		'table'=> $data['table'],
            'times'=> lzs_time(),
    		'setting'=> lzs_array2str($data['setting'])
    	];
    	if(!self::hasFormOrTable($data['table'], $data['module'], $data['relatedid'])) {
    		return false;
    	}
        $id = CommonFormModel::insertGetId($postData);
        CommonFormModel::createSql($id, $postData);
        return $id;
    }

    public static function hasFormOrTable($table, $module = 'site', $relatedid = 0) 
    {
    	if(CommonFormModel::where('table', $table)->where('module', $module)->where('relatedid', $relatedid)->limit(1)->count()) {
    		return false;
    	}
        $lzscmsDb = new LzscmsDb();
    	if($lzscmsDb->hasTable($table)) {
    		return false;
    	}
    	return true;
    }

    public static function createSql($id, $data) 
    {
        $lzscmsDb = new LzscmsDb();
    	if($lzscmsDb->hasTable($data['table'])) {
    		return false;
    	}
        $lzscmsDb->createTable($data['table'], function(Blueprint $table)
        {
            $table->increments('id')->comment('ID');
            $table->integer('created_uid')->default(0)->comment();
            $table->integer('created_time')->default(0)->comment();
            $table->string('created_ip', 150)->default('')->comment();
            $table->string('created_port')->default('')->comment();
            $table->integer('vieworder')->default(0)->comment();
        });
    }

    public static function deleteForm($table, $module = 'site', $relatedid = 0)
    {
    	$formInfo = CommonFormModel::where('table', $table)->where('module', $module)->where('relatedid', $relatedid)->first();
    	if(!$formInfo) {
    		return false;
    	}
        CommonFormModel::where('table', $table)->where('module', $module)->where('relatedid', $relatedid)->delete();
        $lzscmsDb = new LzscmsDb();
    	if($lzscmsDb->hasTable($table)) {
    		$lzscmsDb->dropTable($table);
    	}
        CommonFieldsModel::where('relatedtable', $table)->where('module', $module)->where('relatedid', $formInfo['id'])->delete();
        CommonFieldsModel::setCache($table);
        CommonFieldsModel::setCache('all');
    	return true;
    }

    static function getForms($module = 'all')
    {
        $cacheName = 'form:'.$module;
        if (!Cache::has($cacheName)) {
            $data = self::setCache($module);
        } else {
            $data = Cache::get($cacheName);
        }
        return $data;
    }

    static function getForm($id = 0, $module = 'all')
    {
        if(!$id) return [];
        $forms = self::getForms($module);
        if(!$forms || !isset($forms['list'][$id])) return [];
        return $forms['list'][$id];
    }

    static function setCache($module = 'all', $result = true) 
    {
        $cacheData = [
            'list'=>[],
            'table'=>[],
            'relatedid'=>[]
        ];
        if($module === 'all') {
            $data = CommonFormModel::where('id', '>', 0)->orderBy('id', 'desc')->get();
        } else {
            $data = CommonFormModel::where('module', $module)->orderBy('id', 'desc')->get();
        }
        foreach ($data as $key => $value) {
            $cacheData['list'][$value['id']] = [
                'id'=>trim($value['id']),
                'name'=>trim($value['name']),
                'table'=>trim($value['table']),
                'relatedid'=>trim($value['relatedid']),
                'setting'=>lzs_str2array($value['setting']),
                'times'=>$value['times'],
                'times_str'=>lzs_time2str($value['times']),
                'module'=>trim($value['module'])
            ];
            $cacheData['table'][$value['table']] = $value['id'];
            if($value['relatedid']) {
                $cacheData['relatedid'][$value['relatedid']] = $value['id'];
            }
        }
        $cacheName = 'form:'.$module;
        Cache::forget($cacheName);
        Cache::forever($cacheName, $cacheData);
        if(!$result) {
            unset($cacheData);
            return '';
        }
        return $cacheData;
    }
}
