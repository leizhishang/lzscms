<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Hook;

class TestHook
{
    public function test1($data = [])
    {
        $data['b'] = lzs_lang('lzscms::public.the.array.hook1');
        return $data;
    }
   
    public function test2($data = [])
    {
        $data['c'] = lzs_lang('lzscms::public.the.array.hook2');
        return $data;
    }

    public function test3($html = '')
    {
        //echo 'html钩子1输出内容,正常<br />';
        $html .= '1';
        return $html;
    }

    public function test4($html = '') 
    {
        //echo 'html钩子2输出内容,正常<br />';
        $html .='2';
        return $html;
    }
}
