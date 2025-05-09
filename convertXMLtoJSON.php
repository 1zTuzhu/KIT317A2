<?php

	header("Content-Type: application/json");


	$tempdata_xml = simplexml_load_file("tempdata.xml");

	$formatted = new stdClass();
	$formatted -> record = [];

	foreach ($tempdata_xml->record as $r) {
		$entry = new stdClass();
		$entry->temp = (string)$r->temp;
		$entry->time = (string)$r->time;
		$formatted->record[] = $entry;
	}
	//json in a more readable format
	echo json_encode($formatted, JSON_PRETTY_PRINT);
?>
