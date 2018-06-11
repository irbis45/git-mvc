<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

define('URL', '/');

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', '***');
define('DB_USER', '***');
define('DB_PASS', '***');

define('SERVER_URL', 'http://' . $_SERVER['HTTP_HOST']);
define("EMAIL_ACTIVATION_FROM_EMAIL", "no-reply@no-reply.com");
define("EMAIL_ACTIVATION_FROM_NAME", "BeeJee test");
define("EMAIL_ACTIVATION_SUBJECT", "Account activation for BeeJee test");
define("EMAIL_ACTIVATION_CONTENT", "Please click on this link to activate your account: ");
