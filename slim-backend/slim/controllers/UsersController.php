<?php
// R::setup("mysql:host=mysql;dbname=letscreate", getenv('MYSQL_USERNAME'), getenv('MYSQL_ROOT_PASSWORD'));

class UsersController {
  private $response;
  public function __construct() {
    $this->response = new Response();
    $this->response->setStatus(STATUS_SUCCESS);
  }

  public function __destruct() {

  }

  public function getActiveUsers() {
    $sql = "SELECT
              `users`.`firstname`,
              `users`.`lastname`,
              `media`.`url` as `display_picture`,
              `role`.`name` as `role`
            FROM `users`, `media`, `role`
            WHERE `users`.`display_picture` = `media`.`id`
            AND `users`.`role_id` = `role`.`id`
            ORDER BY `users`.`activity_score` DESC
            LIMIT 20";
    return R::getAll($sql);
  }

  public function createUser($params) {
    $user = R::findOne(
      'users',
      'email=:email OR username=:username',
      array(
        'email' => $params['email'],
        'username' => $params['username']
      )
    );
    if ($user) {
      if ($user['email'] == $params['email']) {
        $this->response->setStatus(STATUS_EMAIL_EXIST);
        $this->response->setMessage(sprintf(USER_EXIST, 'email'));
      } else {
        $this->response->setStatus(STATUS_USERNAME_EXIST);
        $this->response->setMessage(sprintf(USER_EXIST, 'username'));
      }
    } else {
      $newUser = R::dispense('users');
      foreach($params as $key => $value) {
        $newUser->{$key} = $value;
      }
      $newUser->display_picture = 0;
      R::store($newUser);
      $this->response->setMessage(CREATE_USER_SUCCESS);
    }
    return $this->response;
  }
}