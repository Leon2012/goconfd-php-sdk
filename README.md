# goconfd-php-sdk
goconfd php sdk

```
	include_once("../vendor/autoload.php");
	use goconfd\phpsdk\Goconfd;
	$config = [
		'save_path' => '/Users/pengleon/Downloads/goconfd',
		'key_prefix' => 'develop.activity',
	];

	$sdk = new Goconfd($config);
	$kv = $sdk->get("develop.activity.k1");
	echo $kv->getValue();

```
