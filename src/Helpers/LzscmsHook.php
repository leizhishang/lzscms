<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Leizhishang\Lzscms\Libraries\LzscmsHook;
/**
 * hook
 */

if ( ! function_exists('lzscms_hook'))
{
    function lzscms_hook($hook_name, $data = null, $result = false)
    {
    	$lzscmsHook = new LzscmsHook();
        if($result) {
            return $lzscmsHook->call_hook($hook_name, $data, $result);
        }
        $lzscmsHook->call_hook($hook_name, $data, false);
    }
}