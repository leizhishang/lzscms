<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Model;

use Illuminate\Database\Eloquent\Model;

class CommonSmsCodeModel extends Model
{
    protected $table = 'sms_code';

    protected $fillable = [
        'mobile', 'code', 'expired_time', 'number', 'create_time', 'type'
    ];
    public $timestamps = false;

    static function addInfo($mobile, $type, $code, $number, $expired_time = 0, $create_time = 0) {
    	$postData = [
    		'mobile'=>$mobile,
    		'type'=>$type,
    		'code'=>$code,
    		'number'=>$number,
    		'expired_time'=>$create_time ? $create_time : lzs_time() + 300,
    		'create_time'=> $create_time ? $create_time : lzs_time()
    	];
    	$info = CommonSmsCodeModel::where('mobile', $mobile)->where('type', $type)->first();
    	if($info) {
    		unset($postData['mobile']);
    		unset($postData['type']);
    		CommonSmsCodeModel::where('mobile', $mobile)->where('type', $type)->update($postData);
    	} else {
    		CommonSmsCodeModel::insert($postData);
    	}
    	return true;
    }

	static function _buildCode() {
		$length = lzs_config('sms', 'codelength');
		$length = $length ? $length : 6;
		$code = lzs_random($length, true);
		return $code;
	}
}
