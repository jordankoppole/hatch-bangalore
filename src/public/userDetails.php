<?php
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
    $list = $userService->getUserList();
    echo json_encode($list);
});

$app->post('/addUserDetails', function (Request $request, Response $response)  use ($app) {
	$getPostData = $request->getParsedBody();

	if (is_array($getPostData))
	{
		global $userService;
		$res = $userService->createUser($getPostData);

		if ($res == USER_CREATED_SUCCESSFULLY)
		{
			$responseVal["error"] = false;
			$responseVal["message"] = "You are successfully registered";
			echoResponse($response, 200, $responseVal);
		}
		else if ($res == USER_CREATE_FAILED)
		{
			$responseVal["error"] = true;
			$responseVal["message"] = "Oops! An error occurred while registereing";
			echoResponse($response, 200, $responseVal);
		}
		else if ($res == USER_ALREADY_EXISTED)
		{
			$responseVal["error"] = true;
			$responseVal["message"] = "Sorry, this email already existed";
			echoResponse($response, 200, $responseVal);
		}
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
		$outPut = $userService->checkLogin($getPostData['emailID'], $getPostData['password']);
		echo json_encode($outPut);
	}
	else
	{
		$responseVal["error"] = true;
		$responseVal["message"] = "Oops! An error occurred while Login";
		echoResponse($response, 200, $responseVal);
	}
});

$app->run();


