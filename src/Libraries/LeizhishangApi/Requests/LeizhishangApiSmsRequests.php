<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries\LeizhishangApi\Requests;

use Leizhishang\Lzscms\Libraries\LeizhishangApi\apiBase;

class LeizhishangApiSmsRequests
{
	private $apiBase ;

	public $bestUrl = 'sms/';
	protected $apiParas = [];

	public function __construct(apiBase $apiBase) 
	{
		$this->apiBase = $apiBase;
	}

	public function sendMessage() 
	{
		$this->bestUrl = $this->apiBase->apiUrl.$this->bestUrl.'send';
		$this->apiParas['param'] = str_replace(' ', '%20', $this->apiParas['param']);
		return $this;
	}

	public function getInfo() 
	{
		$this->bestUrl = $this->apiBase->apiUrl.$this->bestUrl.'getInfo';
		return $this;
	}

	public function getSurplus() 
	{
		$this->bestUrl = $this->apiBase->apiUrl.$this->bestUrl.'getSurplus';
		return $this;
	}

	public function getStatus() 
	{
		$this->bestUrl = $this->apiBase->apiUrl.$this->bestUrl.'getStatus';
		return $this;
	}

	public function pay() 
	{
		$this->bestUrl = $this->apiBase->apiUrl.$this->bestUrl.'pay';
		return $this;
	}

	public function setAmount($v)
	{
		$this->apiParas['amount'] = $v;
		return $this;
	}

	public function setRemark($v)
	{
		$this->apiParas['remark'] = $v;
		return $this;
	}

	public function setSignid($v)
	{
		$this->apiParas['signid'] = $v;
		return $this;
	}

	public function setTplid($v)
	{
		$this->apiParas['tplid'] = $v;
		return $this;
	}

	public function setMobile($v)
	{
		$this->apiParas['mobile'] = $v;
		return $this;
	}

	public function setParam($v)
	{
		if(is_array($v)){
			$v = json_encode($v);
		}
		$this->apiParas['param'] = $v;
		return $this;
	}

	public function setIp($v)
	{
		$this->apiParas['ip'] = $v;
		return $this;
	}

	public function setId($v)
	{
		$this->apiParas['id'] = $v;
		return $this;
	}

	public function setType($v)
	{
		$this->apiParas['type'] = $v;
		return $this;
	}

	public function getApiParas()
	{
		return $this->apiParas;
	}

	//响应代码**
	public function Msg($staus) {
		$_arr=array(
			'-1'=>'签权失败',
			'-2'=>'未检索到被叫号码',
			'-3'=>'被叫号码过多',
			'-4'=>'内容未签名',
			'-5'=>'内容过长',
			'-6'=>'余额不足',
			'-7'=>'暂停发送',
			'-8'=>'保留',
			'-9'=>'定时发送时间格式错误',
			'-10'=>'下发内容为空',
			'-11'=>'账户无效',
			'-12'=>'Ip地址非法',
			'-13'=>'操作频率快',
			'-14'=>'操作失败',
			'-15'=>'展码无效(1-999)',
			'-20'=>'模板不存在',
			'-21'=>'模板不合法',
			'-22'=>'签名不合法',
			'-23'=>'手机号码格式错误',
			'-24'=>'短信模板变量缺少参数',
			'-25'=>'参数异常',
			'-26'=>'签名不存在',
			'-27'=>'触发业务流控',
			'-30'=>'充值金额为空',
			'-41'=>'发送记录不存在',
			'0'=>'发送成功'
		);
		if(!isset($_arr[$staus])) {
			return false;
		}
		return $_arr[$staus];	
	}

}
