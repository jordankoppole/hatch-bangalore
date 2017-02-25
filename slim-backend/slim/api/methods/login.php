<?php

function login() {
  $params = [];
  // $postdata = file_get_contents("php://input");
  // $request = json_decode($postdata, true);
  // $_REQUEST = $request;
  // error_log(json_encode(getallheaders()));
  $headers = getallheaders();
  $response = new Response();
  $response->setStatus(STATUS_INVALID_DATA);
  if (isset($headers['Authorization'])) {
    $auth = base64_decode(
      end(
        explode(' ', $headers['Authorization'])
      )
    );
    $_REQUEST = json_decode($auth, true);
    $validParams = [
      'username',
      'password'
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
    $usersControllers = new UsersController();
    $usersControllers->login($params)->getResponse();
  } else {
    $response->getResponse();
  }

}