<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Jenssegers\Agent\Agent;                         //Agent
use Illuminate\Support\Facades\Mail;                //邮箱服务
use Illuminate\Support\Facades\Auth;                //认证

use Leizhishang\Lzscms\Model\CommonConfigModel;
use Leizhishang\Lzscms\Model\CommonBlockModel;
use Leizhishang\Lzscms\Model\ManageUserModel;
use Leizhishang\Lzscms\Libraries\LzscmsPinYin;
use Leizhishang\Lzscms\Libraries\Lzsstring;
use Leizhishang\Lzscms\Libraries\LzscmsFields;
use Leizhishang\Lzscms\Libraries\LzscmsEncrypter;
use Leizhishang\Lzscms\Model\ApiModel;


/**
 * 检测是否安装
 *
 */

if ( ! function_exists('lzs_checkInstall'))
{
    function lzs_checkInstall()
    {
        if (!file_exists(base_path('lzscms.install.lck'))) {
            header('Location:' . route('lzscmsInstallIndex'));
            die(trans('lzscms::public.the.installation.file.was.not.detected'));
        }
    }
}

/**
 * 读取配置信息
 *
 * @param str $name
 * @param str $key
 * @return str|array
 */

if ( ! function_exists('lzs_config'))
{
	function lzs_config($namespace = '', $name  = null)
    {
        $arrConfig = CommonConfigModel::get($namespace, $name);
        return $arrConfig;
    }
}

/**
 * 读取配置信息
 *
 * @param str $name
 * @param str $key
 * @return str|array
 */

if ( ! function_exists('lzs_save_config'))
{
	function lzs_save_config($namespace, $data = array())
    {
        $arrConfig = CommonConfigModel::saveVals($namespace, $data);
        return $arrConfig;
    }
}

/**
 * 返回错误信息
 *
 */

if ( ! function_exists('lzs_message'))
{
    function lzs_message($message  = '', $state = 'error', $data = [])
    {
        $message = [
            'state'=>'error',
            'message'=> lzs_lang($message)
        ];
        if($data) {
            $message['data'] = $data;
        }
        return $message;
    }
}

if ( ! function_exists('lzs_message_verify'))
{
    function lzs_message_verify($message  = '')
    {
        if(!is_array($message)) {
            return false;
        }
        if(!isset($message['state'])) {
            return false;
        }
        if(!isset($message['message'])) {
            return false;
        }
        if($message['state'] == 'error') {
            return true;
        }
        return false;
    }
}

/**
 * Agent
 *
 * @return 
 */
if ( ! function_exists('lzs_agent'))
{
    function lzs_agent()
    {
        return new Agent();
    }
}
/**
 * lang
 *
 * @return
 */
if( ! function_exists('lzs_lang'))
{
    function lzs_lang($v = '', $v2 = '') 
    {
        $v2 = $v2 ? trans($v2) : '';
        return trans($v).$v2;
    }
}
/**
 * csrf
 *
 * @return 
 */
if( ! function_exists('lzs_csrf'))
{
    function lzs_csrf() 
    {
        return csrf_field();
    }
}
/**
 * value
 *
 * @return 
 */
if( ! function_exists('lzs_value'))
{
    function lzs_value($k = '', $data = array(), $default = '') 
    {
        if(!$k) {
            return '';
        }
        if(old($k)) {
            return old($k);
        }
        if(isset($data[$k]) && $data[$k]) {
            return $data[$k];
        }
        return $default;
    }
}

/**
 * switchx
 *
 * @return 
 */
if( ! function_exists('lzs_switch'))
{
    function lzs_switch($request = array(), $k = '', $t = false) 
    {
        if($t) {
            $v = isset($request[$k]) && $request[$k] ? 0 : 1;
        } else {
            $v = isset($request[$k]) && $request[$k] ? 1 : 0;
        }
        return $v;
    }
}

/**
 * manager
 *
 * @return 
 */
if ( ! function_exists('lzs_manager'))
{
    function lzs_manager($v = '')
    {
        $manager = Session::get('manager');
        if(!$manager) {
            return array('uid'=>0, 'username'=>'system');
        }
        $managers = decrypt($manager);
        list($uid, $username, $mobile, $email, $time) = explode('|', $managers);
        $uinfo = ManageUserModel::getUser($uid);
        if(!$uinfo) {
             $uinfo = array('uid'=>0, 'username'=>'system');
        }
        if($v && isset($uinfo[$v])){
            return $uinfo[$v];
        }
        return $uinfo;
    }
}

