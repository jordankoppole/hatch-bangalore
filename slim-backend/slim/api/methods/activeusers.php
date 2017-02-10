<?php
function activeusers() {
  $eventControllers = new EventsController();
  $data = $eventControllers->getActiveUsers();
  echo json_encode($data);
  exit;
}