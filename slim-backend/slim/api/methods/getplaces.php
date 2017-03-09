<?php

function getplaces(){
  $placeClass = new PlaceController();
  $placeClass->getPlaces()->getResponse();
}