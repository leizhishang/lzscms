<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class CaptchaController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
    	return $this->loadTemplate('lzscms::manage.captcha.index', [
            'config'=>lzs_config('captcha')
        ]);
    }

    public function save(Request $request) 
    {
        $arrRequest = $request->all();
        $arrRequest['width'] = $arrRequest['width'] ? $arrRequest['width'] : 120;
        $arrRequest['height'] = $arrRequest['height'] ? $arrRequest['height'] : 60;
        $arrRequest['length'] = $arrRequest['length'] ? $arrRequest['length'] : 5;
        $data =[
            ['name'=>'width', 'value'=>$arrRequest['width']],
            ['name'=>'height', 'value'=>$arrRequest['height']],
            ['name'=>'length', 'value'=>$arrRequest['length']],
        ];
        $configData = [
            'CAPTCHA_WIDTH' => $arrRequest['width'] ? (int)$arrRequest['width'] : 120,
            'CAPTCHA_HEIGHT' => $arrRequest['height'] ? (int)$arrRequest['height'] : 60,
            'CAPTCHA_LENGTH' => $arrRequest['length'] ? (int)$arrRequest['length'] : 5,
        ];
        $oldConfig = lzs_config('captcha');
        lzs_save_config('captcha', $data);
        lzs_updateEnvInfo($configData);
        $this->addOperationLog(lzs_lang('lzscms::captcha.svae'),'', lzs_config('captcha'), $oldConfig);
        return $this->showMessage('lzscms::public.save.success');
    }
}

