<?php
ob_start();
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");

require_once(dirname(__FILE__).'/../includes.php');

// use Psr\Http\Message\ServerRequestInterface;
// use Psr\Http\Message\ResponseInterface;

$app = new \Slim\App(array(
    'cookies.encrypt' => false,
    'log.enable' => false,
    'session.handler' => null
));

$apiName = "Letscreate";
$apiRouter = "methods";
$apiVersion = "1.0";

$publicUris = [
  'testapi',
  'upcomingevents',
  'activeusers'
];


$apiUrl = parse_url($_SERVER['REQUEST_URI']);
$apiUri = end(explode('/', $apiUrl['path']));

if (in_array($apiUri, $publicUris)) {
  require_once(dirname(__FILE__).'/'.$apiRouter.'/'.$apiUri.'.php');
}

R::setup("mysql:host=mysql;dbname=letscreate", getenv('MYSQL_USERNAME'), getenv('MYSQL_ROOT_PASSWORD'));

/**
 * API End-points definition
**/
$app->get('/testapi',               function () { echo testapi(); });
$app->get('/upcomingevents',        function () { echo upcomingevents(); });
$app->get('/activeusers',           function () { echo activeusers(); });

/**
 * Run the Requested API End-point
**/
$app->run();

ob_end_flush();
