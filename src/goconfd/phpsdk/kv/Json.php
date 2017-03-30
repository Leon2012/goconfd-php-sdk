<?php
/**
 * @Author: pengleon
 * @Date:   2017-03-16 16:40:19
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-30 14:42:04
 */
namespace goconfd\phpsdk\kv;

use goconfd\phpsdk\KvInterface;
use goconfd\phpsdk\Kv;
use goconfd\phpsdk\Util;

class Json extends Base implements KvInterface
{

	public function get($key)
	{
		$hexKey = Util::str2hex($key);
		$file = $this->_path."/".$hexKey.".json";
		if (!file_exists($file)) {
			return null;
		}
		$json = file_get_contents($file);
		$arr = json_decode($json, true);
		if (!$arr) {
			return null;
		}
		$kv = new Kv($arr);
		return $kv;
	}
}