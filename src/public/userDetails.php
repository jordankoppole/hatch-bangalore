<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './includes/Utils.php';
require '../services/UserService.php';

$userService = new \Service\UserService();

$app = new \Slim\App;

//Get SLIM config details
$container = $app->getContainer();

$app->get('/getUsers', function (Request $request, Response $response) {
	global $userService;
	$userService->getUserList();
	echoResponse($response, 200, $userService->responseText);
});

$app->post('/addUserDetails', function (Request $request, Response $response)  use ($app) {
	$getPostData = $request->getParsedBody();

	if (is_array($getPostData))
	{
		global $userService;
		$userService->createUser($getPostData);
		echoResponse($response, 200, $userService->responseText);
	}
	else
	{
		$responseVal["error"] = true;
		$responseVal["message"] = "Oops! An error occurred while registereing";
		echoResponse($response, 200, $responseVal);
	}
});

$app->post('/checkLogin', function (Request $request, Response $response) {

	$getPostData = $request->getParsedBody();

	if (is_array($getPostData))
	{
		global $userService;
		$userService->checkLogin($getPostData['emailID'], $getPostData['password']);
		echoResponse($response, 200, $userService->responseText);
	}
	else
	{
		$responseVal["error"] = true;
		$responseVal["message"] = "Oops! An error occurred while Login";
		echoResponse($response, 200, $responseVal);
	}
});

$app->post('/checkUserExists', function (Request $request, Response $response) {

	$getPostData = $request->getParsedBody();

	if (is_array($getPostData))
	{
		global $userService;
		$userService->checkUserExists($getPostData['emailID']);
		echoResponse($response, 200, $userService->responseText);
	}
	else
	{
		$responseVal["error"] = true;
		$responseVal["message"] = "Oops! An error occurred while Login";
		echoResponse($response, 200, $responseVal);
	}
});

$app->run();


