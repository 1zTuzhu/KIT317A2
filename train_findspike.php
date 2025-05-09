<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
header('Content-type: text/plain');
require_once __DIR__ . '/vendor/autoload.php';


use Phpml\Classification\MLPClassifier;
use Phpml\ModelManager;

$mlp = new MLPClassifier(1, [3], ['normal', 'spike']);
$mlp->setLearningRate(0.1);

$rawData = json_decode(file_get_contents("trainData.json"));

echo "count of raw data :";
echo count($rawData -> record) . PHP_EOL;

$temp_samples = [];

foreach ($rawData -> record as $entry){
	$temp = floatval($entry ->temp);
	array_push($temp_samples, [$temp]);
}

$t_ = time();


$mlp->train(
    $samples = [
        [50.6],[51.2],[52.0],[52.6],[34.9],[35.9],[42.0],[74.8],[54.8],[54.0],
        [72.2],[42.4],[39.3],[51.5],[50.7],[49.9],[49.4],[48.7],[48.1],[47.4],
        [63.8],[56.7],[56.7],[28.5],[45.3],[29.3],[31.0],[47.2],[48.0],[48.8],
        [49.4],[67.6],[50.9],[51.5],[64.9],[52.7],[66.4],[54.1],[39.9],[71.8],
        [54.9],[65.5],[70.3],[52.8],[32.9],[51.6],[66.9],[35.9],[49.4],[67.0],
        [48.1],[65.6],[65.2],[29.5],[45.5],[28.1],[45.6],[46.1],[66.2],[47.2],
        [29.3],[48.5],[30.5],[60.8],[39.0],[62.5],[51.7],[52.5],[53.2],[37.0],
        [54.5],[55.0],[54.3],[53.6],[64.5],[52.4],[38.1],[33.7],[63.3],[50.0],        
        [32.5],[48.7],[61.9],[47.5],[46.7],[46.0],[45.5],[56.9],[45.4],[65.7],
        [46.8],[63.5],[47.9],[48.4],[49.0],[31.4],[64.0],[51.0],[51.6],[52.3],
        [52.8],[34.9],[54.0],[54.7],[43.9],[37.5],[73.1],[53.5],[52.9],[33.6]
    ],
    $targets = [
        'normal','normal','normal','normal','spike','spike','spike','spike','normal','normal',
        'spike','spike','spike','normal','normal','normal','normal','normal','normal','normal',
        'spike','spike','spike','spike','normal','spike','spike','normal','normal','normal',
        'normal','spike','normal','normal','spike','normal','spike','normal','spike','spike',
        'normal','spike','spike','normal','spike','normal','spike','spike','normal','spike',
        'normal','spike','spike','spike','normal','spike','normal','normal','spike','normal',
        'spike','normal','spike','spike','spike','spike','normal','normal','normal','spike',
        'normal','normal','normal','normal','spike','normal','spike','spike','spike','normal',
        'spike','normal','spike','normal','normal','normal','normal','spike','normal','spike',        
        'normal','spike','normal','normal','normal','spike','spike','normal','normal','normal',
        'normal','spike','normal','normal','spike','spike','spike','normal','normal','spike'
    ]
);

var_dump($temp_samples[128]);
$output = $mlp->predict([$temp_samples[128]]);
print("temp stats: " . $output[0]) .PHP_EOL;


echo "Execution time : " . time() - $t_ . "s\r\n";
?>


