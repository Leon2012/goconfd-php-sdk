<?php
/**
 * @Author: pengleon
 * @Date:   2017-03-14 15:50:27
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-14 16:14:15
 */

namespace goconfd\phpsdk;

class Kv 
{
	private $_key;
	private $_rev;
	private $_type;
	private $_value;

	public function __construct($arr)
	{
		$this->fromArray($arr);
	}

	public function fromArray($arr)
	{
		if (isset($arr['rev'])) {
			$this->_rev = $arr['rev'];
		}
		if (isset($arr['type'])) {
			$this->_type = $arr['type'];
		}
		if (isset($arr['key'])) {
			$this->_key = $arr['key'];
		}
		if (isset($arr['value'])) {
			$this->_value = $arr['value'];
		}
	}

	public function getKey()
	{
		return $this->_key;
	}

	public function getRev()
	{
		return $this->_rev;
	}

	public function getType()
	{
		return $this->_type;
	}

	public function getValue()
	{
		return $this->_value;
	}
}

