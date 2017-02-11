<?php
function activeusers() {
  $usersControllers = new UsersController();
  $data = $usersControllers->getActiveUsers();
  echo json_encode($data);
  exit;
}