/**
 * check auth
 *
 * @return 
 */
if ( ! function_exists('lzs_check_auth'))
{
    function lzs_check_auth($route = '')
    {
        $uinfo = lzs_manager();
        $roleInfo = CommonRoleModel::getInfo($uinfo['gid']);
        return in_array($route, $roleInfo['auths']);
    }
}

/**
 * 文件复制
 *
 * @param str $src
 * @param str $dst
 * @return true
 */
if ( ! function_exists('lzs_copy'))
{
	function lzs_copy($src = '', $dst = '') 
    {
        if(!$src || !$dst) return;
        $dir = @opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) 
        {
            if (( $file != '.' ) && ( $file != '..' )) 
            {
                if ( is_dir($src . '/' . $file) ) 
                {
                    lzs_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else 
                {
                    @copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        @closedir($dir);
        return true;
    }
}

/**
 * 生产随机码
 *
 * @param int $length
 * @param bloom $intmode
 * @return str
 */
if ( ! function_exists('lzs_random'))
{
	function lzs_random($length = 4, $intmode = false)
    {
        $hash = '';
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $intmode and $chars = "0123456789";
        $max = strlen($chars) - 1;
        PHP_VERSION < '4.2.0' && mt_srand(( double )microtime() * 1000000);
        for ($i = 0; $i < $length; $i++) {
            $hash .= $chars [mt_rand(0, $max)];
        }
        return $hash;
    }
}

/**
 * md5加密
 *
 * @param str $str
 * @param int $salt
 * @return str
 */
if ( ! function_exists('lzs_md5'))
{
	function lzs_md5($str, $salt = '')
    {
        return md5(md5($str . $salt));
    }
}

/**
 * 字符串星号替换
 *
 * @param str $str
 * @param int $start
 * @param int $length
 * @return str
 */
if ( ! function_exists('lzs_star_replace'))
{
	function lzs_star_replace($str, $start, $length = 0)
    {
        $i = 0;
        $star = '';
        if ($start >= 0) {
            if ($length > 0) {
                $str_len = strlen($str);
                $count = $length;
                if ($start >= $str_len) {//当开始的下标大于字符串长度的时候，就不做替换了
                    $count = 0;
                }
            } elseif ($length < 0) {
                $str_len = strlen($str);
                $count = abs($length);
                if ($start >= $str_len) {//当开始的下标大于字符串长度的时候，由于是反向的，就从最后那个字符的下标开始
                    $start = $str_len - 1;
                }
                $offset = $start - $count + 1;//起点下标减去数量，计算偏移量
                $count = $offset >= 0 ? abs($length) : ($start + 1);//偏移量大于等于0说明没有超过最左边，小于0了说明超过了最左边，就用起点到最左边的长度
                $start = $offset >= 0 ? $offset : 0;//从最左边或左边的某个位置开始
            } else {
                $str_len = strlen($str);
                $count = $str_len - $start;//计算要替换的数量
            }
        } else {
            if ($length > 0) {
                $offset = abs($start);
                $count = $offset >= $length ? $length : $offset;//大于等于长度的时候 没有超出最右边
            } elseif ($length < 0) {
                $str_len = strlen($str);
                $end = $str_len + $start;//计算偏移的结尾值
                $offset = abs($start + $length) - 1;//计算偏移量，由于都是负数就加起来
                $start = $str_len - $offset;//计算起点值
                $start = $start >= 0 ? $start : 0;
                $count = $end - $start + 1;
            } else {
                $str_len = strlen($str);
                $count = $str_len + $start + 1;//计算需要偏移的长度
                $start = 0;
            }
        }
        while ($i < $count) {
            $star .= '*';
            $i++;
        }
        return substr_replace($str, $star, $start, $count);
    }
}

/**
 * 检测字符串为json数据
 *
 * @param $str
 * @return bool
 */
if ( ! function_exists('lzs_isJson'))
{    
    function lzs_isJson($str)
    {
        json_decode($str);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

/**
 * 数组转换成xml
 *
 * @param $arr
 * @return string
 */
if ( ! function_exists('lzs_arrayToXml'))
{    
    function lzs_arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }
}

/**
 * xml转换成array
 *
 * @param $xml
 * @return mixed
 */
if ( ! function_exists('lzs_xmlToArray'))
{    
    function lzs_xmlToArray($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";

            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }
}

/**
 * 获取参数
 *
 * @param $queryString
 * @return mixed
 */
if ( ! function_exists('lzs_getParamByQueryString'))
{    
    function lzs_getParamByQueryString($queryString)
    {
        parse_str(preg_replace("/(\w+)=/", '$1[]=', $queryString), $arr);
        foreach ($arr as $k => $v) {
            if (count($v) > 1) {
                $arr[$k] = $v;
            } else {
                $arr[$k] = $v[0];
            }
        }
        return $arr;
    }
}

/**
 * 数组以某个字段的值为键值
 * @param $data
 * @param $key
 * @return array
 */
if ( ! function_exists('lzs_keyBy'))
{    
    function lzs_keyBy($data, $key)
    {
        $array = [];
        foreach($data as $v) {
            $array[$v[$key]] = $v;
        }
        return $array;
    }
}

/**
 * 数组以某一个字段值为键，并分组
 * @param $data
 * @param $key
 * @return array
 */
if ( ! function_exists('lzs_keyByGroup'))
{    
    function lzs_keyByGroup($data, $key)
    {
        $array = array();
        foreach($data as $v)
        {
            $array[$v[$key]][] = $v;
        }
        return $array;
    }
}

/**
 * 获取概率
 * @param $proArr
 * @param $randNum
 * @return string
 */
if ( ! function_exists('lzs_rand'))
{    
    function lzs_rand($proArr) {
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        return $result;
    }
}

/**
 * 返回html checked
 *
 * @param boolean $var
 * @return string
 */
if ( ! function_exists('lzs_ifcheck'))
{    
    function lzs_ifcheck($var) 
    {
        return $var ? ' checked' : '';
    }
}

/**
 * 返回html selected
 *
 * @param boolean $var
 * @return string
 */
if ( ! function_exists('lzs_isSelected'))
{    
    function lzs_isSelected($var) 
    {
        return $var ? ' selected' : '';
    }
}

/**
 * 返回html current
 *
 * @param boolean $var
 * @param string $type
 * @return string
 */
if ( ! function_exists('lzs_isCurrent'))
{    
    function lzs_isCurrent($var, $type = 'current') 
    {
        return $var ? ' '.$type : '';
    }
}

/**
 * 判断env函数值是否为空
 * @param $key
 * @return bool
 */
if ( ! function_exists('lzs_checkEnvIsNull'))
{    
    function lzs_checkEnvIsNull($key)
    {
        $value = env($key);
        if($value === '' || $value === null)
        {
            return false;
        }else{
            return true;
        }
    }
}

/**
 * 查询env文件中某一变量的值
 * @param $key
 * @return mixed|string
 */
if ( ! function_exists('lzs_findEnvInfo'))
{    
    function lzs_findEnvInfo($key)
    {
        if(array_key_exists($key, $_ENV))
        {
            $envInfo = env($key) ? env($key) : ( $_ENV[$key] ? $_ENV[$key] : '' );
        }else{
            $envInfo = env($key);
        }
        return $envInfo;
    }
}

/**
 * 更新env文件中某一变量的值
 * @param $data
 * @return mixed|string
 */
if ( ! function_exists('lzs_updateEnvInfo'))
{    
    function lzs_updateEnvInfo($data)
    {
        if(is_array($data)) {
            foreach ($data as $key => $value) 
            {
                $path = base_path('.env');
                $originStr = file_get_contents($path);
                if(strstr($originStr, $key)) {
                    $str = $key . "=" . $value;
                    $res = lzs_checkEnvIsNull($key);
                    if($res) {
                        $newStr = $key."=".env($key);
                    } else {
                        if(lzs_findEnvInfo($key)) {
                            $newStr = $key.'='.lzs_findEnvInfo($key);
                        } else {
                            $newStr = $key.'=';
                        }
                    }
                    if($newStr == 'APP_DEBUG=1') {
                        $newStr = 'APP_DEBUG=true';
                    }
                    if($newStr == 'APP_DEBUG=0') {
                        $newStr = 'APP_DEBUG=false';
                    }
                    $updateStr = str_replace($newStr, $str, $originStr);
                    file_put_contents($path, $updateStr);
                } else {
                    if($key === 'ENV_EOL') {
                        $str = "\n";
                    } else {
                        $str = "\n" .$key . "=" . $value;
                    }
                    file_put_contents($path, $str, FILE_APPEND);
                }
            }
        }
        return true;
    }
}

/**
 * 获取IP
 * @return str
 */
if ( ! function_exists('lzs_ip'))
{    
    function lzs_ip()
    {
        static $realip;
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }
        return $realip;
    }
}

/**
 * 获取端口
 * @return str
 */
if ( ! function_exists('lzs_port'))
{    
    function lzs_port()
    {
        $port = isset($_SERVER["REMOTE_PORT"]) ? $_SERVER["REMOTE_PORT"] : '';
        return $port;
    }
}

/**
 * 防止跨站攻击
 * @return str
 */
if ( ! function_exists('lzs_removeXss'))
{    
    function lzs_removeXss($val)
    {
        $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);
        $search = 'abcdefghijklmnopqrstuvwxyz';
        $search.= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $search.= '1234567890!@#$%^&*()';
        $search.= '~`";:?+/={}[]-_|\'\\';
        for ($i = 0; $i < strlen($search); $i++) {
            $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val);
            $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val);
        }
        $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta','blink', 'link',  'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title');
        $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
        $ra = array_merge($ra1, $ra2);
        $found = true;
        while ($found == true) {
            $val_before = $val;
            for ($i = 0; $i < sizeof($ra); $i++) {
                $pattern = '/';
                for ($j = 0; $j < strlen($ra[$i]); $j++) {
                    if ($j > 0) {
                        $pattern .= '(';
                        $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
                        $pattern .= '|(&#0{0,8}([9][10][13]);?)?';
                        $pattern .= ')?';
                    }
                    $pattern .= $ra[$i][$j];
                }
                $pattern .= '/i';
                $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);
                $val = preg_replace($pattern, $replacement, $val);
                if ($val_before == $val) {
                    $found = false;
                }
            }
        }
        return $val;
    }
}

