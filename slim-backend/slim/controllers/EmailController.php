<?php

class EmailContolller {

  // const HOST = 'email-smtp.us-west-2.amazonaws.com';
  // const USER_NAME = 'AKIAJHHM4LBOTGFPQN3A';
  // const PASSWORD = 'AiJvYUis0HHOBERLP1RUqBEn5fd9tQbLTriqN6eza7bO';

  const HOST = 'smtp.mailgun.org';
  const USER_NAME = 'postmaster@thebongdiary.in';
  const PASSWORD = '32113f129ef04b883fe2443a0d429d00';

  const PORT = '587';

  private $from = 'admin@letscreate.co';
  private $mail = null;

  public function __construct() {
    $this->mail = new PHPMailer;
    $this->mail->isSMTP();
    $this->mail->Host = self::HOST;
    $this->mail->SMTPAuth = true;
    $this->mail->Username = self::USER_NAME;
    $this->mail->Password = self::PASSWORD;
    $this->mail->SMTPSecure = 'tls';
    $this->mail->Port = self::PORT;
    $this->mail->isHTML(true);
    $this->mail->setFrom($this->from, 'Letscreate Admin');
    $this->mail->addReplyTo($this->from, 'Letscreate Admin');
  }

  public function __destruct() {

  }

  public function setRecipients($emailArr) {
    foreach ($emailArr as $value) {
        $this->mail->addAddress($value);
    }
  }

  public function setSender($from) {
    $this->mail->setFrom($from, 'Letscreate Admin');
    $this->mail->addReplyTo($from, 'Letscreate Admin');
  }

  public function setSubject($subject) {
    $this->mail->Subject = $subject;
  }

  public function setBody($body) {
    $this->mail->Body = $body;
  }

  public function sendMail() {
    if (!$this->mail->send()) {
      error_log('There is some error with the email' . $mail->ErrorInfo);
      return false;
    } else {
      return true;
    }
  }

}