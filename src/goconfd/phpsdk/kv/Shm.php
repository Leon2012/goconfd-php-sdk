<?php
/**
 * @Author: pengleon
 * @Date:   2017-03-20 15:55:29
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-30 14:41:50
 */

namespace goconfd\phpsdk\kv;

use goconfd\phpsdk\KvInterface;
use goconfd\phpsdk\Kv;
use goconfd\phpsdk\Exception;
use goconfd\phpsdk\Util;

class Shm extends Base implements KvInterface
{
	
	public function __construct($shmPath = "/dev/shm")
	{
		if (!function_exists('shmop_open')) {
			throw new Exception("no shmop extension");
		}
		parent::__construct($shmPath);
	}

	public function get($key)
	{
		$hexKey = Util::str2hex($key);
		$shmFile = $this->_path."/".$hexKey;
		$shmKey = Util::ftok($shmFile, 0x01);
		if ($shmKey == -1) {
			return null;
		}
		$shmId = shmop_open($shmKey, "a", 0666, 4096);
		if ($shmId === false) {
			return null;
		}
		$size = shmop_size($shmId);
		$shmData = shmop_read($shmId, 0, $size);
		if (!$shmData) {
			return null;
		}
		$shmData = trim($shmData);
		$arr = json_decode($shmData, true);
		if (!$arr) {
			return null;
		}
		shmop_close($shmId);
		$kv = new Kv($arr);
		return $kv;
	}

}