/**
 * 关键字高亮显示
 *
 * @param   string  $string     字符串
 * @param   string  $keyword    关键字
 * @return  string
 */
if ( ! function_exists('lzs_keyword_highlight'))
{
	function lzs_keyword_highlight($string, $keyword)
	{
	    return $keyword != '' ? str_ireplace($keyword, '<font color="red" class="keyword_highlight" >' . $keyword . '</font>', $string) : $string;
	}
}
/**
 * 随机颜色 **
 *
 * @return  string
 */
if ( ! function_exists('lzs_random_color'))
{
	function lzs_random_color()
	{
	    $str = '#';
	    for ($i = 0; $i < 6; $i++)
	    {
	        $randNum = rand(0, 15);
	        switch ($randNum)
	        {
	            case 10: $randNum = 'A';
	                break;
	            case 11: $randNum = 'B';
	                break;
	            case 12: $randNum = 'C';
	                break;
	            case 13: $randNum = 'D';
	                break;
	            case 14: $randNum = 'E';
	                break;
	            case 15: $randNum = 'F';
	                break;
	        }
	        $str.= $randNum;
	    }
	    return $str;
	}
}

/**
 * 汉字转为拼音
 *
 * @param	string	$word
 * @return	string
 */
if ( ! function_exists('lzs_word2pinyin'))
{
	function lzs_word2pinyin($word, $quanpin = true, $daxie = false, $trim = false, $szm = false) 
	{
        if($szm) {
            return substr(LzscmsPinYin::result($word, $quanpin, $daxie, $trim), 0, 1);
        }
        return LzscmsPinYin::result($word, $quanpin, $daxie, $trim);
	}
}

