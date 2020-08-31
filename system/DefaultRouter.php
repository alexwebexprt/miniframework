<?php
namespace system;

/**
 * Default System router
 */
class DefaultRouter implements Router {    
    
    public function handler(WebApplication $aplication) {
        $controller =   "index";
        $action     =   "index";
        if(isset($_REQUEST['task'])) {
            $task   =   trim(strip_tags($_REQUEST['task']));
            if(strlen($task) > 0) {
                $arr    =   explode(".",$task);
                if(count($arr) > 0) {
                    $controller = strtolower($arr[0]);
                }            
                if(count($arr) > 1) {
                    $action = strtolower($arr[1]);
                }
            }
        }        
        $controllerClass    =   $this->dashesToCamelCase($controller,TRUE)."Controller";
        $controllerAction   =   $this->dashesToCamelCase($action,false)."Action";        
        $controller         =   "\\controller\\{$controllerClass}";
        $controllerObjet    =   new $controller();        
        if($controllerObjet instanceof \system\Controller) {
            $controllerObjet->application = $aplication;
            $controllerObjet->init();
            $controllerObjet->$controllerAction();
        } else {
            throw new Exception("Controller must be instanceof \\system\\Controller");
        }
        return true;
    }
    
    public function dashesToCamelCase($string, $capitalizeFirstCharacter = false) {
        $str = str_replace('-', '', ucwords($string, '-'));
        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }
        return $str;
    }
    
}