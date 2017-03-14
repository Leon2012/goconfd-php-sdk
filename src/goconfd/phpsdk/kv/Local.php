<?php
/**
 * @Author: pengleon
 * @Date:   2017-03-14 13:30:45
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-14 15:58:33
 */

namespace goconfd\phpsdk\kv;

use goconfd\phpsdk\KvInterface;
use goconfd\phpsdk\Kv;

class Local implements KvInterface
{
	
	private $_path;

	public function __construct($path)
	{
		$this->_path = $path;
	}

	public function get($key)
	{
		$hexKey = $this->str2hex($key);
		$file = $this->_path."/".$hexKey.".php";
		if (!file_exists($file)) {
			return null;
		}
		include_once($file);
		
		$arr = [];
		$phpKeyPrefix = '_'.$hexKey.'_';
		
		$phpRevKey = $phpKeyPrefix.'value';
		$arr['rev'] = ${$phpRevKey};

		$phpTypeKey = $phpKeyPrefix.'type';
		$arr['type'] = ${$phpTypeKey};

		$phpKeyKey = $phpKeyPrefix.'key';
		$arr['key'] = ${$phpKeyKey};

		$phpValueKey = $phpKeyPrefix.'value';
		$arr['value'] = ${$phpValueKey};

		$kv = new Kv($arr);
		return $kv;
	}

	private function str2hex($str)
	{
		$hex = '';
	    for ($i=0; $i < strlen($str); $i++){
	        $hex .= dechex(ord($str[$i]));
	    }
	    return $hex;
	}

	private function hex2str($hex)
	{
		$str = '';
	    for ($i=0; $i < strlen($hex)-1; $i+=2){
	        $str .= chr(hexdec($hex[$i].$hex[$i+1]));
	    }
	    return $str;
	}
}