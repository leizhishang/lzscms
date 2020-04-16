<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Api;

use Leizhishang\Lzscms\Helpers\Api\ApiResponse;

use App\Http\Controllers\Controller;

class BasicController extends Controller
{

    use ApiResponse;
    
    protected   $_showdata;                         //显示信息array
    public      $viewData = array();                //传递给模版的共享内容
    
    public function __construct()
    {
    }

    // 其他通用的Api帮助函数

    //================================================信息显示区==========================================================//
    
    /**
     * 添加显示内容 **
     *
     * @param  $message 可以是array，也可以使string
     * @param string $str 键名
     * @param return null
     */
    protected function addMessage($message = array(), $str = '')
    {
        if(!$str) return;
        $this->_showdata[$str] = $message;
    }

    public function showError($message = '', $routeName = '', $with = 0)
    {
        if(in_array($routeName, [1,2,3,5])) {
            $with = $routeName;
            $routeName = '';
        }
        return $this->showMessage($message, $routeName, $with, 'fail');
    }

    public function showMessage($message = '', $routeName = '', $with = 0, $state='success') 
    {
        if(in_array($routeName, [1,2,3,5])) {
            $with = $routeName;
            $routeName = '';
        }
        if($with != 2) {
            $message = Lzs_lang($message);
        }
        $viewDatas = isset($this->viewData) ? $this->viewData : array();
        if($routeName && !preg_match('|^http://|', $routeName) && !$with) {
            $routeName = $routeName ? route($routeName) : '';
        }
        $viewData = [
            'message'=>$message,
            'referer'=>$routeName,
            'state' => $state,
            'with' => $with
        ];
        $viewData = array_merge($viewData, $viewDatas);
        if(substr_count($_SERVER['HTTP_ACCEPT'], 'application/json')) {
            if($routeName && !preg_match('|^http://|', $routeName)) {
                $routeName = $routeName ? route($routeName) : '';
            }
            $viewData['referer'] = $routeName;
            return response()->json($viewData);
        }
        if($with == 1) {                                            //跳转指定链接提示
            if(preg_match('|^http://|', $routeName)) {
                return redirect($routeName)->with($viewData);
            }
            return redirect()->route($routeName)->with($viewData);
        } else if($with == 2) {                                     //表单提交错误提示
            if(preg_match('|^http://|', $routeName)) {
                return redirect($routeName)
                    ->withErrors($message)
                    ->withInput();
            }
            return redirect()->route($routeName)
                ->withErrors($message)
                ->withInput();
        } else if($with == 5) {                                     //返回上一级提示
            return back()->with($viewData);
        }
        return $this->loadTemplate('lzscms::common.tips', $viewData);
    }

    /**
     * 加载模版
     *
     * @param string $tpl
     * @param array $data
     * @return template
     */

    public function loadTemplate($tpl, $data = array(), $viewData = true)
    {
        $viewData && $data = $data + $this->viewData;
        if(substr_count($tpl, '::') ) {
            return view($tpl, $data);
        }
        return view($tpl, $data);
    }
}