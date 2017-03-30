<?php
/**
 * @Author: PengYe
 * @Date:   2017-03-30 14:21:24
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-30 14:41:59
 */

namespace goconfd\phpsdk\kv;

use goconfd\phpsdk\KvInterface;
use goconfd\phpsdk\Kv;
use goconfd\phpsdk\Util;

class MsgQueue implements KvInterface
{
	private $_queuePath;

	public function __construct($queuePath)
	{
		if (!function_exists('msg_get_queue')) {
			throw new Exception("no msg queue extension");
		}
		$this->_queuePath = $queuePath;
	}

	public function get($key)
	{
		$hexKey = Util::str2hex($key);
		$shmKey = Util::ftok($this->_queuePath, 0x01);
		if ($shmKey == -1) {
			return null;
		}
		if(!msg_queue_exists($shmKey)){
			return null;
		}
		if(($msqid = msg_get_queue($shmKey)) === FALSE) {
			return null;
		}
		if(!msg_send($msqid, 12, $hexKey."\0", false)) {
			return null;
		}

		if (!msg_receive($msqid,0,$msgtype,1024,$data,true)) {
			return null;
		} 
		$arr = json_decode($data, true);
		if (!$arr) {
			return null;
		}
		$kv = new Kv($arr);
		return $kv;
	}
}
