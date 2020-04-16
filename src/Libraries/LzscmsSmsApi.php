<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries;

use Leizhishang\Lzscms\Libraries\LeizhishangSmsApi;
use Leizhishang\Lzscms\Libraries\LeizhishangApi\ApiBase;
use Leizhishang\Lzscms\Libraries\LeizhishangApi\Requests\LeizhishangApiSmsRequests;

class LzscmsSmsApi
{
	protected $smsConfig = [];

	protected $LeizhishangSmsApi;

	public function __construct($config = []) 
	{
		$this->smsConfig = lzs_config('sms');
		$this->LeizhishangSmsApi = new ApiBase();

		$this->LeizhishangSmsApi->appId = isset($this->smsConfig['hstsmsappid']) ? $this->smsConfig['hstsmsappid'] : '';
		$this->LeizhishangSmsApi->secretKey = isset($this->smsConfig['hstsmskey']) ? $this->smsConfig['hstsmskey'] : '';

		if(isset($config['appId'])) {
			$this->LeizhishangSmsApi->appId = $config['appId'];
		}

		if(isset($config['secretKey'])) {
			$this->LeizhishangSmsApi->secretKey = $config['secretKey'];
		}

		if(isset($config['signId'])) {
			$this->smsConfig['hstsmssign'] = $config['signId'];
		}
		$this->LeizhishangSmsApi->rsaPublicKey = '';
		$this->LeizhishangSmsApi->rsaPrivateKey = '';
		$this->LeizhishangSmsApi->signType = 'MD5';
	}

	public function sendMobileMessage($mobile, $content, $param = []) 
	{
		$request = new LeizhishangApiSmsRequests($this->LeizhishangSmsApi);
		$request->setSignid($this->smsConfig['hstsmssign']);
		$request->setTplid($content);
		$request->setMobile($mobile);
		$request->setParam($param);
		$request->sendMessage();
		$result = $this->LeizhishangSmsApi->execute($request);
		if($result['code'] != 0) {
			return lzs_message($result['message']);
		}
		return $result;
	}

	public function getSurplus() 
	{
		$request = new LeizhishangApiSmsRequests($this->LeizhishangSmsApi);
		$request->getSurplus();
		$result = $this->LeizhishangSmsApi->execute($request);
		return $result;
	}

	public function getPay($money, $note = '') 
	{
		$request = new LeizhishangApiSmsRequests($this->LeizhishangSmsApi);
		$request->setAmount($money);
		$request->pay();
		$result = $this->LeizhishangSmsApi->execute($request, true);
		return $result;
	}

	public function getStatus($rtype, $requestid = '') 
	{
		$request = new LeizhishangApiSmsRequests($this->LeizhishangSmsApi);
		$request->setId($requestid);
		$request->setType($rtype);
		$request->getStatus();
		$result = $this->LeizhishangSmsApi->execute($request);
		if($result['state'] != 0) {
			return lzs_message($result['message']);
		}
		return $result;
	}

}

