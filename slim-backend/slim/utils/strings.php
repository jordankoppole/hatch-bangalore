<?php

// Status code
const STATUS_SUCCESS = 200;
const STATUS_SUCCESS_WITH_NO_UPDATE = 204;
const STATUS_FOUND = 302;
const STATUS_BAD_REQUEST = 400;
const STATUS_UNAUTHORIZED = 401;
const STATUS_FORBIDDEN = 403;
const STATUS_NOT_FOUND = 404;
const STATUS_METHOD_NOT_ALLOWED = 405;
const STATUS_APPLICATION_ERROR = 500;
const STATUS_SERVICE_UNAVAILABLE = 503;
const STATUS_INVALID_DATA = 504;

const STATUS_USERNAME_EXIST = 506;
const STATUS_EMAIL_EXIST = 507;
const STATUS_USER_NOT_EXIST = 508;
const STATUS_WRONG_PASSWORD = 509;


// Strings
const PARAM_MISSING = 'parameter missing - %s';
const CREATE_USER_SUCCESS = 'Registration was successful.';
const USER_EXIST = 'This %s is already registered.';
const USER_NOT_EXIST = 'This user doesn\'t exit';
const WRONG_PASSWORD = 'Incorrect password. Please try again.';
const LOGIN_SUCCESSFUL = 'Login was successful';

const PW_RESET_CODE_SENT = 'Please check your email for the reset code.';
const INVALID_RESET_CODE = 'Invalid reset code. Please try again';
const PW_RESET_SUCCESS = 'Password reset was successful.';