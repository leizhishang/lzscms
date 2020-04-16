<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Model;

use Illuminate\Database\Eloquent\Model;

class ManageLoginLogModel extends Model
{
    protected $table = 'manage_login_log';

    protected $fillable = [
        'uid', 'username', 'times', 'remark', 'ip', 'port', 'device', 'browser'
    ];
    public $timestamps = false;

    static function addLog($user = [], $remark = '')
    {
        if(!$user) {
            $user = [
                'uid'=>0, 
                'username'=>'system'
            ];
        }
        $postData = [
            'uid'=>$user['uid'],
            'username'=>$user['username'],
            'times'=>lzs_time(),
            'ip'=>lzs_ip(),
            'port'=>lzs_port(),
            'platform'=>lzs_agent()->platform(),
            'browser'=>lzs_agent()->browser(),
            'remark'=>$remark
        ];
        ManageLoginLogModel::insert($postData);
    }
}
