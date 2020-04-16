<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Model;

use Leizhishang\Lzscms\Libraries\LzscmsDb;
use Leizhishang\Lzscms\Libraries\LzscmsFields;

use Cache; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class CommonFieldsModel extends Model
{
    protected $table = 'common_fields';

    protected $fillable = [
        'module', 'relatedid', 'relatedtable', 'name', 'times', 'fieldname', 'fieldtype', 'ismain', 'ismember', 'issearch', 'vieworder', 'disabled', 'setting', 'ismshow'
    ];
    public $timestamps = false;

    public static function addField($data = [])
    {
        $data['relatedid'] = isset($data['relatedid']) ? $data['relatedid'] : 0;
        $data['isedit'] = isset($data['isedit']) ? $data['isedit'] : 0;
        $data['ismain'] = isset($data['ismain']) ? $data['ismain'] : 0;
        $data['ismshow'] = isset($data['ismshow']) ? $data['ismshow'] : 0;
        $data['ismember'] = isset($data['ismember']) ? $data['ismember'] : 0;
        $data['issearch'] = isset($data['issearch']) ? $data['issearch'] : 0;
        $data['vieworder'] = isset($data['vieworder']) ? $data['vieworder'] : 0;
        $data['disabled'] = isset($data['disabled']) ? $data['disabled'] : 0;
        $data['module'] = isset($data['module']) ? $data['module'] : 'site';
        $data['relatedtable'] = isset($data['relatedtable']) ? $data['relatedtable'] : '';
    	$postData = [
    		'module'=> $data['module'],
    		'relatedid'=> $data['relatedid'],
            'relatedtable'=> $data['relatedtable'],
            'name'=> $data['name'],
            'fieldname'=> $data['fieldname'],
            'fieldtype'=> $data['fieldtype'],
            'ismain'=> $data['ismain'],
            'ismshow'=> $data['ismshow'],
            'ismember'=> $data['ismember'],
            'issearch'=> $data['issearch'],
            'vieworder'=> (int)$data['vieworder'],
    		'disabled'=> (int)$data['disabled'],
            'times'=> Lzs_time(),
    		'setting'=> Lzs_array2str($data['setting'])
    	];
        self::createTableSql($postData);
    	if(!self::hasFieldOrColumn($postData)) {
    		return false;
    	}
        $id = CommonFieldsModel::insertGetId($postData);
        if($data['fieldtype'] !== 'Group') {
            $lzscmsFields = new LzscmsFields();
            $fobj = $lzscmsFields->get($data['fieldtype']);
            if($fobj !== NULL) {
                $fobj->createSql($postData);
            }
            
        }
        return $id;
    }

    public static function createTableSql($data) 
    {
        $LzscmsDb = new LzscmsDb();
        if($LzscmsDb->hasTable($data['relatedtable'])) {
            return false;
        }
        $LzscmsDb->createTable($data['relatedtable'], function(Blueprint $table)
        {
            $table->increments('id')->comment('ID');
        });
    }

    public static function hasFieldOrColumn($data) 
    {
    	if(CommonFieldsModel::where('relatedtable', $data['relatedtable'])->where('fieldname', $data['fieldname'])->where('module', $data['module'])->limit(1)->count()) {
    		return false;
    	}
        $LzscmsDb = new LzscmsDb();
    	if($LzscmsDb->hasColumn($data['relatedtable'], $data['fieldname'])) {
    		return false;
    	}
    	return true;
    }

    public static function createSql($data) 
    {
        $LzscmsFields = new LzscmsFields();
        $fobj = $LzscmsFields->get($data['fieldtype']);
        if($fobj !== NULL) {
            $data['setting'] = Lzs_str2array($data['setting']);
            $columnAttribute = $fobj->get_columnAttribute($data['setting']['option']);
            $LzscmsDb = new LzscmsDb();
            if(!$LzscmsDb->hasColumn($data['relatedtable'], $data['fieldname'])) {
                $LzscmsDb->addColumn($data['relatedtable'], $data['fieldname'], $columnAttribute);
            }
        }
    }

    public static function deleteField($id)
    {
        if(!$id) return false;
        $info = CommonFieldsModel::getField($id);
        if(!$info) return false;
        CommonFieldsModel::where('id', $id)->delete();
        $LzscmsFields = new LzscmsFields();
        $fobj = $LzscmsFields->get($info['fieldtype']);
        if($fobj !== NULL) {
            $fobj->deleteSql($info);
        }
    	return true;
    }

    public static function deleteSql($data)
    {
        $LzscmsDb = new LzscmsDb();
        if($LzscmsDb->hasColumn($data['relatedtable'], $data['fieldname'])) {
            $LzscmsDb->dropColumn($data['relatedtable'], $data['fieldname']);
        }
        return true;
    }

    static function getManageContentListShowFields($table = '')
    {
        if(!$table) return [];
        $fields = self::getFields($table);
        $showFields = [];
        foreach ($fields as $key => $value) {
            if($value['ismshow']) {
                $showFields[] = $value;
            }
        }
        return $showFields;
    }

    static function getFields($table = 'all', $result = false)
    {
        $cacheName = 'fields:'.$table;
        if (!Cache::has($cacheName)) {
            $data = self::setCache($table);
        } else {
            $data = Cache::get($cacheName);
        }
        if($result) {
            $newdata = [];
            foreach ($data as $key => $value) {
                $newdata[$value['fieldname']] = $value;
            }
            return $newdata;
        }
        return $data;
    }

    static function getField($id = 0, $table = 'all')
    {
        if(!$id) return [];
        $fields = self::getFields($table);
        if(!$fields || !isset($fields[$id])) return [];
        return $fields[$id];
    }

    static function setCache($table = 'all', $result = true) 
    {
        $cacheData = [];
        if($table == 'all') {
            $data = CommonFieldsModel::where('id', '>', 0)->orderBy('vieworder', 'desc')->get();
        } else {
            $data = CommonFieldsModel::where('relatedtable', $table)->orderBy('vieworder', 'desc')->get();
        }
        $data = $data->toArray();
        foreach ($data as $key => $value) {
            $value['setting'] = lzs_str2array($value['setting']);
            $cacheData[$value['id']] = $value;
        }
        $cacheName = 'fields:'.$table;
        Cache::forever($cacheName, $cacheData);
        if(!$result) {
            unset($cacheData);
            return '';
        }
        return $cacheData;
    }
}
