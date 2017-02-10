<?php
// R::setup("mysql:host=mysql;dbname=letscreate", getenv('MYSQL_USERNAME'), getenv('MYSQL_ROOT_PASSWORD'));

class EventsController {
  public function __construct() {

  }

  public function __destruct() {

  }

  public function getUpComingEvents() {
    $sql = "SELECT * FROM `events` WHERE start_date > CURDATE() ORDER BY start_date DESC LIMIT 20";
    return R::getAll($sql);
  }

  public function getActiveUsers() {
    $sql = "SELECT
              `users`.`firstname`,
              `users`.`lastname`,
              `media`.`url` as `display_picture`
            FROM `users`, `media`
            WHERE `users`.`display_picture` = `media`.`id`
            ORDER BY `users`.`activity_score` DESC
            LIMIT 20";
    return R::getAll($sql);
  }
}