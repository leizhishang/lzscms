<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries;

use Leizhishang\Lzscms\Libraries\LzscmsCurl;

class juhe {

	public $api = [
		'1'=>[
			'url'=>'http://apis.juhe.cn/ip/ip2addr', 
			'key'=>'90e1c2a5ad640c958d695b0283676656'
		],//IP地址	
		'11'=>[
			'url'=>'http://apis.juhe.cn/mobile/get', 
			'key'=>'8819fae2b37963f71482cd0441f1d3ac'
		],//手机号码归属地	
		'38'=>[
			'url'=>'http://apis.juhe.cn/idcard/index', 
			'key'=>'2f021188a4d147784461b1e562a60e25'
		],//身份证查询	
		'73'=>[
			'url'=>'http://op.juhe.cn/onebox/weather/query', 
			'key'=>'934a15bc98bc8aa0db758c7b1e6b4972'
		],//天气预报	
		'80'=>[
			'url'=>'http://op.juhe.cn/onebox/exchange/query', 
			'key'=>'443ca7d1ed882015d00e6fdedf21c249'
		],//汇率	
		'72'=>[
			'url'=>'http://op.juhe.cn/onebox/phone/query', 
			'key'=>'6dd8f5378921d38d4dd5c5d498b1dd52'
		],//手机固话来电显示	
		'161'=>[
			'url'=>'http://op.juhe.cn/baiduWeight/index', 
			'key'=>'59ebe5912ec71f6ef62ef4d58a357095'
		],//百度权重	
		'166'=>[
			'url'=>'http://japi.juhe.cn/qqevaluate/qq', 
			'key'=>'48869d2efe577305d721024c334d3dd4'
		],//QQ号码测吉凶	
		'82'=>[
			'url'=>'http://op.juhe.cn/onebox/bus/query', 
			'key'=>'10658aff9c233353849911f1d0900b6e'
		],//长途汽车信息	
		'135'=>[
			'url'=>'http://op.juhe.cn/189/bus/busline', 
			'key'=>'8e3adea3a4c389bf6e83eb08ba68df1b'
		],//全国公交及路径规划查询	
		'69'=>[
			'url'=>'http://japi.juhe.cn/charconvert/change.from', 
			'key'=>'ade3a063cef51ddc80462e6c87952d9c'
		],//简/繁/火星字体转换	
		'252'=>[
			'url'=>'http://v.juhe.cn/wepiao/query', 
			'key'=>'21031c03467e4c67adf962055ca03fe5'
		],//H5在线电影票	
		'134'=>[
			'url'=>'http://japi.juhe.cn/voice_words/getWords', 
			'key'=>'eda961a5155b60b9d39a683d44764491'
		],//语音识别		
		'103'=>[
			'url'=>'http://op.juhe.cn/idcard/query', 
			'key'=>'c0611f64f021a918d436a82515aeab80'
		],//身份证实名认证	
		'10201'=>[
			'url'=>'http://op.juhe.cn/huihu/query', 
			'key'=>'a20d571d3f44cd92fe32a495c32d93aa'
		],//双向回呼－发起回呼
		'10202'=>[
			'url'=>'http://op.juhe.cn/huihu/logs.php', 
			'key'=>'a20d571d3f44cd92fe32a495c32d93aa'
		],//双向回呼－通话清单
		'13501'=>[
			'url'=>'http://v.juhe.cn/flow/list', 
			'key'=>'2c7683b5e98c46f7cc0cb03793497e98'
		],//流量接口－全部流量套餐列表
		'13502'=>[
			'url'=>'http://v.juhe.cn/flow/telcheck', 
			'key'=>'2c7683b5e98c46f7cc0cb03793497e98'
		],//流量接口－检测号码支持的流量套餐
		'13503'=>[
			'url'=>'http://v.juhe.cn/flow/recharge', 
			'key'=>'2c7683b5e98c46f7cc0cb03793497e98'
		],//流量接口－提交流量充值
		'13504'=>[
			'url'=>'http://v.juhe.cn/flow/ordersbydate', 
			'key'=>'2c7683b5e98c46f7cc0cb03793497e98'
		],//流量接口－根据日期时间查询订单
		'13505'=>[
			'url'=>'', 
			'key'=>'2c7683b5e98c46f7cc0cb03793497e98'
		],//流量接口－状态回调配置
		'13506'=>[
			'url'=>'http://v.juhe.cn/flow/ordersta', 
			'key'=>'2c7683b5e98c46f7cc0cb03793497e98'
		],//流量接口－订单状态查询
		'4301'=>[
			'url'=>'http://v.juhe.cn/exp/index', 
			'key'=>'4e748d72dbc77548b234ff7c0aaa955e'
		],//常用快递－常用快递查询API
		'4302'=>[
			'url'=>'http://v.juhe.cn/exp/com', 
			'key'=>'4e748d72dbc77548b234ff7c0aaa955e'
		],//常用快递－快递公司编号对照表

	];
	public  $url = '';
	public  $dtype = 'json';
	public  $urlencode = true;

    public function __construct()
    {
    }

	public function setParams($id = 0, $params = array())
	{
		$api = isset($this->api[$id]) ? $this->api[$id] : array('url'=>'', 'key'=>'');
		$params['key'] = $api['key'];
		$params['dtype'] = $this->dtype;
		$this->url = $api['url'];
        if ($params && is_array($params)) {
            $params = http_build_query($params);
            if(strpos($this->url, '?') !== false) {
            	$this->url .= '&' . $params;
            } else {
            	$this->url .= '?' . $params;
            }
        }
	}

	public function get($apiid = 0, $params = array())
	{
		$this->setParams($apiid, $params);
		return $this->data();
	}

	public function post($apiid = 0, $post = array(), $params = array())
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
			return json_decode($data);
		} else {
			return lzs_xmlToArray($data);
		}
	}
}