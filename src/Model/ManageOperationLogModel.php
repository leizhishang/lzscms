<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Model;

use Illuminate\Database\Eloquent\Model;

class ManageOperationLogModel extends Model
{
    protected $table = 'manage_operation_log';

    protected $fillable = [
        'uid', 'username', 'times', 'status', 'ip', 'port', 'platform', 'browser', 'suid', 'susername', 'stimes', 'olddata', 'newdata', 'change', 'remark'
    ];
    public $timestamps = false;

    static function addLog($user, $remark = '', $change = '', $newdata = array(), $olddata = array())
    {
        $postData = [
            'uid'=>$user['uid'],
            'username'=>$user['username'],
            'times'=>lzs_time(),
            'ip'=>lzs_ip(),
            'port'=>lzs_port(),
            'platform'=>lzs_agent()->platform(),
            'browser'=>lzs_agent()->browser(),
            'status'=>0,
            'remark'=>$remark,
            'change'=>$change,
            'olddata'=>serialize($olddata),
            'newdata'=>serialize($newdata),
            'suid'=>0,
            'susername'=>0,
            'stimes'=>0
        ];
        ManageOperationLogModel::insert($postData);
    }
}
