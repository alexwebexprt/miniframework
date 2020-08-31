<?php
namespace system;
class Logger  {    
    
    const ERROR = "error";
    const INFO  = "info";
    const DEBUG = "debug";
    
    public $logFile         =   LOG_DIR."system.log";
    public $defaultLevel    =   "info";
    public function log($msg,$level = '') {
        if(empty($level))
            $level  =  $this->defaultLevel;
        $ip  =  $this->getClientIp();
        $logMessage  =  date("c")." ".$level." ".$msg."\t\tIp:".$ip;
        @file_put_contents($this->logFile,$logMessage. PHP_EOL, FILE_APPEND);
        @file_put_contents('php://stdout',$logMessage. PHP_EOL, FILE_APPEND);
    }    
    
    protected function getClientIp() {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_CLIENT_IP']) && empty($_SERVER['HTTP_CLIENT_IP']) == false) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset ($_SERVER['HTTP_X_FORWARDED_FOR']) &&   empty($_SERVER['HTTP_X_FORWARDED_FOR']) == false) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $ips  =  explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
            if(count($ips) > 1) {
                $ip  = $ips[0];
            }
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    
    
    function getLogFile() {
        return $this->logFile;
    }

    function getDefaultLevel() {
        return $this->defaultLevel;
    }

    function setLogFile($logFile) {
        $this->logFile = $logFile;
    }

    function setDefaultLevel($defaultLevel) {
        $this->defaultLevel = $defaultLevel;
    }

        
    
}