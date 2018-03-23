<?php
include 'vendor/autoload.php';
use GuzzleHttp\Client;

//Load config
(new Dotenv\Dotenv(__DIR__))->load();

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://api.sncf.com/v1/coverage/sncf/',
    // You can set any number of default request options.
    'timeout'  => 10.0,
    'verify' => false, //do not check certificates
    'auth' => [getenv('SNCF_TOKEN'), ''],
]);

$url = 'traffic_reports';

$response = $client->get('traffic_reports');
$result = json_decode($response->getBody(), true);

echo '<pre>';
print_r($result);