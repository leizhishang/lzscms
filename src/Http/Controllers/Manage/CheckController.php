<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Illuminate\Http\Request;
use Validator;

class CheckController extends BasicController
{
    private $step;

    public function __construct()
    {
        parent::__construct();
        $this->step = $this->_get_step();
        $this->navs = [
            'index'=>['name'=>lzs_lang('lzscms::manage.check.index'),'url'=>'manageCheckIndex'],
            'info'=>['name'=>lzs_lang('lzscms::manage.check.info'),'url'=>'manageCheckInfo'],
        ];
    }

    public function index(Request $request)
    {
        $this->viewData['navs'] = $this->getNavs('index');
    	return $this->loadTemplate('lzscms::manage.check.index', [
            'step'=>$this->step
        ]);
    }
    
    /**
     * PHP环境 **
     */
    public function info() 
    {
        $this->viewData['navs'] = $this->getNavs('info');
        return $this->loadTemplate('lzscms::manage.check.info');
    }

    /**
     * 执行检测 **
     */
    public function dorun(Request $request) 
    {
        $step = max(1, (int)$request->get('step'));
        if (isset($this->step[$step]) && isset($this->step[$step]['0']) && method_exists($this, $this->step[$step]['0'])) 
        {
            echo @call_user_func_array(array($this, $this->step[$step][0]), []);
        }
    }

    
    /**
     * 版本检测
     */
    private function _version() 
    {
       
    }
    
    /**
     * 上传参数检测 **
     */
    private function _upload() 
    {
        // $post = intval(@ini_get("post_max_size"));
        // $file = intval(@ini_get("upload_max_filesize"));
        // $str = '';
        // if ($file >= $post) {
        //     $str .= lang('lzscms::manage.check.upload.001', array('{urlhtml}'=>lang('check.upload.005', array('{url}'=>''))));
        // }
        // if ($file < 10) {
        //     $str .=lang('lzscms::manage.check.upload.002', array('{file}'=>$file,'{urlhtml}'=>lang('check.upload.005', array('{url}'=>''))));
        // }
        // if ($post < 10) {
        //     $str .=lang('lzscms::manage.check.upload.003', array('{post}'=>$post,'{urlhtml}'=>lang('check.upload.005', array('{url}'=>''))));
        // }
        // if(!$str) {
        //     $this->showMessage('lzscms::manage.check.upload.004');
        // } else {
        //     $this->showError(str_replace(':', '{$hstx}', $str));
        // }
    }
    
    /**
     * ini_get **
     */
    private function _ini_get() 
    {
        if (!function_exists('ini_get')) {
            return $this->showError('lzscms::manage.check.ini.get.001', 0);
        }
        return $this->showMessage('lzscms::manage.check.ini.get.002');
    }
    
    /**
     * 解压函数检测 **
     */
    private function _unzip() 
    {
        if (!function_exists('gzopen')) {
            return $this->showError('lzscms::manage.check.unzip.001');
        }
        return $this->showMessage('lzscms::manage.check.unzip.002');
    }
    
    /**
     * 解压函数检测 **
     */
    private function _gzinflate() 
    {
        if (!function_exists('gzinflate')) {
            return $this->showError('lzscms::manage.check.gzinflate.001');
        }
        return $this->showMessage('lzscms::manage.check.gzinflate.002');
    }
    
    /**
     * 后台入口名称检测 **
     */
    private function _admin_file() 
    {
        // if ($this->uri->segment(1) == 'admin') {
        //     $this->showError('check.admin.file.001');
        // }
        // $this->showMessage(array('check.admin.file.002', array('{file}'=>$this->uri->segment(1))));
    }
    
    /**
     * 目录是否可写 **
     */
    private function _dir_write() 
    {
       
    }

    /**
     * Cookie安全码验证 **
     */
    private function _cookie_pre() 
    {
        
    }
    
    /**
     * allow_url_fopen **
     */
    private function _url_fopen() 
    {
        if (!ini_get('allow_url_fopen')) {
            return $this->showError('lzscms::manage.check.url.fopen.001');
        }
        return $this->showMessage('lzscms::manage.check.url.fopen.002');
    }
    
    /**
     * curl_init **
     */
    private function _curl_init() 
    {
        if (!function_exists('curl_init')) {
            return $this->showError(str_replace('{extsion}', ';extension=php_curl.dll', lzs_lang('lzscms::manage.check.curl.init.001')));
        }
        return $this->showMessage('lzscms::manage.check.curl.init.002');
    }

    /**
     * openssl_open **
     */
    private function _openssl_open() 
    {
        if (!function_exists('openssl_open')) {
            return $this->showError(str_replace('{extsion}', ';extension=php_openssl.dll', lzs_lang('lzscms::manage.check.opensll.open.001')));
        }
        return $this->showMessage('lzscms::manage.check.openssl.open.002');
    }
    
    /**
     * fsockopen **
     */
    private function _fsockopen() 
    {
        if (!function_exists('fsockopen')) {
            return $this->showError('lzscms::manage.check.fsockopen.001');
        }
        return $this->showMessage('lzscms::manage.check.fsockopen.002');
    }
    
    /**
     * php **
     */
    private function _php() 
    {

    }
    
    /**
     * mysql **
     */
    private function _mysql() 
    {

    }
    
    /**
     * email **
     */
    private function _email() 
    {
        if (!Lzs_config('email')) {
            return $this->showError("lzscms::manage.check.email.001");
        }
        return $this->showMessage('lzscms::manage.check.email.002');
    }
    
    
    /**
     * memcache **
     */
    private function _memcache() 
    {

    }
    
    /**
     * mcryp **
     */
    private function _mcryp() 
    {
        if (!function_exists('mcrypt_encrypt')) {
            return $this->showError('lzscms::manage.check.mcryp.001');
        }
        return $this->showMessage('lzscms::manage.check.mcryp.002');
    }

    /**
     * 安装文件检查
     */
    private function _install()
    {

    }
    
    
    /**
     * 表结构检测
     */
    private function _tableinfo() 
    {

    }
    
    // 系统体检选项 **
    protected function _get_step() 
    {
        return array(
            //1  => array('_cookie_pre', 'check.001'),
            //2  => array('_admin_file', 'check.002'),
            //3  => array('_dir_write', 'check.003'),
            // 4  => '_template_theme',
            5  => array('_url_fopen', 'allow.url.fopen'),
            6  => array('_curl_init', 'curl.init'),
            7  => array('_fsockopen', 'fsockopen'),
            //8  => array('_php', 'check.008'),
            //9  => array('_mysql', 'mysql'),
            10 => array('_email', 'email'),
            //11 => array('_memcache', 'memcache'),
            12 => array('_mcryp', 'mcryp'),
            //13 => array('_tableinfo', 'check.013'),
            14 => array('_unzip', 'check.014'),
            //15 => array('_install', 'check.015'),
            16 => array('_openssl_open', 'openssl.open'),
            17 => array('_gzinflate', 'check.017'),
            18 => array('_ini_get', 'ini.get'),
            //19 => '_template',
            //20 => array('_upload', 'check.020')
            //21 => '_domain',
            // 98 => '_version',
        );
    }
}

