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
        [0.506],[0.512],[0.520],[0.526],[0.349],[0.359],[0.420],[0.748],[0.548],[0.540],
        [0.722],[0.424],[0.393],[0.515],[0.507],[0.499],[0.494],[0.487],[0.481],[0.474],
        [0.638],[0.567],[0.567],[0.285],[0.453],[0.293],[0.310],[0.472],[0.480],[0.488],
        [0.494],[0.676],[0.509],[0.515],[0.649],[0.527],[0.664],[0.541],[0.399],[0.718],
        [0.549],[0.655],[0.703],[0.528],[0.329],[0.516],[0.669],[0.359],[0.494],[0.670],
        [0.481],[0.656],[0.652],[0.295],[0.455],[0.281],[0.456],[0.461],[0.662],[0.472],
        [0.293],[0.485],[0.305],[0.608],[0.390],[0.625],[0.517],[0.525],[0.532],[0.370],
        [0.545],[0.550],[0.543],[0.536],[0.645],[0.524],[0.381],[0.337],[0.633],[0.500],        
        [0.325],[0.487],[0.619],[0.475],[0.467],[0.460],[0.455],[0.569],[0.454],[0.657],
        [0.468],[0.635],[0.479],[0.484],[0.490],[0.314],[0.640],[0.510],[0.516],[0.523],
        [0.528],[0.349],[0.540],[0.547],[0.439],[0.375],[0.731],[0.535],[0.529],[0.336]
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

$test=[0.1,0.2,0.3,0.32,0.4,0.46,0.48,0.55,0.59,0.70,0.81,0.97];
foreach($test as $b){
	$output = $mlp->predict([$b]);
	print("temp stats: " .$b."       ". $output) .PHP_EOL;
}


echo "Execution time : " . time() - $t_ . "s\r\n";
?>
