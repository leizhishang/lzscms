<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries\Juhe;

use Leizhishang\Lzscms\Libraries\LzscmsCurl;

class JuheApi {

	public  $url = '';
	public  $key = '';
	public  $dtype = 'json';
	public  $urlencode = true;

    public function __construct($url, $key = '')
    {
    	$this->url = $url;
    	$this->key = $key;
    }

	public function setParams($params = array())
	{
		$params['key'] = $this->key;
		$params['dtype'] = $this->dtype;
        if ($params && is_array($params)) {
            $params = http_build_query($params);
            if(strpos($this->url, '?') !== false) {
            	$this->url .= '&' . $params;
            } else {
            	$this->url .= '?' . $params;
            }
        }
	}

	public function get($params = array())
	{
		$this->setParams($params);
		return $this->data();
	}

	public function post($post = array(), $params = array())
	{
		$this->setParams($apiid, $params);
		return $this->data($post);
	}

	public function data($post = array())
	{
		$cUrl = new LzscmsCurl();
		$cUrl->url = $this->url;
		if($post){
			$cUrl->post($post);
		} else {
			$cUrl->get();
		}
		$data = $cUrl->data(false);
		if($this->dtype == 'json') {
			return json_decode($data, true);
		} else {
			return Lzs_xmlToArray($data);
		}
	}
}