<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Api;

use Leizhishang\Lzscms\Http\Controllers\Api\BasicController as ApiBaseController;

use Leizhishang\Lzscms\Libraries\LzscmsSms;
use App\Modules\Account\Model\UsersModel;

use Illuminate\Http\Request;
/**
* 
*/
class MobileController extends ApiBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function send(Request $request) 
    {
        $mobile = $request->get('mobile');
        $type = $request->get('type');
        if(!$mobile) {
            return $this->message(lzs_lang('lzscms::public.enter.one.mobile'), '-101');
        }
        if(!$type) {
            return $this->message(lzs_lang('lzscms::public.send.error'), '-102');
        }
        if($type == 'login' || $type == 'findpw') {
            if(!UsersModel::where('mobile', $mobile)->first()) {
                return $this->message(lzs_lang('account::public.username.error'), '-102');
            }
        }
        if($type == 'register') {
            if(UsersModel::where('mobile', $mobile)->first()) {
                return $this->message(lzs_lang('account::public.mobile.has.used'), '-102');
            }
        }
        $uid = '';
        $lzscmsSms = new LzscmsSms();
        $result = $lzscmsSms->sendMobileMessage($mobile, $type, [], $uid);
        if (lzs_message_verify($result)) return $this->message($result['message'], '-103');
        return $this->message(lzs_lang('lzscms::public.send.success'));
    }
}