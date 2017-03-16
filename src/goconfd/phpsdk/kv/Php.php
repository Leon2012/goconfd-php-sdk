<?php
/**
 * @Author: pengleon
 * @Date:   2017-03-14 13:30:45
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-16 16:43:52
 */

namespace goconfd\phpsdk\kv;

use goconfd\phpsdk\KvInterface;
use goconfd\phpsdk\Kv;

class Php extends Base implements KvInterface
{
	
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
}