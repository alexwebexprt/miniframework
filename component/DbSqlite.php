<?php
namespace component;
use PDO;
use Exception;

class DbSqlite extends PDO implements Component {    
    public $config = null;
    
    public function __construct($config) {
        parent::__construct($config);
    }
    
    public static function init($config) {
        if(!isset($config['path']))
            throw new Exception("DbSqlite config error. Path not found.");
        $path   =   $config['path'];
        $dir    =   dirname($path);
        if(!is_dir($dir)) {
            @mkdir($dir,0777);
            @chmod($dir, 0777);
        }
        if(!is_dir($dir)) {
            throw new Exception("DbSqlite config error. Can't create directory ".$dir);
        }        
        $connection =   'sqlite:'.trim($path);
        $db  =  new self($connection);
        $db->config = $config;
        return $db;
    }

    public function afterInit($config) {
        if(isset($config['sql']) && is_array($config['sql'])) {
            foreach ($config['sql'] as $sql) {
                $sth = $this->prepare($sql);
                $sth->execute();
            }
        }
    }

}