<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries\LeizhishangApi;

/**
 * Aip Base 基类
 */
class ApiBase {

    /**
     * 获取access token url
     * @var string
     */
    public $apiUrl = 'http://h.94dx.com/open/api/';


    public $signType = "MD5";
    /**
     * appId
     * @var string
     */
    public $appId = '';
    
    /**
     * secretKey
     * @var string
     */
    public $secretKey = '';

    public $methods = 'get';

    /**
     * @param string $appId 
     * @param string $apiKey
     * @param string $secretKey
     */
    public function __construct()
    {
        $this->client = new ApiHttpClient();
    }

    /**
     * 连接超时
     * @param int $ms 毫秒
     */
    public function setConnectionTimeoutInMillis($ms)
    {
        $this->client->setConnectionTimeoutInMillis($ms);
    }

    /**
     * 响应超时
     * @param int $ms 毫秒
     */
    public function setSocketTimeoutInMillis($ms)
    {
        $this->client->setSocketTimeoutInMillis($ms);
    }

    public function generateSign($data) 
    {
        $ApiSign = new ApiSign();
        $sign = $ApiSign->createSign($data, $this->secretKey);
        return $sign;
    }

    /**
     * 处理请求参数
     * @param  string $url
     * @param array $params
     * @param array $data
     * @param array $headers
     */
    protected function proccessRequest($url, &$params, &$data, $headers)
    {
    }

    /**
     * Api 请求
     * @param  string $url
     * @param  mixed $data
     * @return mixed
     */
    protected function request($url, $data, $headers=array())
    {
        try{
            $result = $this->validate($url, $data);
            if($result !== true) {
                return $result;
            }

            $params = array();
            // 特殊处理
            $this->proccessRequest($url, $params, $data, $headers);
            if($this->methods == 'get') {
                $response = $this->client->get($url, $data);
            } else {
                $response = $this->client->post($url, $data, $params);
            }
            $obj = $this->proccessResult($response['content']);
        }catch(Exception $e){
            return array(
                'error_code' => 'SDK108',
                'error_msg' => 'connection or read data timeout',
            );
        }
        return $obj;
    }

    /**
     * Api 多个并发请求
     * @param  string $url
     * @param  mixed $data
     * @return mixed
     */
    protected function multi_request($url, $data) 
    {
        try{
            $params = array();
            $authObj = $this->auth();
            $headers = $this->getAuthHeaders('POST', $url);

            if($this->isCloudUser === false){
                $params['access_token'] = $authObj['access_token'];
            }

            $responses = $this->client->multi_post($url, $data, $params, $headers);

            $is_success = false;
            foreach($responses as $response){
                $obj = $this->proccessResult($response['content']);

                if(empty($obj) || !isset($obj['error_code'])){
                    $is_success = true;
                }

                if(!$this->isCloudUser && isset($obj['error_code']) && $obj['error_code'] == 110){
                    $authObj = $this->auth(true);
                    $params['access_token'] = $authObj['access_token'];
                    $responses = $this->client->post($url, $data, $params, $headers);
                    break;
                }
            }

            if($is_success){
                $this->writeAuthObj($authObj);
            }

            $objs = array();
            foreach($responses as $response){
                $objs[] = $this->proccessResult($response['content']);
            }

        }catch(Exception $e){
            return array(
                'error_code' => 'SDK108',
                'error_msg' => 'connection or read data timeout',
            );
        }

        return $objs;
    }

    /**
     * 格式检查
     * @param  string $url
     * @param  array $data
     * @return mix
     */
    protected function validate($url, &$data){
        return true;
    }

    /**
     * 格式化结果
     * @param $content string
     * @return mixed
     */
    protected function proccessResult($content)
    {
        return json_decode($content, true);
    }

    public function execute($request, $returnUrl = false)
    {
        //组装系统参数
        $sysParams["appid"] = $this->appId;
        $sysParams["sign_type"] = $this->signType;
        $apiParams = array();
        //获取业务参数
        $apiParams = $request->getApiParas();
        $requestUrl = $request->bestUrl."?";
        //签名
        $sysParams["sign"] = $this->generateSign(array_merge($apiParams, $sysParams));
        foreach ($sysParams as $sysParamKey => $sysParamValue)
        {
            $requestUrl .= "$sysParamKey=" . urlencode($sysParamValue) . "&";
        }
        if($returnUrl) {
            return $this->client->buildUrl(trim($requestUrl, '&'), $apiParams);
        }
        $result = $this->request(trim($requestUrl, '&'), $apiParams);
        return $result;
    }
}
