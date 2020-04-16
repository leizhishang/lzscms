<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;

class CommonSmsModel extends Model
{
    protected $table = 'sms_logs';

    protected $fillable = [
        'id', 'uid', 'type', 'note', 'content', 'mobile', 'times', 'status', 'sendnum', 'code', 'rtype', 'requestid', 'jstimes', 'stimes'
    ];
    public $timestamps = false;

    static function addInfo($mobile, $type, $code, $content = '', $note = '', $rtype = '', $requestid = 0, $uid = 0) {
        $postData = [
            'mobile'=>$mobile,
            'type'=>$type,
            'code'=>$code,
            'uid'=>isset($uid) && $uid ? $uid : (int)Auth::id(),
            'note'=>$note,
            'content'=>$content,
            'sendnum'=>1,
            'status'=>1,
            'requestid'=>(string)$requestid,
            'rtype'=>(string)$rtype,
            'times'=> lzs_time()
        ];
        CommonSmsModel::insert($postData);
        return true;
    }

    static function getPlatform($k = '') 
    {
        $platforms = [
            'Leizhishang' => [
                'alias'=>'Leizhishang',
                'name'=>lzs_lang('lzscms::manage.Leizhishang.sms'),
                'desc'=>lzs_lang('lzscms::manage.Leizhishang.sms.tips'),
                'surl'=>route('manageSmsHstsmsConfig'),
                'components'=>'Leizhishang\Lzscms\Libraries\LzscmsSmsApi'
            ]
        ];
        $platforms = Lzscms_hook('s_sms', $platforms, true);
        if($k) {
           return isset($platforms[$k]) ? $platforms[$k] : [];
       
        }
        return $platforms;
    }

    static function getType($k = '')
    {
        $types = [
            'code'=>[
                'name'=>lzs_lang('lzscms::public.captcha'),
                'num'=>'100',
                'content'=>'',
                'desc'=> '',
                'descs'=>lzs_lang('lzscms::manage.sms.content.r'),
            ],
            'register'=>[
                'name'=>lzs_lang('lzscms::public.register'),
                'num'=>'10',
                'content'=>'',
                'desc'=>lzs_lang('lzscms::manage.sms.register.tips'),
                'descs'=>lzs_lang('lzscms::manage.sms.content.r'),
            ],
            'login'=>[
                'name'=>lzs_lang('lzscms::public.login'),
                'num'=>'15',
                'content'=>'',
                'desc'=>lzs_lang('lzscms::manage.sms.login.tips'),
                'descs'=>lzs_lang('lzscms::manage.sms.content.r'),
            ],
            'findpw'=>[
                'name'=>lzs_lang('lzscms::public.findpw'),
                'num'=>'10',
                'content'=>'',
                'desc'=>lzs_lang('lzscms::manage.sms.findpw.tips'),
                'descs'=>lzs_lang('lzscms::manage.sms.content.r'),
            ],
        ];
        $types = lzscms_hook('s_sms_types', $types, true);
        if($k && isset($types[$k])) {
            return $types[$k];
        }
        return $types;
    }

}
