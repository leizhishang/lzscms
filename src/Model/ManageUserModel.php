<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Cache;

class ManageUserModel extends Model
{
    protected $table = 'manage_user';

    protected $fillable = [
        'uid', 'username', 'email', 'password', 'salt', 'status', 'avatar', 'name', 'mobile', 'gid', 'qq', 'weixin'
    ];
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
    }

    static function checkPassword($username, $password)
    {
        if(!$username || !$password) {
            return false;
        }
        $users = self::getAll();
        $uinfo = [];
        foreach ($users  as $key => $value) {
            if($value['username'] == $username) {
                $uinfo = $value;
            }
        }
    	if(!$uinfo) {
    		return false;
    	}
    	if(Lzs_md5($password, $uinfo['salt']) != $uinfo['password']) {
    		return false;
    	}
    	return true;
    }

    static function getFounder()
    {
        $users = self::getAll();
        $founders = [];
        foreach ($users as $key => $value) {
            if($value['gid'] == 99) {
                $founders[$key] = $value;
            }
        }
        return $founders;
    }

    static function managerDoLogin($user)
    {
        return Session::put('manager', encrypt($user['uid'].'|'.$user['username'].'|'.$user['mobile'].'|'.$user['email'].'|'.Lzs_time()));
    }

    static function getUsers()
    {
        $users = self::getAll();
        $data = [];
        foreach ($users as $key => $value) {
            if($value['gid'] != 99) {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    static function getUser($uid = 0)
    {
        if(!$uid) return [];
        $users = self::getAll();
        return isset($users[$uid]) && $users[$uid] ? $users[$uid] : [];
    }

    static function getAll()
    {
        if (!Cache::has('manage:user')) {
            $data = self::setCache();
        } else {
            $data = Cache::get('manage:user');
        }
        return $data;
    }

    static function setCache($result = true) 
    {
        $cacheData = [];
        $data = ManageUserModel::where('uid', '>', 0)->orderBy('uid', 'desc')->get();
        foreach ($data as $key => $value) {
            $cacheData[$value['uid']] = [
                'uid'=>trim($value['uid']),
                'username'=>trim($value['username']),
                'password'=>trim($value['password']),
                'salt'=>trim($value['salt']),
                'status'=>trim($value['status']),
                'avatar'=>trim($value['avatar']),
                'name'=>trim($value['name']),
                'mobile'=>trim($value['mobile']),
                'email'=>trim($value['email']),
                'gid'=>trim($value['gid']),
                'qq'=>trim($value['qq']),
                'weixin'=>trim($value['weixin'])
            ];
        }
        Cache::forever('manage:user', $cacheData);
        if(!$result) {
            unset($data);
            unset($cacheData);
            return '';
        }
        return $cacheData;
    }
}
