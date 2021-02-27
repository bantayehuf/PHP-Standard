<?php
session_start();
//To hide php errors from the browser
error_reporting(1);

define('APP_NAME', "S.R.E PHP Coding Standard");
define('APP_DIR', dirname(__DIR__));
define('LOG_FILE_PATH', APP_DIR . "/logs/.log");

//Autoloading allows to include class automatically, instead of include or require PHP files in each script
require_once  APP_DIR . '/vendor/autoload.php';
