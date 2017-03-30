<?php
/**
 * @Author: PengYe
 * @Date:   2017-03-30 14:14:00
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-30 14:40:44
 */

namespace goconfd\phpsdk;

final class Util 
{
	public static function ftok($pathname, $proj_id)
	{
		$st = @stat($pathname); 
   		if (!$st) { 
       		return -1; 
   		} 
   		$key = sprintf("%u", (($st['ino'] & 0xffff) | (($st['dev'] & 0xff) << 16) | (($proj_id & 0xff) << 24)));
   		return $key; 
	}

	public static function str2hex($str)
	{
		$hex = '';
	    for ($i=0; $i < strlen($str); $i++){
	        $hex .= dechex(ord($str[$i]));
	    }
	    return $hex;
	}

	public static function hex2str($hex)
	{
		$str = '';
	    for ($i=0; $i < strlen($hex)-1; $i+=2){
	        $str .= chr(hexdec($hex[$i].$hex[$i+1]));
	    }
	    return $str;
	}
} 
