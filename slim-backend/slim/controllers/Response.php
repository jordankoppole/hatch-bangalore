<?php

class Response {
  private $response;

  public function __construct() {
    $this->response = array(
      'status' => STATUS_SUCCESS,
      'message' => '',
      'data' => null
    );
  }

  public function __destruct() {

  }

  public function setStatus($statusCode) {
    $this->response['status'] = $statusCode;
  }

  public function setMessage($message) {
    $this->response['message'] = $message;
  }

  public function setData($data) {
    $this->response['data'] = $data;
  }

  public function reset() {
    $this->__construct();
  }

  public function getResponse() {
    echo json_encode($this->response);
    exit;
  }

}