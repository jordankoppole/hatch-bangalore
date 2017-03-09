<?php

class BeanController {
  public function __construct() {

  }

  public function __destruct() {

  }

  public function converBeanToArray($data) {
    $newArr = [];
    foreach ($data as $key => $value) {
      array_push($newArr, $value);
    }
    return $newArr;
  }
}