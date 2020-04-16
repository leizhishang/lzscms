<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries\LeizhishangApi;

class ApiMd5Sign
{

	private static $PRIVATE_KEY = '';

	private static $SECRET_KEY;

	public function setSecretKey($key = '') 
	{
        self::$SECRET_KEY = $key;
        return $this;
	}
	
    private static function getSecretKey()
    {
        $secretKey = trim(self::$SECRET_KEY);
        return $secretKey;
    }
	
	public function setPrivateKey($key = '') 
	{
        self::$PRIVATE_KEY = $key;
        return $this;
	}
    /**
     * 获取私钥
     * @return bool|resource
     */
    private static function getPrivateKey()
    {
        $privKey = self::$PRIVATE_KEY;
        return $privKey;
    }

	/**
	 * 签名字符串
	 * @param $data 需要签名的字符串数据
	 * @param $key 私钥
	 * return 签名结果
	 */
	public function createSign($data)
	{
		$data = $data . self::getSecretKey() . self::getPrivateKey();
		return md5($data);
	}

	/**
	 * 验证签名
	 * @param $prestr 需要签名的字符串数据
	 * @param $sign 签名结果
	 * @param $key 私钥
	 * return 签名结果
	 */
	public function verifySign($data, $sign) 
	{
		$data = $data . self::getSecretKey() . self::getPrivateKey();
		$vsgin = md5($data);
		if($vsgin == $sign) {
			return true;
		} else {
			return false;
		}
	}
	
}