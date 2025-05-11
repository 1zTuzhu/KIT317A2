<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
header('Content-type: text/plain');
require_once __DIR__ . '/vendor/autoload.php';


use Phpml\Classification\MLPClassifier;
use Phpml\ModelManager;

$mlp = new MLPClassifier(1, [3,2], ['normal', 'spike']);
$mlp->setLearningRate(0.05);

$rawData = json_decode(file_get_contents("trainData.json"));

echo "count of raw data :";
echo count($rawData -> record) . PHP_EOL;

$samples = [];
$targets = [];

foreach ($rawData -> record as $entry){
	$temp = floatval($entry ->temp);
	$samples[] = [$temp];
}

//set min and max threshold based on sensor and spike injection settings
//temp increase and decrease rate is 0.5 - 0.8 per seconds 
//and has threshold at 53C and 3 overshoot
$min_threshold = (53.7+2.4) -20;
$max_threshold = (46.7-2.4) +20;

foreach ($samples as $sample){
        $temp = $sample[0];
        if ($temp < $min_threshold  || $temp > $max_threshold){
                $targets[] = 'spike';
        }else{
                $targets[] = 'normal';
        }
}

var_dump($samples);
$t_ = time();

//normalize samples to 0-1
$normalized_samples = [];
foreach ($samples as $entry){
        $normalized_samples[] = [$entry[0]/100];
}

$mlp->train($normalized_samples,$targets);

//testing
$test=[0.1,0.2,0.3,0.32,0.45,0.48,0.55,0.65,0.75,0.81,0.97];
foreach($test as $b){
	$output = $mlp->predict([$b]);
	print("temp stats: " .$b."       ". $output) .PHP_EOL;
}
//save to file
$filepath = __DIR__ . '/mlp_trained_model.dat';
$modelManager = new ModelManager();
$modelManager->saveToFile($mlp, $filepath);

echo "Execution time : " . time() - $t_ . "s\r\n";
?>

