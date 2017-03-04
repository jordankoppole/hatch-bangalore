<?php
// R::setup("mysql:host=mysql;dbname=letscreate", getenv('MYSQL_USERNAME'), getenv('MYSQL_ROOT_PASSWORD'));

class AuthController {
  private $response;

  public function __construct() {
    $this->response = new Response();
  }

  public function __destruct() {
  }

  public function authenticate($headers) {
    $this->response->setStatus(STATUS_UNAUTHORIZED);
    $this->response->setMessage(AUTH_TOKEN_MISSING);

    if (!isset($headers['Authorization'])) {
      return false;
    }

    $token = explode(' ', $headers['Authorization']);
    if ($token[0] !== 'Bearer') {
      return false;
    }

    $token = $token[1];

    $sql = 'token = :token AND expiry > NOW()';
    $token_row = R::findOne('tokens', $sql, array(':token' => $token));
    if ($token_row) {
      $token_row->expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
      R::store($token_row);
      return true;
    } else {
      $this->response->setMessage(USER_NOT_AUTHORIZED);
    }
    return false;
  }

  public function getResponse() {
    $this->response->getResponse();
  }
}