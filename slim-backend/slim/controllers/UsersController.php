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
            LIMIT 6";
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

      // Send email to the user
      $mail = new EmailContolller();
      $mail->setRecipients([$newUser->email]);
      $mail->setSubject('Welcome to Letscreate');
      $mail->setBody('<h1> Welcome </h1><p> Thank you for getting on board with us</p>');
      $mail->sendMail();

      $this->response->setMessage(CREATE_USER_SUCCESS);
    }
    return $this->response;
  }

  public function login($params) {
    $user = $this->getUserByEmailOrUsername($params);

    if ($user) {
      if ($user->password === md5($params['password'])) {
        $newToken = R::dispense('tokens');
        $newToken->user_id = $user->id;
        $newToken->token = $this->getToken(64);
        $newToken->expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        R::store($newToken);
        $user->last_loggedin = date('Y-m-d H:i:s');
        $user->activity_score += 1;
        R::store($user);
        $this->response->setStatus(STATUS_SUCCESS);
        $this->response->setMessage(LOGIN_SUCCESSFUL);
        $this->response->setData(['token' => $newToken->token]);
      } else {
        $this->response->setStatus(STATUS_WRONG_PASSWORD);
        $this->response->setMessage(WRONG_PASSWORD);
      }
    } else {
      $this->response->setStatus(STATUS_USER_NOT_EXIST);
      $this->response->setMessage(USER_NOT_EXIST);
    }
    return $this->response;
  }

  public function requestCode($params) {
    $user = $this->getUserByEmailOrUsername($params);

    if ($user) {
      $code = mt_rand(100000, 999999);
      if ($user->pw_reset_code) {
        $code_arr = json_decode($user->pw_reset_code, true);
        array_push($code_arr, $code);
      } else {
        $code_arr = [$code];
      }
      $user->pw_reset_code = json_encode($code_arr);
      R::store($user);

      // Send the email to the user with new code
      $mail = new EmailContolller();
      $mail->setRecipients([$user->email]);
      $mail->setSubject('Letscreate :: Change password code');
      $mail->setBody('<h3>Password recovery code</h3>
                    <p>Your recovery code is: <strong>'.$code.'</strong></p>');
      $mail->sendMail();

      $this->response->setStatus(STATUS_SUCCESS);
      $this->response->setMessage(PW_RESET_CODE_SENT);
    } else {
      $this->response->setStatus(STATUS_USER_NOT_EXIST);
      $this->response->setMessage(USER_NOT_EXIST);
    }
    return $this->response;
  }

  public function changePassword($params) {
    $user = $this->getUserByEmailOrUsername($params);

    if ($user) {
      $code_arr = json_decode($user->pw_reset_code, true);
      if (in_array($params['resetcode'], $code_arr)) {

        $user->password = $params['password'];
        $user->pw_reset_code = null;
        R::store($user);

        // Send the email to the user about password change
        $mail = new EmailContolller();
        $mail->setRecipients([$user->email]);
        $mail->setSubject('Letscreate :: Change password');
        $mail->setBody('<h3>Password recovery</h3>
                      <p>Your password was changed successfully.</p>');
        $mail->sendMail();

        $this->response->setStatus(STATUS_SUCCESS);
        $this->response->setMessage(PW_RESET_SUCCESS);
      } else {
        $this->response->setStatus(STATUS_INVALID_DATA);
        $this->response->setMessage(INVALID_RESET_CODE);
      }
    } else {
      $this->response->setStatus(STATUS_USER_NOT_EXIST);
      $this->response->setMessage(USER_NOT_EXIST);
    }
    return $this->response;
  }

  public function getUserByEmailOrUsername($params) {
    return R::findOne(
      'users',
      'email=:email OR username=:username',
      array(
        'email' => $params['username'],
        'username' => $params['username']
      )
    );
  }

  private function getToken($length) {
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
    }

    return $token;
  }

  private function crypto_rand_secure($min, $max) {
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
  }
}