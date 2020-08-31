<?php
namespace system;
class WebApplication extends Application {
    
    protected function __construct() {
        parent::__construct();
    }
    
    public function run($config = null) {
        if(is_array($config) && empty($config) == false) {
            $this->config  = $config;
        }
        if(is_array($this->config) == false)
            $this->getLogger ()->log ("Config is empty", Logger::ERROR);
        if(!isset($this->config['routes'])) {
            $this->getLogger ()->log ("Config [routes] not exists", Logger::ERROR);
        }        
        $this->getLogger()->log("//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],Logger::INFO);
        $routes  =  (is_array($this->config['routes'])) ? $this->config['routes'] : [];
        foreach ($routes as $rClass) {
            try {
                $router  =  new $rClass();
                if($router->handler($this))
                    return true;
            } catch(Exception $e) {
                $this->getLogger()->log($e->getMessage());
            }
        }
    }
    
    public function redirect($url,$permanentm  =  true) {        
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        $this->close();
    }
    
    public function close() {        
        flush();
        exit;
    }
    
}