/**
 * 重写in_array
 *
 * @param int|string $value
 * @param array $array
 * @return bool
 */
if ( ! function_exists('lzs_inArray'))
{ 
	function lzs_inArray($value, $array) 
	{
		return is_array($array) && in_array($value, $array);
	}
}

/**
 * 页码转sql
 *
 * @param int $page 分页
 * @param int $perpage 每页显示数
 * @return array <1.start 2.limit>
 */
if ( ! function_exists('lzs_page2limit'))
{	
	function lzs_page2limit($page, $perpage = 10) 
	{
		$limit = intval($perpage);
		$start = max(($page - 1) * $limit, 0);
		return array($start, $limit);
	}
}

/**
 * 将字符串转换为数组
 *
 * @param	string	$data	字符串
 * @return	array
 */
if ( ! function_exists('lzs_str2array'))
{	
	function lzs_str2array($data) 
	{
		return $data ? (is_array($data) ? $data : @unserialize(stripslashes($data))) : array();
	}
}

/**
 * 将数组转换为字符串
 *
 * @param	array	$data	数组
 * @return	string
 */	
if ( ! function_exists('lzs_array2str'))
{	
	function lzs_array2str($data) 
	{
		return $data ? (!is_array($data) ? $data : addslashes(@serialize($data))) : '';
	}
}	

