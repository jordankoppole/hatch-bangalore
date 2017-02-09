<?php
function upcomingevents($response) {
  $eventControllers = new EventsController();
  $data = $eventControllers->getUpComingEvents();
  return $response->withJson($data)->withHeader('Content-type', 'application/json')->withStatus(201);
  // echo "This is a test API";
}