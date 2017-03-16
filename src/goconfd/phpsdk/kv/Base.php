<?php
/**
 * @Author: pengleon
 * @Date:   2017-03-16 16:41:24
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-16 16:43:45
 */

namespace goconfd\phpsdk\kv;

abstract class Base 
{
	
	protected $_path;

	public function __construct($path)
	{
		$this->_path = $path;
	}

	protected function str2hex($str)
	{
		$hex = '';
	    for ($i=0; $i < strlen($str); $i++){
	        $hex .= dechex(ord($str[$i]));
	    }
	    return $hex;
	}

	protected function hex2str($hex)
	{
		$str = '';
	    for ($i=0; $i < strlen($hex)-1; $i+=2){
	        $str .= chr(hexdec($hex[$i].$hex[$i+1]));
	    }
	    return $str;
	}
} 