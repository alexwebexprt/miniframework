<?php
@session_start();
$BASE_DIR  = dirname(__DIR__).DIRECTORY_SEPARATOR;
define('BASE_DIR',$BASE_DIR);

set_include_path(get_include_path().PATH_SEPARATOR.BASE_DIR);
spl_autoload_extensions('.php');
//spl_autoload_register();

spl_autoload_register(function ($class) {
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    include BASE_DIR. $class . '.php';
});


$runtimePath  =  BASE_DIR."runtime".DIRECTORY_SEPARATOR;
define('RUNTIME_DIR',$runtimePath);

if(!is_dir(RUNTIME_DIR)) {
    @mkdir(RUNTIME_DIR,0777);
    @chmod(RUNTIME_DIR,0777);
}
if(!is_dir(RUNTIME_DIR)) {
    die("Can't create runtime directory: ".RUNTIME_DIR);
}

$logPath  =  BASE_DIR."runtime".DIRECTORY_SEPARATOR."log".DIRECTORY_SEPARATOR;
define('LOG_DIR',$logPath);
if(!is_dir($logPath)) {
    @mkdir($logPath,0777);
    @chmod($logPath,0777);
}
if(!is_dir($logPath)) {
    die("Can't create log directory: ".$logPath);
}
$vewPath  =  BASE_DIR."view".DIRECTORY_SEPARATOR;
define('VIEW_DIR',$vewPath);
