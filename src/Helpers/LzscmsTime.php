<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
/**
 * 获取时间类型
 * @param $str
 * @return string
 */
if ( ! function_exists('lzs_changeTimeType'))
{    
    function lzs_changeTimeType($seconds)
    {
        $one_day = 3600*24;
        if ($seconds > $one_day) {
            $day = floor($seconds/$one_day);
            $hour = $seconds%$one_day;
            $hour = floor($hour/3600);
            $mimute = ($seconds - $day * $one_day) % 3600 ;
            $mimute = floor($mimute/60);
            $seconds = $seconds - $day * $one_day - $hour * 3600 - $mimute * 60;
            return $day.lzs_lang('lzscms::public.day').$hour.lzs_lang('lzscms::public.hour').$mimute.lzs_lang('lzscms::public.minute').$seconds.lzs_lang('lzscms::public.minutes');
        }  elseif($seconds > 3600) {
            $hour = floor($seconds/3600);
            $mimute = $seconds%3600;
            $mimute = floor($mimute/60);
            $seconds = $seconds%3600 - $mimute * 60;
            return $hour.lzs_lang('lzscms::public.hour').$mimute.lzs_lang('lzscms::public.minute').$seconds.lzs_lang('lzscms::public.minutes');
        } elseif($seconds > 60) {
            $mimute = floor($seconds/60);
            $seconds = $seconds - $mimute * 60;
            return $mimute.lzs_lang('lzscms::public.minute').$seconds.lzs_lang('lzscms::public.minutes');
        }
        return $seconds.lzs_lang('lzscms::public.minutes');
    }
}

/**
 * 将时间字串转化成零时区时间戳返回
 *
 * @param string $str 格式良好的时间串
 * @return int
 */
if ( ! function_exists('lzs_str2time'))
{    
    function lzs_str2time($str) 
    {
        $timestamp = strtotime($str);
        //if ($timezone = self::getConfig('site', 'time.timezone')) $timestamp -= $timezone * 3600;
        return $timestamp;
    }
}

/**
 * 时间戳转字符串
 *
 * @example Y-m-d H:i:s  2012-12-12 12:12:12
 * @param int $timestamp 时间戳
 * @param string $format 时间格式
 * @param int $sOffset 时间矫正值
 * @return string
 */
if ( ! function_exists('lzs_time2str'))
{    
    function lzs_time2str($timestamp, $format = 'Y-m-d H:i') 
    {
        if (!$timestamp) return '';
        if ($format == 'auto') return lzs_time2cpstr($timestamp);
        //if ($timezone = self::getConfig('site', 'time.timezone')) $timestamp += $timezone * 3600;
        return gmdate($format, $timestamp);
    }
}

/**
 * 时间戳转字符串
 *
 * @example Y-m-d H:i:s  2012-12-12 12:12:12
 * @param int $timestamp 时间戳
 * @param string $format 时间格式
 * @param int $sOffset 时间矫正值
 * @return string
 */
if ( ! function_exists('lzs_time2cpstr'))
{    
    function lzs_time2cpstr($timestamp) 
    {
        $current = lzs_time();
        $decrease = $current - $timestamp;
        if ($decrease < 0) return lzs_time2str($timestamp);
        if ($decrease < 60) return $decrease . lzs_lang('lzscms::public.minutes.front');
        if ($decrease < 3600) return ceil($decrease / 60) . lzs_lang('lzscms::public.minute.front');
        $decrease = lzs_time2str(lzs_time2str($current, 'Y-m-d')) - lzs_time2str(lzs_time2str($timestamp, 'Y-m-d'));
        if ($decrease == 0) return lzs_time2str($timestamp, 'H:i');
        if ($decrease == 86400) return lzs_lang('lzscms::public.yesterday') . lzs_time2str($timestamp, 'H:i');
        if ($decrease == 172800) return lzs_lang('lzscms::public.the.day.before.yesterday') . lzs_time2str($timestamp, 'H:i');
        if (lzs_time2str($timestamp, 'Y') == lzs_time2str($current, 'Y')) return lzs_time2str($timestamp, 'm-d H:i');
        return lzs_time2str($timestamp);
    }
}

/**
 * 获取矫正过的时间戳值
 *
 * @return int
 */
if ( ! function_exists('lzs_time'))
{    
    function lzs_time() 
    {
        return time() + 8 * 3600;
    }
}

/**
 * 获取今日零点时间戳
 *
 * @return int
 */
if ( ! function_exists('lzs_getTdtime'))
{    
    function lzs_getTdtime() 
    {
        return lzs_str2time(lzs_time2str(lzs_time(), 'Y-m-d'));
    }
}

/**
 * 获取今日凌晨时间
 *
 * @return int
 */
if ( ! function_exists('lzs_getTdtimeStr'))
{    
    function lzs_getTdtimeStr() 
    {
        return lzs_time2str(lzs_getTdtime(), 'Y-m-d H:i:s');
    }
}


/**
 * 获取时间
 * 近30天
 * @return array
 */
if ( ! function_exists('lzs_getDaysTime'))
{    
    function lzs_getDaysTime($number = 0, $direction = false, $today = false)
    {
        $days = [];
        if(!$number || $number < 1) {
            $number = 30;
        }
        if($direction) {
            $t = $today ? 0 : 1;
            $number = $today ? $number : $number + 1;
            for ($i = $t; $i < $number; $i++) {
                $days[] = date('Y-m-d', strtotime(($direction ? '+' : '-').$i.'day'));
            }
        }   else {
            $t = $today ? 0 : 1;
            $number = $today ? $number - 1 : $number;
            for ($i = $number; $i >= $t; $i--) {
                $days[] = date('Y-m-d', strtotime(($direction ? '+' : '-').$i.'day'));
            }
        }
        return $days;
    }
}