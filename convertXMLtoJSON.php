<?php

	header("Content-Type: application/json");
	require_once __DIR__ . '/vendor/autoload.php';

	$tempdata_xml = simplexml_load_file("tempdata.xml");
	$formatted = new stdClass();
	$formatted -> record = [];
	
	use Phpml\ModelManager;
	
	$modelManager = new ModelManager();
	$mlp = $modelManager -> restoreFromFile(__DIR__ . "/mlp_trained_model.dat");	

	foreach ($tempdata_xml->record as $r) {
		$entry = new stdClass();
		$entry->temp = (string)$r->temp;
		$entry->time = (string)$r->time;
		
		//insert prediction result into json
		$temperature = floatval($entry->temp);
		//normalize to 0-1
		$normalized = [$temperature/100];
		$label = $mlp->predict($normalized);
		$entry -> label = $label;
		
		$formatted->record[] = $entry;
	}
	//json in a more readable format
	echo json_encode($formatted, JSON_PRETTY_PRINT);
?>
