<?php
/**
 * @Author: PengYe
 * @Date:   2017-03-30 14:21:24
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-30 17:15:22
 */

namespace goconfd\phpsdk\kv;

use goconfd\phpsdk\KvInterface;
use goconfd\phpsdk\Kv;
use goconfd\phpsdk\Util;

class MsgQueue
{
	private $_queuePath;

	public function __construct($queuePath)
	{
		if (!function_exists('msg_get_queue')) {
			throw new Exception("no msg queue extension");
		}
		$this->_queuePath = $queuePath;
	}

	public function send($key)
	{
		//$hexKey = Util::str2hex($key);
		$shmKey = Util::ftok($this->_queuePath, 0x01);
		//$shmKey = 0xDEADBEEF;
		if ($shmKey == -1) {
			return false;
		}
		if(!msg_queue_exists($shmKey)){
			return false;
		}
		if(($msqid = msg_get_queue($shmKey)) === FALSE) {
			return false;
		}
		if(!msg_send($msqid, 12, $key, false)) {
			return false;
		}
		return true;
	}
}
