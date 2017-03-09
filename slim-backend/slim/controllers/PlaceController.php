<?php
// R::setup("mysql:host=mysql;dbname=letscreate", getenv('MYSQL_USERNAME'), getenv('MYSQL_ROOT_PASSWORD'));

class PlaceController {
  private $response;
  private $beanClass;
  public function __construct() {
    $this->response = new Response();
    $this->beanClass = new BeanController();
    $this->response->setStatus(STATUS_SUCCESS);
  }

  public function __destruct() {

  }

  public function getPlaces() {
    $countries = $this->beanClass->converBeanToArray(R::findAll('country'));
    for ($i = 0; $i < sizeof($countries); $i++) {
      $countries[$i]['states'] = $this->beanClass->converBeanToArray(R::find(
        'state',
        'country_id = :country_id',
        array(
          'country_id' => $countries[$i]['id']
        )));
      for ($j = 0; $j < sizeof($countries[$i]['states']); $j++) {
        $countries[$i]['states'][$j]['cities'] = $this->beanClass->converBeanToArray(R::find(
          'city',
          'state_id = :state_id',
          array(
            'state_id' => $countries[$i]['states'][$j]['id']
          )));
      }
    }
    $this->response->setData($countries);
    return $this->response;
  }
}