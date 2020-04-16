<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Leizhishang\Lzscms\Libraries\LzscmsSms;
use Leizhishang\Lzscms\Libraries\LzscmsCurl;
use Leizhishang\Lzscms\Libraries\LzscmsEditerCode;
use Uuid;
use Log;
use Leizhishang\Lzscms\Libraries\LzscmsFields;
use Leizhishang\Lzscms\Model\CommonFieldsModel;

use Leizhishang\Lzscms\Libraries\LzscmsSign;
use Leizhishang\Lzscms\Libraries\LzsError;

use Leizhishang\Lzscms\Libraries\LzscmsError;
use Leizhishang\Lzscms\Libraries\LzscmsUpload;
use Leizhishang\Lzscms\Libraries\LzscmsStorage;

use Illuminate\Support\Facades\Artisan;
use Leizhishang\Lzscms\Libraries\LzscmsDb;
use Illuminate\Database\Schema\Blueprint;

use Leizhishang\Lzscms\Model\CommonFormModel;
use Leizhishang\Lzscms\Model\CommonAreaModel;

use JPush\Client as JPush;

use Illuminate\Http\Request;
/**
* 
*/
class TestController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function api(Request $request) 
    {
        $appid = '1804721386';
        $Secret = '0hgpmr73r63yvzrnwvycabmezlqzzfvk';
        //$uri = 'hstpay/verify/zf/password';
        $uri = 'hstim/user/card';
        // $money = 0.6;
        // echo round($money*6/100, 2).'---';
        // echo round(round(round($money*6/100, 2) - $money * 10 / 1000, 2) * 20 /100, 2).'---';
        // echo round(round(round($money*6/100, 2) - $money * 10 / 1000, 2) * 20 /100, 2).'---';
        // echo round(round(round($money*6/100, 2) - $money * 10 / 1000, 2) * 20 /100, 2).'---';
        // echo round(round(round($money*6/100, 2) - $money * 10 / 1000, 2) * 20 /100, 2).'---';
        // echo round(round(round($money*6/100, 2) - $money * 10 / 1000, 2) * 20 /100, 2).'---';
        // exit;
        $me = 'get';
        $data = [
            'uid'=>142,
            'company_name'=>'company_name',
            'keywords'=>'华思',
             'order_id'=>'10181119-143127-674888',
             'ocode'=>'10181213-124645-682903',
             'sn'=>'99181212105334319445',
             'content'=>'contents',
             'mark'=>3,
            // 'page'=>1,
            // 'albums'=>'222',
             'phone'=>'18664597716',
            'isban'=>1,
            'minute'=>0,
            'groupId'=>5,
            'name'=>'大竹面s',
            'uids'=>'33,233,444,33333',
            // 'address'=>'大竹华联',m',
            // 'pay_name'=>'杨周',
            'bmsidkey'=>'479',
            'oldpassword'=>'e10adc3949ba59abbe56e057f20f883e',
            'password'=>'e10adc3949ba59abbe56e057f20f883e',
            // 'category_id'=>47,
            // 'uid'=>6,
            // 'friends_uid'=>6,
            // 'black_uid'=>6,
            // 'remarks_name'=>'理由为',
            // 'status'=>1,
            // 'bmsidkey'=>'1271',
             'idkey'=>'a87c306dHo9XyGAgEJ',
            'money'=>'0.01',
            'payType'=>'walletPay',
            'zfpassword'=>'2a4600253VokdZUwlcAlhWUwFfWlNRBAYFVlMGAAZSCgwBV1YGB10FWgYYCVEFVVYACg1aUQ', //md5('123456'),
            // 'ocode'=>'10181123-141255-893105',
            // 'orderby'=>'distance',
            // 'lng'=>'114.032878',
            // 'lat'=>'22.649264',
            // 'orderbys'=>'asc',
            //'remark'=>'一早就送',
            //'pstype'=>1,
            // 'goods'=>json_encode([
            //     [
            //         'id'=>'2707',
            //         'number'=>2
            //     ],
            //     [
            //         'id'=>'2708',
            //         'number'=>3
            //     ],
            //     [
            //         'id'=>'2710',
            //         'number'=>4
            //     ]
            // ]),
            //'addresIdkey'=>'21',
            //'ocode'=>'10181126-055826-496028',

            // 'realname'=>'刘洋',
            // 'alipayAccount'=>'yzhou91@163.com',
            // 'money'=>'0.2',
            // 'module'=>'company',
            // 'info_id'=>'479',
            // 'invitings'=>'07806882',
            // 'card_no'=>'6226370018620973',
            // 'bank_name'=>'中国工商银行',
            // 'card_type'=>'贷记卡(个普)',
            // 'bank_logo'=>'http://images.juheapi.com/banklogo/1.jpg',
            // 'bank_tel'=>'95588',
            // 'realname'=>'杨周',
            'mobile'=>'18664597716',
            //'ukey'=>'bdb097bcYSVCEFBw',
            // 'idcard'=>'513029199107034179'
            // 'uid'=>'206',
            //'data'=>json_encode(['nickName'=>'您好'])
            // 'mobile'=>'18664597716',
            // 'code'=>'074989',
            // 'invitings'=>'18664597716',
            // 'oldpassword'=>md5('a123456++'),
            // 'password'=>md5('Aa123456'),
            // 'type'=>'login',
            // 'province'=>'广东省',
            // 'city'=>'深圳市',
            // 'area'=>'罗湖区',
            // 'id'=>'130000',
            // 'module'=>'live',
            // 'mid'=>'479',
            // 'order_id'=>'10181108-160515-797750',
            // 'bms_id'=>'479',
            // 'content'=>'440300',
            // 'mark'=>'5'
            'provinceid'=>'440000',
            'cityid'=>'440300',
            'areaid'=>'440303',
            'name'=>'测试周',
            'mobile'=>'18578787878',
            'address'=>'家里蹲',
            // 'isdefault'=>1,
        ];
        $lzscmsSign = new LzscmsSign();
        $sign = $lzscmsSign->createSign($data, $Secret);
        $data['sign'] = $sign;
        $data['sign_type'] = 'MD5';
        $lzscmsCurl = new LzscmsCurl();
        $lzscmsCurl->url = url('api/'.$uri);
        $lzscmsCurl->isHeaders = true;
        $lzscmsCurl->setHeader([
            'appid'=>$appid,
            'platformenum'=>'android',
            'provinceid'=>440000,
            'cityid'=>440300,
            //'token'=>'2aaf56ebDTe0Z9UgJXTVJVAVtGWENOUFEHAQMCVwEAUA',
            //'token'=>'8c5bb89dOv3EX7A1AKSANXAwtUVQYDAVEEBgpbAghaBlIHU1ZcVlcAAVsCBQtWSFUEB1EFBlNVBwc'
             //'token'=>'601bb571LXftcWUUVZAFJYFw1CGQJUAgUOUFQGBQQ',
            //'token'=>'d27c6a49tAHv2nAUsDU1AORVgQTgIBA1YEV1UACwo',//18664597716
            // 'token'=>'5b87f855yD3cpIAR4HWgdfEVlMHQFXUgsCBFMCAwI'
            'token'=>'95a54d04fs5Yx0DFMKSQJaBV0XWU0ZAARWUAADUwFQAg'
        ]);
        if($me == 'get') {
            $LzscmsCurl->get($data);
        } else if($me == 'post') {
            $LzscmsCurl->post($data);
        }
        $result = $LzscmsCurl->data(true);
        print_r($LzscmsCurl->headers());
        echo $LzscmsCurl->data(false).PHP_EOL.PHP_EOL;
        print_r($result);
    }

    public function index(Request $request) 
    {
        $data = [
            [
                'text'=>'测试1',
                'item'=>json_encode(['id'=>2])
            ],
            [
                'text'=>'测试2',
                'item'=>json_encode(['id'=>2])
            ],
            [
                'text'=>'测试3',
                'item'=>json_encode(['id'=>2])
            ],
            [
                'text'=>'测试4',
                'item'=>json_encode(['id'=>2])
            ],
            [
                'text'=>'测试5',
                'item'=>json_encode(['id'=>2])
            ],
            [
                'text'=>'测试6',
                'item'=>json_encode(['id'=>2])
            ]
        ];
        $this->addMessage($data, 'data');
        return $this->showMessage('success');
        $app_key = 'cedd1bb8ddaaf0a7cd6d60de';
        $master_secret = '2a8032d4bdbdb10d5ed2c4a5';
        $client = new JPush($app_key, $master_secret);
        $push = $client->push();
        $push->setPlatform('all');
        $push->addAllAudience();
        $push->setNotificationAlert('alert');
        $push->message('Hello Softgold');
        $push->send();
        // CommonAreaModel::setCacheSubByAreaid(0);
        //$citys = CommonAreaModel::getInfo('110000');
        //print_r($citys);
        // $LzscmsCurl->isHeaders = true;
        // $LzscmsCurl->setHeader([
        //     'appid'=>'1801788022'
        // ]);
        // $LzscmsCurl->get();

        // $result = $LzscmsCurl->data(true);
        // print_r($LzscmsCurl->headers());
        // print_r($LzscmsCurl->data());
        // print_r($result);

        //$str = "Name: <pw>PHP</pw> <br> Title: [pw]3242423[/pw]";
        // preg_match_all ("/<pw>(.*)<\/pw>/U", $str, $arr);
        // print_r($arr[1]);
        // $replace = [];
        // foreach ($arr[1] as $value) {
        //     $replace[] = '<span class="J_pw" data-pw="'.Lzs_encrypt($value, '2222').'">点击查看</span>';
        // }
        // $str = str_replace($arr[0], $replace, $str);
        // $LzscmsEditerCode = new LzscmsEditerCode($str);
        // $LzscmsEditerCode->createContent();
        // $str = $LzscmsEditerCode->getContent();
        //echo base64_decode('NFduS2twUnhFeWFyVDJmQ2FheUhDQjJUcjc4TnliNDQ=');
        // echo config('app.cipher');
        // echo openssl_cipher_iv_length('AES-256-CBC');
        // echo strlen(base64_decode('NFduS2twUnhFeWFyVDJmQ2FheUhDQjJUcjc4TnliNDQ=', true)) === openssl_cipher_iv_length(config('app.cipher'));
        // echo base64_decode('Zk5mZkpGOHR6eTIzajQ4RQ==', true);
        // echo strlen(base64_decode('Zk5mZkpGOHR6eTIzajQ4RQ==', true)) === openssl_cipher_iv_length(config('app.cipher'));
        // echo base64_decode('Cr7XZOIQOrf5nrnblHdYBQ==');
        //echo $str = Lzs_encrypt('222');

        //exit;
        //echo Lzs_decrypt('eyJpdiI6ImpZNk9Rb2ZMaCtKMVBRM3Z1QXkxNGc9PSIsInZhbHVlIjoiNDR0RkpDcHhwWmlWYWV3WHJLOHZpQT09IiwibWFjIjoiM2M5NzkxYmNmNzcxMmJjMzlhZWIyYzRmMGY4MDMyYmE1YjhkODkwMzRhZjk1MmMwODlhYmIzNmE4YWE0MmRjOCJ9', 'Lzscms2018s++');
        //return $this->showError('当前属于非法操作');
        //         $a1=array("red"=>array("red","green"));
        // $a2=array("red"=>array("blue","yellow"));
        // print_r(array_merge($a1,$a2));
        //echo Lzs_word2pinyin('厦门', false, true, false, true);
        ///print_r(CommonAreaModel::getInfoByAreaid(5303, true));
        //return CommonAreaModel::getSubByAreaid(0)->toJson();
        // $slug = 'test';
        //     Artisan::call('module:migrate:refresh', [
        //         'slug'=>$slug,
        //         '--pretend'=>true
        //     ]);
        //  Artisan::call('hook:cache', [
        //     '--p'=>'Modules/'.ucfirst($slug),
        //     '--f'=>'app'
        // ]);
        //echo Lzs_image_resize(231, ['width'=>100, 'height'=>100, 'type'=>'force']);
        // $LzscmsSign = new LzscmsSign();
        // $appid = 1819337410;
        // $data = [
        //     'appid'=>$appid,
        //     'name'=>232424
        // ];
        // $appInfo = Lzs_api_app($appid);
        // $sign = $LzscmsSign->createSign($data, $appInfo['secret']);
        // //$data['sign'] = $sign;
        // $data = [
        //     'mobile'=>'+86-18664597716'
        // ];
        //$LzscmsCurl = new LzscmsCurl();
        //网易ok
        // $LzscmsCurl->url = 'http://reg.email.163.com/unireg/call.do?cmd=added.mobileverify.verifyIntMobileFormat';
        // $LzscmsCurl->get($data);
        // $result = $LzscmsCurl->data(false);
        //美团
//         $t='Accept: */*
// Accept-Encoding: gzip, deflate, br
// Accept-Language: zh-CN,zh;q=0.9,en;q=0.8
// Connection: keep-alive
// Content-Length: 18
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Cookie: __mta=88904356.1535687077412.1535687330505.1535687335006.10"; uuid=394558d4d25041f781a8.1535533824.1.0.0; _lx_utm=utm_source%3DBaidu%26utm_medium%3Dorganic; _lxsdk_cuid=16584f2bec40-0d20d6fca3382a-3467790a-13c680-16584f2bec5c8; SERV=www; passport.sid=FxQTPFnSKy8kiyVKUEwQHND55Fd0Vf1B; passport.sid.sig=RR9BrO93JxKnoEQMLLZPo5id4oA; mtcdn=K; ci=30; LREF=aHR0cDovL3d3dy5tZWl0dWFuLmNvbS9hY2NvdW50L3NldHRva2VuP2NvbnRpbnVlPWh0dHAlM0ElMkYlMkZzei5tZWl0dWFuLmNvbSUyRg%3D%3D; _lxsdk_s=1658e1512f7-044-a4f-444%7C%7C8
// Host: passport.meituan.com
// Origin: https://passport.meituan.com
// Referer: https://passport.meituan.com/account/unitivesignup?service=www&continue=http%3A%2F%2Fwww.meituan.com%2Faccount%2Fsettoken%3Fcontinue%3Dhttp%253A%252F%252Fsz.meituan.com%252F
// User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36
// X-Client: javascript
// X-CSRF-Token: 59HUTPCn-L5DLJZhBcoMMOkO-dz1kWvMAVbU
// X-Requested-With: XMLHttpRequest';
// $headers = explode("\n", $t);
        // $LzscmsCurl->url = 'https://passport.meituan.com/account/unitivesignup?service=www&continue=http%3A%2F%2Fwww.meituan.com%2Faccount%2Fsettoken%3Fcontinue%3Dhttp%253A%252F%252Fsz.meituan.com%252F';
        // $LzscmsCurl->cookie = 1;
        // $LzscmsCurl->get();
        // $result = $LzscmsCurl->data(false);

        // $LzscmsCurl->header = $headers;
        // $LzscmsCurl->url = 'https://passport.meituan.com/account/signupcheck';
        // $LzscmsCurl->cookie = 2;
        // $LzscmsCurl->post(['mobiles'=>'1111']);
        // $result = $LzscmsCurl->data(true);

//         // //新浪
// $t = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8
// Accept-Encoding: gzip, deflate, br
// Accept-Language: zh-CN,zh;q=0.9,en;q=0.8
// Cache-Control: max-age=0
// Connection: keep-alive
// Cookie: SCF=AhXquppOGe9ZATwX-wF8e-wVb3QV4MxGKZtsuSe_T0ETEgPyNipltl8jIit8FIuX3w_9HdlCnCa8r3KJOybR_2I.; UOR=www.cnblogs.com,v.t,; sso_info=v02m6alo5qztKWRk5iljpSQpZCToKWRk5SljpOEpZCToKadlqWkj5OIuIyToLSMk4iwjJOIwA==; U_TRS1=000000d9.d2253802.5a21025a.537c19ee; SINAGLOBAL=59.40.117.217_1512112731.285814; SGUID=1518402120000_91859444; Apache=172.16.92.25_1535685787.927379; ULV=1535685789974:7:2:2:172.16.92.25_1535685787.927379:1535685788614; lxlrttp=1532434326; UM_distinctid=1658e2e1545727-0e81de8be91ff1-3467790a-13c680-1658e2e1546409; ULOGIN_IMG=gz-9d413a529b43fe7bb6c9b90495c3b1d130bc
// Host: login.sina.com.cn
// Referer: https://www.sina.com.cn/
// Upgrade-Insecure-Requests: 1
// User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36';
// $headers = explode("\n", $t);
//         $data = [
//             'name'=>'121212',
//             'format'=>'json',
//             'from'=>'mobile'
//         ];
//         $LzscmsCurl->url = 'https://login.sina.com.cn/signup/signup?entry=homepage';
//         $LzscmsCurl->cookie = 1;
//         $LzscmsCurl->get();
//         $result = $LzscmsCurl->data(false);
//         // print_r($result);

//         $url = 'https://login.sina.com.cn/signup/check_user.php';
//         $LzscmsCurl->url = $url;
//         $LzscmsCurl->cookie = 2;
//         $LzscmsCurl->header = $headers;
//         $LzscmsCurl->post($data);
//         $result = $LzscmsCurl->data(false);

        //百度ok
        // $LzscmsCurl->url = 'https://passport.baidu.com/v2/?regphonecheck&token=a29074093940ee5182dd1aeff7bbe140&tpl=mn&apiver=v3&moonshad=do802b15c0119f4ada539702678d6aa6a1&countrycode=&gid=46950E5-9EF4-42B3-BD7E-E34327F3F898&exchange=0&isexchangeable=1&action=reg&traceid=&callback=bd__cbs__lcc7bo';
        // $data = [
        //     'phone'=>'18664597716',
        //     't'=>Lzs_time()
        // ];
        // $LzscmsCurl->get($data);
        // $result = $LzscmsCurl->data(false);
        // $substr = substr_count($result, '400005');
        // print_r($substr);
        //百合网ok
        // $LzscmsCurl->url = 'http://my.baihe.com/register/emailCheckForXs?jsonCallBack=jQuery18301551828455401103_1535698926848';
        // $data = [
        //     'email'=>'18664597716',
        //     '_'=>Lzs_time()
        // ];
        // $LzscmsCurl->get($data);
        // $result = $LzscmsCurl->data(false);
        // $substr = substr_count($result, '"state":1,"data"');
        // print_r($substr);
        //安居客用户 ok
        // $LzscmsCurl->url = 'https://login.anjuke.com/login/checkphone';
        // $data = [
        //     'phone'=>'15112358980',
        //     '_'=>Lzs_time()
        // ];
        // $LzscmsCurl->get($data);
        // $result = $LzscmsCurl->data(true);
        // print_r($result);
        //安居客经纪人 ok
        // $LzscmsCurl->url = 'http://vip.anjuke.com/broker/register/';
        // $data = [
        //     'mobile'=>'15112358980',
        //     'tmp'=>Lzs_time()
        // ];
        // $LzscmsCurl->get($data);
        // $result = $LzscmsCurl->data(true);      //"used"  "no use"
        // print_r($result);
        //前程无忧 ok
        // $LzscmsCurl->url = 'https://login.51job.com/ajax/checkinfo.php?type=mobile&nation=CN';
        // $data = [
        //     'value'=>'18638106558',
        //     '_'=>Lzs_time()
        // ];
        // $LzscmsCurl->get($data);
        // $result = $LzscmsCurl->data(false);      //"used"  "no use"
        // print_r($result);

            //赶集
//         $LzscmsCurl->url = 'https://passport.ganji.com/register.php?next=/';
//         $LzscmsCurl->cookie = 1;
//         $LzscmsCurl->get();
//         $results = $LzscmsCurl->data(false);

//         preg_match_all("/window.PAGE_CONFIG.__hash__ = '(.*)';/U", $results, $hashs);


//         $t='Accept: application/json, text/javascript, */*; q=0.01
// Accept-Encoding: gzip, deflate, br
// Accept-Language: zh-CN,zh;q=0.9,en;q=0.8
// Connection: keep-alive
// Content-Length: 103
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Cookie: ganji_xuuid=d5f2f9b0-9aa5-43d4-eada-a1fd9c6e0ce3.1535699983507; ganji_uuid=8395391986230419896953; _gl_tracker=%7B%22ca_source%22%3A%22www.baidu.com%22%2C%22ca_name%22%3A%22-%22%2C%22ca_kw%22%3A%22-%22%2C%22ca_id%22%3A%22-%22%2C%22ca_s%22%3A%22seo_baidu%22%2C%22ca_n%22%3A%22-%22%2C%22ca_i%22%3A%22-%22%2C%22sid%22%3A55183626799%7D; GANJISESSID=ont8b7lkqsohctaqcofmp2c2ud; lg=1; statistics_clientid=me; __utma=32156897.425154637.1535699986.1535699986.1535699986.1; __utmc=32156897; __utmz=32156897.1535699986.1.1.utmcsr=sz.ganji.com|utmccn=(referral)|utmcmd=referral|utmcct=/; ganji_login_act=1535700235782; __utmb=32156897.4.10.1535699986
// Host: passport.ganji.com
// Origin: https://passport.ganji.com
// Referer: https://passport.ganji.com/register.php?next=/
// User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36
// X-Requested-With: XMLHttpRequest';
// $headers = explode("\n", $t);
//         $LzscmsCurl->url = 'https://passport.ganji.com/ajax.php?module=check_phone_by_reg';
//         $data = [
//             'reg_phone'=>'18664597712',
//             '__hash__'=>$hashs[1][0]
//         ];
//         $LzscmsCurl->post($data);
//         $LzscmsCurl->cookie = 2;
//         $LzscmsCurl->header = $headers;
//         $result = $LzscmsCurl->data(true);
//         // $substr = substr_count($result, '"state":1,"data"');
//         print_r($result);
        //极客学院 ok
        // $LzscmsCurl->url = 'https://passport.jikexueyuan.com/check/phone?client=www&jsoncallback=jQuery21103105180376781871_1535727335864';
        // $data = [
        //     'phone'=>'18664597712'
        // ];
        // $LzscmsCurl->post($data);
        // $result = $LzscmsCurl->data(false);
        // $substr = substr_count($result, '"state":1,"data"');
        //jQuery21103105180376781871_1535727335864({"status":1,"msg":"手机可用"})

        //爱奇艺ok
        // $LzscmsCurl->url = 'https://passport.iqiyi.com/apis/user/check_account.action';
        // $data = [
        //     '__NEW'=>'1',
        //     'account'=>'18664597712'
        // ];
        // $LzscmsCurl->post($data);
        // $result = $LzscmsCurl->data(true);
        //凤凰网 ok
        // $LzscmsCurl->url = 'https://id.ifeng.com/api/checkMobile?callback=jQuery183007909344229951709_1535728869153';
        // $data = [
        //     'u'=>'18664597712'
        // ];
        // $LzscmsCurl->post($data);
        // $result = $LzscmsCurl->data(false);

        // $LzscmsCurl->url = 'https://reg.gome.com.cn/register/validateExist/refuse.do';
        // $data = [
        //     'login'=>'18664597712'
        // ];
        // $LzscmsCurl->post($data);
        // $result = $LzscmsCurl->data(false);



        //     //房天下经纪云
        //  $LzscmsCurl->url = 'http://yun.fang.com/navi/register.html';
        //  $LzscmsCurl->cookie = 1;
        //  $LzscmsCurl->get();
        //  $results = $LzscmsCurl->data(false);


        //  $LzscmsCurl->url = 'https://passport.fang.com/checkPhonebinding.api?callback=myCallBack&Service=soufun-passport-web&_=1535729467297';
        //  $LzscmsCurl->cookie = 3;
        //  $LzscmsCurl->get([
        //     'MobilePhone'=>'18664597716'
        // ]);
        //  $results = $LzscmsCurl->data(false);
        // print_r($result);
        // exit;

        // CommonFormModel::addForm([
        //     'module'=>'Lzscms',
        //     'name'=>'测试吧',
        //     'table'=>'form_test',
        //     'setting'=>[
        //         'verify'=>1,
        //         'mobile'=>'18664597716',
        //         'email'=>'8293293@qq.com',
        //         'email_title'=>'留言通知'
        //     ]
        // ]);

        // $LzscmsFields = new LzscmsFields();
        // $fields = CommonFieldsModel::getFields('form_liuyanbiao');
        // $inputHtml = $LzscmsFields->input_html($fields);
        // $this->viewData['inputHtml'] = $inputHtml;
        //CommonFormModel::deleteForm('form_test', 'Lzscms');

        // $LzscmsDb = new LzscmsDb();
        // $LzscmsDb->databaseName = '';

        // echo $LzscmsDb->hasTable('common_config');
        // $colums =  $LzscmsDb->getColumnListing('common_config', 'value');
        // print_r($colums);

        // echo $LzscmsDb->createTable('xxxx',function(Blueprint $table)
        // {
        //     $table->increments('id')->comment('ID');
        // }); 
        
        //$LzscmsDb->renameTable('xxxx', 'oooo');
        // $LzscmsDb->renameColumn('oooo', 'vxxx3', 'vxxx8');
        // $LzscmsDb->addColumns('oooo', ['vxxx1', 'vxxx2', 'vxxx3'], [
        //         'vxxx1'=>[
        //     'type'=>'INT',
        //     'length1'=>10,
        //     'defaultValueType'=>'',
        //     'defaultValue'=>'3',
        //     'comment'=>'测试一下下啦1'
        // ],'vxxx2'=>[
        //     'type'=>'TINYINT',
        //     'length1'=>10,
        //     'defaultValueType'=>'',
        //     'defaultValue'=>'1',
        //     'comment'=>'测试一下下啦2'
        // ],'vxxx3'=>[
        //     'type'=>'VARCHAR',
        //     'length1'=>10,
        //     'defaultValueType'=>'',
        //     'defaultValue'=>'尼玛',
        //     'comment'=>'测试一下下啦3'
        // ],

        // ]);
        //echo $LzscmsDb->renameColumn('oooo', 'namespace', 'vspace');
        //$n = 222;
        //$LzscmsDb->table('xxxx', function(Blueprint $table) use($n)
        //{   
            //echo $n;
            //$table->string('namespace', 30)->default('')->comment(Lzs_lang('Lzscms::public.namespace'));
        //});

        //echo route('hstsmsApiJxReport');  
    	//echo Uuid::generate();
        //return $this->showError('222');
        //$LzscmsSms = new LzscmsSms();
        //$LzscmsSms->getStatus(27);
    	//$result = $LzscmsSms->sendMobileMessage('18123938172', 'login');
		//$result = $Sms->checkVerify('18664597716', '931298s', 'register');
        //print_r($result);
		//if (isset($result['state']) && $result['state'] === 'error') return $this->showError($result['message']);
		//echo 'verify success';
    	//$this->showError('test');
         //echo route('hstsmsApiOldIndex');
        //echo storage::url('2018/05/24/add96657cac69707f4ede232367a89c9.jpg');
        // $LzscmsStorage = new LzscmsStorage();
        // // $LzscmsStorage->aid = 12;
        // $LzscmsStorage->file = '2018/05/24/560a9cfa0f2bcda894b18f95a1210d82.jpg';
        // $result = Lzs_storage_download(13);
        // if(Lzs_message_verify($result)) {
        //     return $this->showError($result['message']);
        // }
        // return $result;
        //echo Lzs_storage_url('sssfsfsdf.jpg');
        return $this->loadTemplate('Lzscms::test.index');
    }

    public function pindex(Request $request)
    {
        $file = $request->file('filedata');
        $lzscmsUpload = new LzscmsUpload();
        $lzscmsUploads = $lzscmsUpload->setFile($file);
        if (lzs_message_verify($lzscmsUploads) ) return $this->showError($lzscmsUploads['message']);
        $lzscmsUploads->doSave();
        $data = $lzscmsUploads->getData();
        $this->viewData['data'] = $data;
        return $this->showMessage('success');
    }
        /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function wechat(Request $request)
    {
        $app = app('wechat.official_account');
        $app->server->push(function ($message) {
            if(!isset($message['MsgType'])){
               return "欢迎关注 overtrue！";
            }
            switch ($message['MsgType']) {
                case 'event':
                    return '收到事件消息'.print_r($message, true);
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
            // ...
        });
        return $app->server->serve();
    }

    //钩子测试页面
    public function hook(Request $request) 
    {
        $data = lzscms_hook('s_test_arr', ['a'=>1], true);
        return $this->loadTemplate('lzscms::test.hook', ['data'=>$data]);
    }

    //验证码测试页面
    public function captcha(Request $request)
    {
        return $this->loadTemplate('lzscms::test.captcha');
    }

    //验证码测试提交
    public function captchaCheck(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ],[
            'code.required'=>lzs_lang('lzscms:captcha.please.enter.the.verification.code')
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput();
        }
    }
}