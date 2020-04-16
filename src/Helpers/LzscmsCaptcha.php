<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Gregwar\Captcha\CaptchaBuilder;

/**
 * 检测验证码是否正确
 *
 * @param string $code
 * @return bool
 */
if ( ! function_exists('lzs_captcha_check_code'))
{
    function lzs_captcha_check_code($code)
    {
        $builder = new CaptchaBuilder(Session::get('phrase'));
        if ($builder->testPhrase($code)) {
            return true;
        }
        return false;
    }
}