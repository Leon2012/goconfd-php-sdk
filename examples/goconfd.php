<?php
/**
 * @Author: pengleon
 * @Date:   2017-03-14 15:03:01
 * @Last Modified by:   PengYe
 * @Last Modified time: 2017-03-14 16:14:31
 */

include_once("../vendor/autoload.php");

use goconfd\phpsdk\Goconfd;

$config = [
	'save_path' => '/Users/pengleon/Downloads/goconfd',
	'key_prefix' => 'develop.activity',
];

$sdk = new Goconfd($config);
$kv = $sdk->get("develop.activity.k1");
echo $kv->getValue();

