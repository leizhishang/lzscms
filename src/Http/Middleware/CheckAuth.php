<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Middleware;

use Leizhishang\Lzscms\Model\ManageUserModel;
use Leizhishang\Lzscms\Model\CommonRoleModel;
use Leizhishang\Lzscms\Model\ManageLoginLogModel;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Closure;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $manager = $request->session()->get('manager');
        if(!$manager) {
            return redirect()->route('manageAuthLogin');
        }
        $managers = decrypt($manager);
        list($uid, $username, $mobile, $email, $time) = explode('|', $managers);
        $uinfo = ManageUserModel::getUser($uid);
        if(!$uinfo) {
            $request->session()->forget('manager');
            return redirect()->route('manageAuthLogin');
        }
        if($uinfo['status'] == 1) {
            $request->session()->forget('manager');
            ManageLoginLogModel::addLog(lzs_manager(), lzs_lang('lzscms::manage.user.disable.log'));
            return redirect()->route('manageAuthLogin')->withInput()->withErrors(['password'=> lzs_lang('lzscms::manage.user.disable')]);
        }
        $loginCitme = lzs_config('safe', 'manage.login.ctime') ? lzs_config('safe', 'manage.login.ctime') : 30;
        if((lzs_time() - $time) > $loginCitme*60 && !Session::get('manager_locked')) {
            ManageLoginLogModel::addLog(Lzs_manager(), lzs_lang('lzscms::manage.ctime.logout'));
            $request->session()->forget('manager');
            return redirect()->route('manageAuthLogin');
        }
        Session::put('manager', encrypt($uinfo['uid'].'|'.$uinfo['username'].'|'.$uinfo['mobile'].'|'.$uinfo['email'].'|'.lzs_time()));
        $route = Route::currentRouteName();
        if(Session::get('manager_locked')) {
            if($route && !in_array($route, ['manageLocked', 'manageUnLocked', 'manageDoLocked'])) {
                if(substr_count($_SERVER['HTTP_ACCEPT'], 'application/json')) {
                    $viewData = [
                        'message'=> lzs_lang('lzscms::public.lockeds')
                    ];
                    return response()->json($viewData);
                }
                return redirect()->route('manageLocked');
            }
        }
        if($uinfo['gid'] != '99') {
            $roleInfo = CommonRoleModel::getInfo($uinfo['gid']);
            if($route && !in_array($route, ['manageIndex', 'manageHome', 'manageUserInfoEdit', 'manageUserInfoEditSave']) && !in_array($route, $roleInfo['auths'])) {
                if(substr_count($_SERVER['HTTP_ACCEPT'], 'application/json')) {
                    $viewData = [
                        'message'=> lzs_lang('lzscms::manage.no.auth'),
                        'referer'=> '',
                        'state' => 'fail',
                        'with' => 0
                    ];
                    return response()->json($viewData);
                }
                if($request->get('_ajax')){
                    
                }
                return back()->with(['state'=>'error', 'message'=> lzs_lang('lzscms::manage.no.auth')]);
            }
        }
        $request->attributes->add(['managerInfo'=>$uinfo]);    //添加参数
        return $next($request);
    }
}
