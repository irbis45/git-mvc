<?php

require 'app/config/config.php';
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

require 'app/config/autoload.php';

Logger::getInstance();
Validator::getInstance();

$app = new Application();
