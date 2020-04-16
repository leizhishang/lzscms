<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries\LeizhishangApi;

class ApiSign 
{
    public function createSign($para_temp, $secretKey = '', $privateKey = '', $publicKey = '')
    {
        $prestr = $para_temp;
        if(is_array($para_temp)) {
            //除去待签名参数数组中的空值和签名参数
            $para_filter = $this->paraFilter($para_temp);
            //对待签名参数数组排序
            $para_sort = $this->argSort($para_filter);
            //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
            $prestr = $this->createLinkstring($para_sort);
        }
        
        $sign = "";
        switch (strtoupper(trim($para_temp['sign_type']))) {
            case "MD5" :
                $ApiMd5Sign = new ApiMd5Sign();
                $ApiMd5Sign = $ApiMd5Sign->setSecretKey($secretKey);
                $ApiMd5Sign = $ApiMd5Sign->setPrivateKey($privateKey);
                $sign = $ApiMd5Sign->createSign($prestr);
                break;
            case "RSA2" :
                $ApiRsaSign = new ApiRsaSign();
                $ApiRsaSign = $ApiRsaSign->setPrivateKey($privateKey);
                $ApiRsaSign = $ApiRsaSign->setPublicKey($publicKey);
                $sign = $ApiRsaSign->createSign($prestr);
                break;
            default :
                $sign = "";
        }
        return $sign;
    }

    /**
     * 获取返回时的签名验证结果
     * @param $para_temp 数据数组
     * @param $sign 返回的签名结果
     * @return 签名验证结果
     */
    public function verifySign($para_temp, $secretKey = '', $privateKey = '', $publicKey = '') {
        $prestr = $para_temp;
        if(is_array($para_temp)) {
            //除去待签名参数数组中的空值和签名参数
            $para_filter = $this->paraFilter($para_temp);
            //对待签名参数数组排序
            $para_sort = $this->argSort($para_filter);
            //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
            $prestr = $this->createLinkstring($para_sort);
        }
        
        $isSgin = false;
        switch (strtoupper(trim($para_temp['sign_type']))) {
            case "MD5" :
                $apiMd5Sign = new ApiMd5Sign();
                $apiMd5Sign = $apiMd5Sign->setSecretKey($secretKey);
                $apiMd5Sign = $apiMd5Sign->setPrivateKey($privateKey);
                $isSgin = $apiMd5Sign->verifySign($prestr, $para_temp['sign']);
                break;
            case "RSA2" :
                $apiRsaSign = new ApiRsaSign();
                $apiRsaSign = $apiRsaSign->setPrivateKey($privateKey);
                $apiRsaSign = $apiRsaSign->setPublicKey($publicKey);
                $isSgin = $apiRsaSign->verifySign($prestr, $para_temp['sign']);
                break;
            default :
                $isSgin = false;
        }
        return $isSgin;
    }

    /**
     * 除去数组中的空值和签名参数
     * @param $para 签名参数组
     * return 去掉空值与签名参数后的新签名参数组
     */
    public function paraFilter($para) 
    {
        $para_filter = array();
        foreach ($para as $key => $val) {
            if($key == "sign" || $key == "sign_type" || $val == "") continue;
            else    $para_filter[$key] = $para[$key];
        }
        return $para_filter;
    }

    /**
     * 对数组排序
     * @param $para 排序前的数组
     * return 排序后的数组
     */
    public function argSort($para) {
        ksort($para);
        reset($para);
        return $para;
    }
	
    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * @param $para 需要拼接的数组
     * return 拼接完成以后的字符串
     */
    public function createLinkstring($para) 
    {
        $arg  = "";
        while (list ($key, $val) = each ($para)) {
            $arg.=$key."=".$val."&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);
        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
        return $arg;
    }
}