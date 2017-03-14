<?php
/**
 * @Author: pengleon
 * @Date:   2017-03-14 13:30:52
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-14 15:56:06
 */

namespace goconfd\phpsdk\kv;

use goconfd\phpsdk\KvInterface;
use goconfd\phpsdk\Kv;

class Agent implements KvInterface
{
	private $_url;

	public function __construct($url)
	{
		$this->_url = $url;
	}

	public function get($key)
	{
		if (substr($this->_url, -1) == "/") {
			$url = $this->_url."get/".$key;
		}else{
			$url = $this->_url."/get/".$key;
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