/**
 * 去除数组重复的
 *
 * @param	array	
 * @return	array
 */
if ( ! function_exists('lzs_array_unique'))
{	
	function lzs_array_unique($array)//写的比较好
	{
	   $out = array();
	   foreach ($array as $key=>$value) 
	   {
	       if (!in_array($value, $out))
	       {
	           $out[$key] = $value;
	       }
	   }
	   return $out;
	}
}

/**
 * 安全过滤函数
 *
 * @param $string
 * @return string
 */
if ( ! function_exists('lzs_safe_replace'))
{
	function lzs_safe_replace($string) 
	{
		$string = str_replace('%20', '', $string);
		$string = str_replace('%27', '', $string);
		$string = str_replace('%2527', '', $string);
		$string = str_replace('*', '', $string);
		$string = str_replace('"', '&quot;', $string);
		$string = str_replace("'", '', $string);
		$string = str_replace('"', '', $string);
		$string = str_replace(';', '', $string);
		$string = str_replace('<', '&lt;', $string);
		$string = str_replace('>', '&gt;', $string);
		$string = str_replace("{", '', $string);
		$string = str_replace('}', '', $string);
		return $string;
	}
}

/**
 * 清除HTML标记
 *
 * @param	string	$str
 * @return  string
 */
if ( ! function_exists('lzs_clearhtml'))
{
	function lzs_clearhtml($str) 
	{
		$str = str_replace(
			array('&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array(' ', '&', '"', "'", '"', '"', '—', '<', '>', '·', '…'), $str
		);
		$str = preg_replace("/\<[a-z]+(.*)\>/iU", "", $str);
		$str = preg_replace("/\<\/[a-z]+\>/iU", "", $str);
		$str = preg_replace("/{.+}/U", "", $str);
		$str = str_replace(array(chr(13), chr(10), '&nbsp;'), '', $str);
		$str = strip_tags($str);
		return trim($str);
	}
}

/**
 * Formats a numbers as bytes, based on size, and adds the appropriate suffix
 *
 * @param	mixed	will be cast as int
 * @param	int
 * @return	string
 */
if ( ! function_exists('lzs_byte_format'))
{
	function lzs_byte_format($num, $precision = 1) {
		if ($num >= 1000000000000) {
			$num = round($num / 1099511627776, $precision);
			$unit = 'TB';
		} elseif ($num >= 1000000000) {
			$num = round($num / 1073741824, $precision);
			$unit = 'GB';
		} elseif ($num >= 1000000) {
			$num = round($num / 1048576, $precision);
			$unit = 'MB';
		} elseif ($num >= 1000) {
			$num = round($num / 1024, $precision);
			$unit = 'KB';
		} else {
			$unit = 'Bytes';
			return number_format($num).' '.$unit;
		}
		return number_format($num, $precision).' '.$unit;
	}
}

/**
 * 检查目录权限
 *
 * @param	string	$pathfile
 * @return  string
 */
if ( ! function_exists('lzs_check_write_able'))
{
	function lzs_check_write_able($pathfile) 
	{
		if (!$pathfile) {
            return false;
        }
		$isDir = in_array(substr($pathfile, -1), array('/', '\\')) ? true : false;
		if ($isDir) {
			if (is_dir($pathfile)) {
				mt_srand((double) microtime() * 1000000);
				$pathfile = $pathfile . 'lzs_' . uniqid(mt_rand()) . '.tmp';
			} elseif (@mkdir($pathfile))  {
				return lzs_check_write_able($pathfile);
			} else {
				return false;
			}
		}
		@chmod($pathfile, 0777);
		$fp = @fopen($pathfile, 'ab');
		if ($fp === false) {
            return false;
        }
		fclose($fp);
		$isDir && @unlink($pathfile);
		return true;
	}
}

if ( ! function_exists('lzs_strLen'))
{
    /**
     * 求取字符串长度
     *
     * @param string $string
     * @param string $charset
     * @return string
     */
    function lzs_strLen($string, $charset = '')
    {
        return Lzsstring::strlen($string, $charset);
    }
}

if ( ! function_exists('lzs_buildContent'))
{
    /**
     * 内容替换/支持语音包
     *
     * @return string
     */
    function lzs_buildContent($content = '', $strReplaces = [])
    {
        $content = lzs_lang($content);
        if(!is_array($strReplaces)) {
            return $content;
        }
        $search = [];
        $replace = [];
        foreach ($strReplaces as $key => $value) {
            $search[] = '{'.$key.'}';
            $replace[] = $value;
        }
        return str_replace($search, $replace, $content);
    }
}

if ( ! function_exists('lzs_api_app'))
{
    /**
     * 
     */
    function lzs_api_app($appid = '')
    {
        $cacheName = 'Lzscms:api';
        if (!Cache::has($cacheName)) {
            $data = ApiModel::setCache();
        } else {
            $data = Cache::get($cacheName, []);
        }
        if($appid) {
            return isset($data[$appid]) ? $data[$appid] : [];
        }
        return $data;
    }
}

if ( ! function_exists('lzs_get_data'))
{
    function lzs_get_data($field = [], $data = [])
    {
        $LzscmsFields = new LzscmsFields();
        $obj = $LzscmsFields->get($field['fieldType']);
        if (!is_object($obj)) {
            return $data;
        }
        return $obj->output_data($data, $field);
    }
}

if ( ! function_exists('lzs_block'))
{
    function lzs_block($id = 0, $data = false)
    {
        if(!$id && $data == false) {
            return '';
        }
        if(!$id && $data != false) {
            return [];
        }
        return CommonBlockModel::showBlock($id, $data);
    }
}


if ( ! function_exists('lzs_is_mobile'))
{
    /**
     * 判断是否是移动端访问
     */
    function lzs_is_mobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return TRUE;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])) {
            return stristr($_SERVER['HTTP_VIA'], "wap") ? TRUE : FALSE;// 找不到为flase,否则为TRUE
        }
        // 判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array(
                'mobile',
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return TRUE;
            }
        }
        if (isset ($_SERVER['HTTP_ACCEPT'])) { // 协议法，因为有可能不准确，放到最后判断
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== FALSE) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === FALSE || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return TRUE;
            }
        }
        return FALSE;
    }
}

