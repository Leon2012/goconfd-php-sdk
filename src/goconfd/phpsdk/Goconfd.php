<?php
/**
 * @Author: pengleon
 * @Date:   2017-03-14 13:26:42
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-30 14:39:14
 */

namespace goconfd\phpsdk;

use goconfd\phpsdk\kv\Php;
use goconfd\phpsdk\kv\Json;
use goconfd\phpsdk\kv\Agent;
use goconfd\phpsdk\kv\Shm;
use goconfd\phpsdk\kv\MsgQueue;

class Goconfd 
{
	private $_config;
	private $_local;
	private $_agent;
	private $_queue;

	public function __construct($config)
	{
		$this->_config = $config;
		$this->chkConfig();
		$this->initKvs();
	}

	public function getFromAgent($key)
	{
		$key = $this->chkKeyPrefix($key);
		$kv = $this->_agent->get($key);
		return $kv;
	}

	public function getFromQueue($queuePath, $key)
	{
		if (!$this->_queue) {
			$this->_queue = new MsgQueue($queuePath);
		}
		$kv = $this->_queue->get($key);
		return $kv;
	}

	public function get($key)
	{
		$key = $this->chkKeyPrefix($key);
		$kv = $this->_local->get($key);
		return $kv;
	}

	private function chkKeyPrefix($key)
	{
		$pos = strpos($key, $this->_config['key_prefix']);
		if ($pos === false) {
			$key = $this->_config['key_prefix'].$key;
		}
		return $key;
	}

	private function chkConfig()
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

	private function initKvs()
	{
		if ($this->_config['save_type'] == 1) {
			if ($this->_config['file_ext'] == 'php') {
				$this->_local = new Php($this->_config['save_path']);
			}else{
				$this->_local = new Json($this->_config['save_path']);
			}
		}else{
			$this->_local = new Shm($this->_config['save_path']);
		}
		$this->_agent = new Agent($this->_config['agent_url']);
	}
}