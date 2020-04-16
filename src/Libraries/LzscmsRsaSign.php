<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries;

class LzscmsRsaSign {

	private static $PRIVATE_KEY = '';

    private static $PUBLIC_KEY  = '';

    public function setPrivateKey($key = '') 
    {
        self::$PRIVATE_KEY = $key;
        return $this;
    }

    public function setPublicKey($publicKey = '') 
    {
        self::$PUBLIC_KEY = $publicKey;
        return $this;
    }

    /**
     * 获取私钥
     * @return bool|resource
     */
    private static function getPrivateKey()
    {
        $privKey = self::$PRIVATE_KEY;
        return openssl_pkey_get_private($privKey);
    }

    /**
     * 获取公钥
     * @return bool|resource
     */
    private static function getPublicKey()
    {
        $publicKey = self::$PUBLIC_KEY;
        return openssl_pkey_get_public($publicKey);
    }

    /**
     * 创建签名
     * @param string $data 数据
     * @return null|string
     */
    public function createSign($data = '')
    {
        if (!is_string($data)) {
            return null;
        }
        return openssl_sign(
                    $data,
                    $sign,
                    self::getPrivateKey(),
                    OPENSSL_ALGO_SHA256
                  ) ? base64_encode($sign) : null;
    }    

    /**
     * 验证签名
     * @param string $data 数据
     * @param string $sign 签名
     * @return bool
     */
    public function verifySign($data = '', $sign = '')
    {
        if (!is_string($sign) || !is_string($sign)) {
            return false;
        }
        return (bool)openssl_verify(
                      $data,
                      base64_decode($sign),
                      self::getPublicKey(),
                      OPENSSL_ALGO_SHA256
                    );
    }
}