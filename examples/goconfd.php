<?php
/**
 * @Author: pengleon
 * @Date:   2017-03-14 15:03:01
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-30 17:11:35
 */

include_once("../vendor/autoload.php");

use goconfd\phpsdk\Goconfd;

// $config = [
// 	'save_path' => '/Users/pengleon/Downloads/goconfd',
// 	'key_prefix' => 'develop.activity',
// 	'save_type' => 1,
// 	'file_ext' => 'php',
// 	'agent_url' => 'http://127.0.0.1:3001/',
// ];

$config = [
	'save_path' => '/tmp/goconfd',
	'key_prefix' => 'develop.activity',
	'save_type' => 2,
	'file_ext' => '',
	'agent_url' => 'http://127.0.0.1:3001/',
];

$key = "develop.activity.k1";
$sdk = new Goconfd($config);
$sdk->sendQueue('/tmp/queue1', 'develop.activity.k10');
$kv = $sdk->get("develop.activity.k10");
if ($kv) {
	echo $kv->getValue();
}


