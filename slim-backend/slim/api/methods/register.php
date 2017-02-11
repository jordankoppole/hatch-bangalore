<?php

function register() {
  $params = [];
  $usersControllers = new UsersController();
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata, true);
  $_REQUEST = $request;
  // echo "This is a test API";
  $response = new Response();
  $response->setStatus(STATUS_INVALID_DATA);

  $validParams = [
    'firstname',
    'lastname',
    'username',
    'password',
    'email'
  ];
  $params = [];
  for($i = 0; $i < sizeof($validParams); $i++) {
    if (!isset($_REQUEST[$validParams[$i]])) {
      $response->setMessage(sprintf(PARAM_MISSING, $validParams[$i]));
      $response->getResponse();
    } else {
      $params[$validParams[$i]] = $_REQUEST[$validParams[$i]];
    }
  }
  $response->reset();
  $usersControllers->createUser($params)->getResponse();
}