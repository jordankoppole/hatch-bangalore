<?php
ob_start();

require_once(dirname(__FILE__).'/../includes.php');

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app = new \Slim\App(array(
    'cookies.encrypt' => false,
    'log.enable' => false,
    'session.handler' => null
));

$apiName = "Letscreate";
$apiRouter = "methods";
$apiVersion = "1.0";

$publicUris = [
  'testapi'
];


$apiUrl = parse_url($_SERVER['REQUEST_URI']);
$apiUri = end(explode('/', $apiUrl['path']));

if (in_array($apiUri, $publicUris)) {
  require_once(dirname(__FILE__).'/'.$apiRouter.'/'.$apiUri.'.php');
}
error_log(getenv('MYSQL_USERNAME'));
error_log(getenv('MYSQL_ROOT_PASSWORD'));
R::setup("mysql:host=mysql;dbname=letscreate", getenv('MYSQL_USERNAME'), getenv('MYSQL_ROOT_PASSWORD'));

$fields = R::inspect('test');
error_log(json_encode($fields));
/**
 * API End-points definition
**/
$app->get('/testapi',               function () { echo testapi(); });

/**
 * Run the Requested API End-point
**/
$app->run();

ob_end_flush();
