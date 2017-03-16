<?php
/**
 * @Author: pengleon
 * @Date:   2017-03-14 13:26:42
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-16 16:51:17
 */

namespace goconfd\phpsdk;

use goconfd\phpsdk\kv\Php;
use goconfd\phpsdk\kv\Json;
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
		if (empty($this->_config['save_type'])) {
			$this->_config['save_type'] = 1;
		}
		if (empty($this->_config['file_ext'])) {
			$this->_config['file_ext'] = 'php';
		}
	}

	public function initKvs()
	{
		if ($this->_config['save_type'] == 1) {
			if ($this->_config['file_ext'] == 'php') {
				$this->_local = new Php($this->_config['save_path']);
			}else{
				$this->_local = new Json($this->_config['save_path']);
			}
		}
		$this->_agent = new Agent($this->_config['agent_url']);
	}
}