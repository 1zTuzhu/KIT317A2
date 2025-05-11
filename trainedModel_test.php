<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
header('Content-type: text/plain');
require_once __DIR__ . '/vendor/autoload.php';

use Phpml\ModelManager;
$modelManager = new ModelManager();

$mlp = $modelManager -> restoreFromFile(__DIR__ . "/mlp_trained_model.dat");

$temp = isset($_GET['temp']) ? floatval($_GET['temp']) : null;

if ($temp === null) {
    echo "No temperature value provided.";
    exit;
}

$normalized = [$temp / 100];

echo $mlp->predict($normalized);
