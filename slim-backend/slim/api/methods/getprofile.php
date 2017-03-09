<?php
function getprofile() {
  global $authUserID;
  $userClass = new UsersController();
  $userClass->getProfile();
}