if ( ! function_exists('lzs_is_weixin'))
{
    function lzs_is_weixin() 
    { 
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true; 
        }
        return false; 
    }  
}

/**
 * 数组转树
 * @param type $list
 * @param type $root
 * @param type $pk
 * @param type $pid
 * @param type $child
 * @return type
 */
if ( ! function_exists('lzs_list_to_tree'))
{
    function lzs_list_to_tree($list, $root = 0, $pk = 'id', $pid = 'parentid', $child = '_child') 
    {
        // 创建Tree
        $tree = array();
        if (is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] = &$list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = 0;
                if (isset($data[$pid])) {
                    $parentId = $data[$pid];
                }
                if ($root == $parentId) {
                    $tree[] = &$list[$key];
                } else {
                    if (isset($refer[$parentId])) {
                        $parent = &$refer[$parentId];
                        $parent[$child][] = &$list[$key];
                    }
                }
            }
        }
        return $tree;
    }
}

if ( ! function_exists('lzs_encrypt'))
{
    function lzs_encrypt($value = '', $key = '', $serialize = false)
    {
        $key = lzs_key($key);
        $LzscmsEncrypter = new LzscmsEncrypter($key, config('app.cipher'));
        $str = $LzscmsEncrypter->encrypt($value, $serialize);
        if(!config('Lzscms.crypt')) {
            return $str;
        }
        $cacheName = 'crypt:'.md5($value.$key);
        Cache::forget($cacheName);
        Cache::forever($cacheName, $str);
        return md5($value.$key);
    }  
}

