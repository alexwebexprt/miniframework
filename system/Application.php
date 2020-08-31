<?php
namespace system;

abstract class Application {
    
    /**
     *
     * @var Loger
     */
    protected $logger   =   null;    
    protected function __construct() {        
        $this->logger  =  new Logger();
    }
    /**
     *
     * @var array 
     */
    public $config  = [];
    
    /**
     *
     * @var array
     */
    public $component   =   [];
    
    public static function createApplication($configFile) {
        $class          =   get_called_class();
        
        $app            =   new $class();
        $config         =   [];
        if(!is_file($configFile)) {
            $app->getLogger()->log("Application config file [{$configFile}] not exists.",Logger::ERROR);
        } else {
            $config         =   require($configFile);
        }
        $app->config    =   $config;        
        $app->loadComponents();
        return $app;
    }
    
    public function loadComponents() {
        $config =   $this->getConfig();
        if(!isset($config['component']))
            return false;        
        if(!is_array($config['component']))
            return false;
        
        foreach ($config['component'] as $key=>$info) {
            $class  = isset($info['class']) ? trim($info['class']) : "";
            if(empty($class))
                continue;
            
            
            $obj    =   $class::init($info);
            if(empty($obj)) {
                throw new Exception("{$class}::init return null");
            }
            $obj->afterInit($info);            
            $this->component[$key]  =   $obj;
        }
    }
    
    function getComponent() {
        return $this->component;
    }

    function setComponent($component) {
        $this->component = $component;
    }

    public abstract function run($config = null);
    
    public function getConfig() {
        return $this->config;
    }
    public function log($message,$level  =  Logger::INFO) {
        $this->getLogger()->log($msg, $level);
    }    
    function getLogger(): Logger {
        return $this->logger;
    }
    function setLogger(Logger $logger) {
        $this->logger = $logger;
    }
}