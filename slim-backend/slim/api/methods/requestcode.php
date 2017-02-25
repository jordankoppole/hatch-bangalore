<?php

function requestcode() {
  $params = [];
  $usersControllers = new UsersController();
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata, true);
  $_REQUEST = $request;

  $response = new Response();
  $response->setStatus(STATUS_INVALID_DATA);

  $validParams = [
    'username'
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
  $usersControllers->requestCode($params)->getResponse();
}