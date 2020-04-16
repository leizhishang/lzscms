<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries;

use Cache;
/**
 * @param $url 网址
 * @param bool $params 请求参数
 * @param int $post 请求方式
 * @param int $https https协议
 * @return bool|mixed
 */

class LzscmsCurl {

	public $userAgent = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36';
	public $url = '';
    public $https = false;             //是否https模式
    public $debug = false;             //是否调试模式
    public $httpInfo = array();
	public $cookie = '';               //1=>获取,2=>设置,3=>又设置又获取
	public $cookiePath = '';           //cookie 存储位置
	public $cookieContent = '';        //要设置cookie的内容
	public $cookieData = [];           //获取到的cookie数据  array
	public $cookieDatas = [];          //本地附加cookie数据  array
    public $header = '';                //请求头内容
    public $httpCode = 200;             //状态码
    public $response = '';              //响应
    public $isHeaders = false;          //是否获取响应头数据
    public $onlyHeaders = false;        //只返回响应头
    public $headersSize = 0;            //响应头大小
    public $headers = '';               //响应头内容

    public function __construct()
    {
        if(!function_exists('curl_init')){
        	logger('no curl');
        }
    }

	public function setParams($params = array())
	{
        if ($params && is_array($params)) {
            $params = http_build_query($params);
            if(strpos($this->url, '?') !== false) {
            	$this->url .= '&' . $params;
            } else {
            	$this->url .= '?' . $params;
            }
        }
	}

    public function setHeader($header = array()) 
    {
        $headers = [];
        foreach ($header as $key => $value) {
            $headers[] = $key.":".$value;
        }
        $this->header = $headers;
    }

    public function get($params = array())
    {
    	$this->setParams($params);
    	return $this->curl($this->url);
    }

    public function post($postData = array(), $params = array())
    {
    	$this->setParams($params);
    	return $this->curl($this->url, $postData);
    }

    public function curl($url, $postData = array())
    {
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);              //ua 信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                     //
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);                       //
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);                              //超时时间
        if($this->onlyHeaders){
            curl_setopt($ch, CURLOPT_NOBODY, true);                          //设置true为只获取请求头
        }
        if ($this->https) {                                                 //HTTPS 模式
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);                // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);                // 从证书中检查SSL加密算法是否存在
        }
        if ($postData) {                                                    //POST 方式
            curl_setopt($ch, CURLOPT_POST, true);                           //开启post
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);                //post data 数据
        }
        curl_setopt($ch, CURLOPT_URL, $url);                                //设置请求url地址
        if($this->cookie === 2 || $this->cookie === 3) {                    //设置cookie
        	$this->cookie('get');
        	if($this->cookieContent) {
        		curl_setopt($ch, CURLOPT_COOKIE, $this->cookieContent);
        	}
        }
        if($this->header){                                                  //开启请求头
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);            //
        }
        if($this->cookie === 1 || $this->cookie === 3 || $this->isHeaders) {
        	curl_setopt($ch, CURLOPT_HEADER, true);                        //将头文件的信息作为数据流输出
        }
        $this->response = curl_exec($ch);                                   //执行
        if ($this->response === FALSE) {
        	if($this->debug) {
        		echo "cURL Error: " . curl_error($ch);
        		logger("cURL Error: " . curl_error($ch));
        	}
            return false;
        }
        if($this->isHeaders) {
            $this->headersSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);   //得到请求头大小
            $this->headers = substr($this->response, 0, $this->headersSize);//得到请求头内容
        }
        $this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);            //请求状态码
        $this->httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        if($this->cookie === 1 || $this->cookie === 3) {
        	$this->cookie('save', $this->response);
        }
        curl_close($ch);
        return $this;
    }

    public function data($json = true)
    {
        if($this->cookie || $this->isHeaders) {
            $data = substr($this->response, $this->headersSize);
        } else {
            $data = $this->response;
        }
        if($this->onlyHeaders) {
            $data = "{}";
        }
    	if($json){
    		return json_decode($data, true);
    	} else {
    		return $data;
    	}
    }

    public function headers($array = false)
    {
        if($array) {
            $headers = explode("\n", $this->headers);
            return $headers;
        }
        return $this->headers;
    }

    public function cookie($type = 'save', $v = '', $v2 = '') 
    {
    	$parseUrl = parse_url($this->url);
    	$cacheName = md5($parseUrl['host']);
    	$cacheDataName = $parseUrl['host'].'data';
    	if($type == 'save') {
			preg_match_all('/Set-Cookie:(.*);/iU', $v, $cookies); //正则匹配
			if($cookies[1]) {
				foreach ($cookies[1] as $key => $value) {
					$values = explode('=', $value);
					$this->cookieData[trim($values[0])] = trim($values[1]);
				}
			}
    		Cache::forever($cacheDataName, $this->cookieData);
    	} else if($type == 'add') {
    		$this->cookieDatas[$v] = $v2;
    	} else if($type == 'get') {
    		$this->cookieData = Cache::get($cacheDataName);
    		if($this->cookieDatas) {
    			$this->cookieData = array_merge($this->cookieData, $this->cookieDatas);
    		}
    		$cookieContent = '';
    		foreach ($this->cookieData as $key => $value) {
    			 $cookieContent .= $key.'='.$value.';';
    		}
    		if(!$this->cookieContent) {
    			$this->cookieContent = trim($cookieContent, ';');
    		}
    		if($v) {
    			return isset($this->cookieData[$v]) ? $this->cookieData[$v]: '';
    		}
    	}
    	return $this;
    }

    public function getHttpInfo($k = '')
    {
    	if($k) {
    		return isset($this->httpInfo[$k]) ? $this->httpInfo[$k] : '';
    	}
    	return isset($this->httpInfo[$k]) ? $this->httpInfo[$k] : [];
    }
}