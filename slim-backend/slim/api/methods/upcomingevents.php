<?php
function upcomingevents() {
  $eventControllers = new EventsController();
  $data = $eventControllers->getUpComingEvents();
  echo json_encode($data);
  exit;
}