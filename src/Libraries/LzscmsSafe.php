<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries;

/**
 * 程序安全类
 */
class LzscmsSafe {

	/**
	 * Md5加密
	 *
	 * @param string $str 源
	 * @param string $salt
	 * @return string
	 */
	public static function buildMd5($str, $salt) {
		return md5(md5($str) . $salt);
	}
	
	
	/**
	 * 安全问题加密
	 *
	 * @param string $question
	 * @param string $answer

	 * @return bool
	 */
	public static function buildQuestion($question, $answer) {
		return substr(md5($question . $answer), 8, 8);
	}
	
	public static function appKey($apiId, $time, $secretkey, $get, $post) {
		// 注意这里需要加上__data，因为下面的buildRequest()里加了。
		$array = array('uckey', 'clientid', 'time', '_json', 'jcallback', 'csrf_token',
					   'Filename', 'Upload', 'token', '__data');
		$str = '';
		ksort($get);
		ksort($post);
		foreach ($get AS $k=>$v) {
			if (in_array($k, $array)) continue;
			$str .=$k.$v;
		}
		foreach ($post AS $k=>$v) {
			if (in_array($k, $array)) continue;
			$str .=$k.$v;
		}
		return md5(md5($apiId.'||'.$secretkey).$time.$str);
	}
}