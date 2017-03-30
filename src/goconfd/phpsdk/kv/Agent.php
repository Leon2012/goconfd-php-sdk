<?php
/**
 * @Author: pengleon
 * @Date:   2017-03-14 13:30:52
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-30 14:41:12
 */

namespace goconfd\phpsdk\kv;

use goconfd\phpsdk\KvInterface;
use goconfd\phpsdk\Kv;
use goconfd\phpsdk\Util;

class Agent implements KvInterface
{
	private $_url;

	public function __construct($url)
	{
		$this->_url = $url;
	}

	public function get($key)
	{
		$hexKey = Util::str2hex($key);
		if (substr($this->_url, -1) == "/") {
			$url = $this->_url."get/".$hexKey;
		}else{
			$url = $this->_url."/get/".$hexKey;
		}
		$client = new \GuzzleHttp\Client();
		$res = $client->get($url);
		if ($res->getStatusCode() == 200) {
			$json = $res->getBody();
			$arr = json_decode($json, true);
			if (!$arr) {
				return null;
			}
			$kv = new Kv($arr);
			return $kv;
		}else{
			return null;
		}
	}
}
