<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */

/**
 * 检测验证码是否正确
 *
 * @param string $code
 * @return bool
 */
if ( ! function_exists('lzs_cache_total_increment'))
{
    function lzs_cache_total_increment($name, $val = 1)
    {
        $cacheName = 'lzscms:total:'.$name;
        if (!Cache::has($cacheName)) {
            Cache::forever($cacheName, $val);
        } else {
        	$number = Cache::get($cacheName, 0);
            Cache::forever($cacheName, $number + $val);
        }
    }
}

if ( ! function_exists('lzs_cache_total_decrement'))
{
    function lzs_cache_total_decrement($name, $val = 1)
    {
        $cacheName = 'lzscms:total:'.$name;
        if (!Cache::has($cacheName)) {
            Cache::forever($cacheName, $val);
        } else {
        	$number = Cache::get($cacheName, 0);
            Cache::forever($cacheName, $number - $val);
        }
    }
}

if ( ! function_exists('lzs_cache_total'))
{
    function lzs_cache_total($name)
    {
        $cacheName = 'lzscms:total:'.$name;
        if (!Cache::has($cacheName)) {
            return 0;
        } else {
        	return Cache::get($cacheName, 0);
        }
    }
}

if ( ! function_exists('lzs_cache_total_del'))
{
    function lzs_cache_total_del($name)
    {
        $cacheName = 'lzscms:total:'.$name;
        if (Cache::has($cacheName)) {
        	Cache::forget($cacheName);
        }
    }
}