if ( ! function_exists('lzs_decrypt'))
{
    function lzs_decrypt($value = '', $key = '', $serialize = false)
    {
        $key = lzs_key($key);
        if(config('Lzscms.crypt')) {
            $cacheName = 'crypt:'.md5($value.$key);
            $value = Cache::get($cacheName, '');
        }
        if(!$value) {
            return lzs_message('The payload is invalid.', 'error');
        }
        $LzscmsEncrypter = new LzscmsEncrypter($key, config('app.cipher'));
        $str = $LzscmsEncrypter->decrypt($value, $serialize);
        return $str;
    }
}

if ( ! function_exists('lzs_key'))
{
    function lzs_key($key = '')
    {
        $key = $key ? $key : 'safe';
        $Salt = 'ChinesePublicSecurity';
        $keyLength = config('app.cipher') == 'AES-128-CBC' ? 16 : 32;
        $key = $keyLength == 32 ? md5($key.md5($Salt)) : substr(md5($key.md5($Salt)), 8, 16); 
        return $key;
    }  
}

if ( ! function_exists('lzs_encode'))
{
    /*
    * 加密解密方法
    *  $tmp1 = diy_encode('tex','key'); //加密
    *  $tmp2 = diy_encode($tmp1,'key','decode'); //解密
    */
    function lzs_encode($tex, $key = '', $type="encode")
    {
        $key = $key ? $key : '(@#$!$!$fgbcvnGHJKUX*(#$%^$%%*)(*)_$%fgbcvnGHJKUX@#*&*)(*_()*(O$%^$%SDF3456F$#^';
        $chrArr = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');
        if($type == "decode") {
            if(strlen($tex) < 14) {
                return false;
            }
            $verity_str = substr($tex, 0, 8);   //取前8位
            $tex = substr($tex, 8);
            if($verity_str != substr(md5($tex), 0, 8)) { //完整性验证失败
                return false;
            }
        }
        $key_b = $type == "decode" ? substr($tex, 0, 6) : $chrArr[rand()%62] . $chrArr[rand()%62] . $chrArr[rand()%62] . $chrArr[rand()%62] . $chrArr[rand()%62] . $chrArr[rand()%62];
        $rand_key = $key_b . $key;
        $rand_key = md5($rand_key);
        $tex = $type == "decode" ? base64_decode(substr($tex, 6)) : $tex;
        $texlen = strlen($tex);
        $reslutstr = "";
        for($i = 0; $i < $texlen; $i++) {
            $reslutstr .= $tex{$i}^$rand_key{$i%32};
        }
        if($type != "decode") {
            $reslutstr = trim($key_b.base64_encode($reslutstr), "==");
            $reslutstr = substr(md5($reslutstr), 0,8).$reslutstr;
        }
        return $reslutstr;
    }
}

if ( ! function_exists('lzs_base58_encode'))
{
    function lzs_base58_encode($string)
    {
        $alphabet = '123456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $base = strlen($alphabet);

        if (is_string($string) === false || !strlen($string)) {
            return false;
        }

        $bytes = array_values(unpack('C*', $string));
        $decimal = $bytes[0];
        for ($i = 1, $l = count($bytes); $i < $l; ++$i) {
            $decimal = bcmul($decimal, 256);
            $decimal = bcadd($decimal, $bytes[$i]);
        }
        $output = '';
        while ($decimal >= $base) {
            $div = bcdiv($decimal, $base, 0);
            $mod = bcmod($decimal, $base);
            $output .= $alphabet[$mod];
            $decimal = $div;
        }
        if ($decimal > 0) {
            $output .= $alphabet[$decimal];
        }
        $output = strrev($output);

        return (string) $output;
    }
}

if ( ! function_exists('lzs_base58_decode'))
{
    function lzs_base58_decode($base58)
    {
        $alphabet = '123456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $base = strlen($alphabet);

        if (is_string($base58) === false || !strlen($base58)) {
            return false;
        }
        $indexes = array_flip(str_split($alphabet));
        $chars = str_split($base58);
        foreach ($chars as $char) {
            if (isset($indexes[$char]) === false) {
                return false;
            }
        }
        $decimal = $indexes[$chars[0]];
        for ($i = 1, $l = count($chars); $i < $l; ++$i) {
            $decimal = bcmul($decimal, $base);
            $decimal = bcadd($decimal, $indexes[$chars[$i]]);
        }
        $output = '';
        while ($decimal > 0) {
            $byte = bcmod($decimal, 256);
            $output = pack('C', $byte).$output;
            $decimal = bcdiv($decimal, 256, 0);
        }
        return $output;
    }
}























