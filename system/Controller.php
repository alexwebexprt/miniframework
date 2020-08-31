<?php
namespace system;

use Exception;
class Controller {    
    /**
     * @var WebApplication
     */
    public $application;      
    /**
     *
     * @var array
     */
    public $data    =   [];
    /**
     *
     * @var string 
     */
    public $layout  =   "";
    
    public function init() {        
        
    }
    
    
    public function redirect($url,$permanent = true) {
        $this->getApplication()->redirect($url, $permanent);
    }
    
    public function createModel($modelName) {
        $modelName  =   trim($modelName);
        $modelName  =   ucfirst($modelName);
        $modelName  =   "\\model\\".$modelName."Model";
        
        $model  =  new $modelName($this->db);
        if($model instanceof \system\Model) {
            $model->setDb($this->db);
            $model->setApplication($this->getApplication());
            $model->setConfig($this->getApplication()->getConfig());
        }
        return $model;
    }
    
    function getLayout() {
        return $this->layout;
    }

    function setLayout($layout) {
        $this->layout = $layout;
    }

        
    function getData() {
        return $this->data;
    }

    function setData($data) {
        $this->data = $data;
    }        
    function getApplication(): WebApplication {
        return $this->application;
    }
    function setApplication(WebApplication $application) {
        $this->application = $application;
    }    
    public function __get ( string $name ) {        
        if(isset($this->getApplication()->getComponent()[$name]))
            return $this->getApplication()->getComponent()[$name];
        return null;
    }    
    public function __call($name, $arguments) {
        throw new Exception("Method: ".$name." not found in ".get_called_class()." with arguments:". print_r($arguments,true));
    }
    public function log($msg,$level = Logger::INFO) {
        $this->application->getLogger()->log($msg,$level);
    }
    
    private function getTemplateFile($view) {
        $viewPath   =   trim($view);
        $viewPath   =   str_replace("\\", DIRECTORY_SEPARATOR,$viewPath);        
        $viewPath   =   str_replace(":", DIRECTORY_SEPARATOR,$viewPath);
        $viewPath   =   str_replace("/", DIRECTORY_SEPARATOR,$viewPath);
        $viewPath   =   $viewPath . ".php";
        if(substr($viewPath, 0,1) == DIRECTORY_SEPARATOR) {
            $viewPath   =   substr($viewPath, 1);
        }
        $path  = VIEW_DIR.$viewPath;
        return $path;
    }
    
    private $tmpData  = [];
    /**
     * 
     * @param string $view
     * @param array $data
     * @param boolean $useLayout
     * @return string
     * @throws Exception
     */
    private  function renderHtml($view,$data,$useLayout  =  true) {                
        if(is_array($data) == false)
            $data = [];
        $this->tmpData = $data;
        extract($data);
        
        $controllerTemplatePath  = $this->getTemplateFile($view);
        if(!is_file($controllerTemplatePath)) {
            throw new Exception("View [ {$view} ] : {$controllerTemplatePath} not exists.");
        }        
        ob_start();
        require($controllerTemplatePath);
        $out    =    ob_get_clean();
        
        
        $layout  =  trim($this->getLayout());
        if(strlen($layout) > 0 && $useLayout) {
            $layout = $layout.".php";
            $controllerTemplatePath  = VIEW_DIR."layout".DIRECTORY_SEPARATOR.$layout;
            $layoutData  = $this->tmpData;
            $layoutData['layoutContent'] = $out;            
            extract($layoutData);
            ob_start();
                require($controllerTemplatePath);
            $out    =    ob_get_clean();
            return $out;
        }
        return $out;
    }
    
    /**
     * Return html template
     * @param string $view
     * @param array $data
     * @return string
     */
    public function renderPartial($view,$data = null) {
        if($data == null)
            $data = $this->data;
        return    $this->renderHtml($view, $data,false);
    }  
    
    /**
     * Return html template with layout
     * @param string $view
     * @param array $data
     * @return string
     */
    public function render($view,$data = null,$return = false) {
        if($data == null)
            $data = $this->data;
        $out    =    $this->renderHtml($view, $data,true);        
        if(!$return) {
            if(!headers_sent())
                header('Content-Type: text/html; charset=utf-8');
            print $out;
        }
        return $out;
    }  
    
    public function renderJson($data = null) {
        
    }
    
    public function error($message) {       
        $this->renderHtml("error/error");
        $this->application->close();
    }
    
    
}