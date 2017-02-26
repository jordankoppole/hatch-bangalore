<?php

require_once './../includes.php';
require_once 'EmailController.php';

$mail = new EmailContolller();

$mail->setRecipients(['sanborn.sen@gmail.com']);
$mail->setSubject('Test');
$mail->setBody('This is a test message.');
if ($mail->sendMail()) {
  echo "email sent \n";
} else {
  echo "Damn man !! \n";
}