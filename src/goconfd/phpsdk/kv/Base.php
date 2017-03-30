<?php
/**
 * @Author: pengleon
 * @Date:   2017-03-16 16:41:24
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-30 14:40:51
 */

namespace goconfd\phpsdk\kv;

abstract class Base 
{
	
	protected $_path;

	public function __construct($path)
	{
		$this->_path = $path;
	}

	
} 