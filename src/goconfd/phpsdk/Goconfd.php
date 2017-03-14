<?php
/**
 * @Author: pengleon
 * @Date:   2017-03-14 13:26:42
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-14 16:12:19
 */

namespace goconfd\phpsdk;

use goconfd\phpsdk\kv\Local;
use goconfd\phpsdk\kv\Agent;

class Goconfd 
{
	private $_config;
	private $_local;
	private $_agent;

	public function __construct($config)
	{
		$this->_config = $config;
		$this->chkConfig();
		$this->initKvs();
	}

	public function get($key)
	{
		$pos = strpos($key, $this->_config['key_prefix']);
		if ($pos === false) {
			$key = $this->_config['key_prefix'].$key;
		}
		$kv = $this->_local->get($key);
		if (is_null($kv)) {
			$kv = $this->_agent->get($key);
		}
		return $kv;
	}

	public function chkConfig()
	{
		if (empty($this->_config['save_path'])) {
			throw new Exception("save path require");
		}
		if (empty($this->_config['key_prefix'])) {
			throw new Exception("key prefix require");
		}
		if (!isset($this->_config['agent_url'])) {
			$this->_config['agent_url'] = "http://127.0.0.1:3001/";
		}
	}

	public function initKvs()
	{
		$this->_local = new Local($this->_config['save_path']);
		$this->_agent = new Agent($this->_config['agent_url']);
	}
}