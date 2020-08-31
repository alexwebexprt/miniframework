<?php
namespace component;
use Exception;
interface Component  {
    public static function init($config);
    public function afterInit($config);
    
}