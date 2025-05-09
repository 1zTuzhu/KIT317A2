<?php 
error_reporting(E_ALL);						
ini_set('display_errors', '1');

if (isset($_GET['temp']) && isset($_GET['time'])) {
	$temp = $_GET['temp'];
	$time = $_GET['time'];

	$str = '';
	$filename = 'tempdata.xml';

	if (file_exists($filename)) {
		$str = file_get_contents($filename);
	}
	if (strlen($str) == 0) {
		$str = "<?xml version='1.0' encoding='UTF-8'?>\n<data></data>";
	}

	$newData = "\n<record><temp>" . $temp . "</temp><time>" .$time. "</time></record>\n</data>";
	$str = str_replace("</data>", $newData, $str);

	file_put_contents($filename, $str);

	echo "1";
} else {
	echo "0";
}
?>
