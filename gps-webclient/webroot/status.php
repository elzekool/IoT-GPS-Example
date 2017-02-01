<?php

use stej\Particle\ParticleAPI;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__FILE__) . '/vendor/autoload.php';

$envFile = dirname(__FILE__) . '/.env';
if (file_exists($envFile)) {
    $dotEnv = new Dotenv();
    $dotEnv->load($envFile);
}

if (empty($_ENV['PARTICLE_ACCESS_TOKEN']) || empty($_ENV['PARTICLE_DEVICE_ID'])) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    exit();
}

$accessToken = $_ENV['PARTICLE_ACCESS_TOKEN'];
$deviceId = $_ENV['PARTICLE_DEVICE_ID'];

$particleApi = new ParticleAPI();
$particleApi->setAccessToken($accessToken);
$particleApi->setDebug(false);

$result = array(
    'hasFix' => 0,
    'lat' => 0,
    'lng' => 0,
    'satelites' => 0,
    'batVoltage' => 0
);

foreach(array_keys($result) as $varName) {
    if(true === $particleApi->getVariable($deviceId, $varName)) {
        $result[$varName] = $particleApi->getResult()['result'];
    }
}

header("Content-Type: text/json; charset=utf-8");
echo json_encode($result, JSON_PRETTY_PRINT);




