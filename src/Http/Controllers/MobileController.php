<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers;

use Leizhishang\Lzscms\Libraries\LzscmsSms;
use App\Modules\Account\Model\UsersModel;

use Illuminate\Http\Request;
use Auth;
/**
* 
*/
class MobileController extends GlobalBasicController
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
            return $this->showError(lzs_lang('lzscms::public.enter.one.mobile'));
        }
        if(!$type) {
            return $this->showError(lzs_lang('lzscms::public.send.error'));
        }
        $user = UsersModel::getUsers($mobile, 'mobile', false);
        $uid = '';
        if(!Auth::id() && $user){
            $uid = $user['id']; 
        }
        $lzscmsSms = new LzscmsSms();
        $result = $LzscmsSms->sendMobileMessage($mobile, $type, [], $uid);
        if (lzs_message_verify($result)) return $this->showError($result['message']);
        return $this->showMessage('lzscms::public.send.success');
    }

    public function verify(Request $request) 
    {
        $mobile = $request->get('mobile');
        $type = $request->get('type');
        $mobileCode = $request->get('mobile_code');
        if(!$mobile) {
            return $this->showError(lzs_lang('lzscms::public.enter.one.mobile'));
        }
        if(!$mobileCode) {
            return $this->showError(lzs_lang('lzscms::public.enter.one.mobile.code'));
        }
        if(!$type) {
            return $this->showError(lzs_lang('lzscms::public.verification.failure'));
        }
        $lzscmsSms = new LzscmsSms();
        $result = $LzscmsSms->checkVerify($mobile, $mobileCode, $type);
        if (lzs_message_verify($result))  return $this->showError($result['message']);
        return $this->showMessage('lzscms::public.send.success');
    }
}