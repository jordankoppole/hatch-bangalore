<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../services/UserService.php';
 
$userService = new \Service\UserService();

$app = new \Slim\App;
//$app->response->headers->set('Content-Type', 'application/json');
//$app->get('/users', 'getUserList');

$app->get('/users', 'getUserList', function (Request $request, Response $response) {
    // $name = $request->getAttribute('name');
    // $response->getBody()->write("Hello, $name");

    // return $response;
});

$app->post('/users/add', 'addUser');
 
$app->run();
 
function getUserList() {
    global $userService;
    $list = $userService->getUserList();
    echo json_encode($list);
}

function addUser() {
    global $userService;
    $return = $userService->addUser();
    echo json_encode($return);
}