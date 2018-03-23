<?php
include 'vendor/autoload.php';
use GuzzleHttp\Client;
use Elasticsearch\ClientBuilder;

//Load config
(new Dotenv\Dotenv(__DIR__))->load();

$clientSncf = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://api.sncf.com/v1/coverage/sncf/',
    // You can set any number of default request options.
    'timeout'  => 10.0,
    'verify' => false, //do not check certificates
    'auth' => [getenv('SNCF_TOKEN'), ''],
]);

$clientElastic = ClientBuilder::create()->build();

//print_r($result);