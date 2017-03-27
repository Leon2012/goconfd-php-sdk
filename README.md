# goconfd-php-sdk
goconfd php sdk

```
	include_once("../vendor/autoload.php");
	use goconfd\phpsdk\Goconfd;
	$config = [
		'save_path' => '/tmp/goconfd',
		'key_prefix' => 'develop.activity',
		'save_type' => 2,
		'file_ext' => '',
		'agent_url' => 'http://127.0.0.1:3001/',
	];
	$sdk = new Goconfd($config);
	$kv = $sdk->get("develop.activity.k1");
	if ($kv) {
		echo $kv->getValue();
	}

```
