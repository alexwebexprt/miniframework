<?php
$loader =   dirname(__FILE__).'/../app/system/autoload.php';
if(!is_file($loader)) {
    die("App loader not found.");
}
$loader = realpath($loader);
require_once($loader);
$configFile =   BASE_DIR."config".DIRECTORY_SEPARATOR."web.php";
\system\WebApplication::createApplication($configFile)->run();