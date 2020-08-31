<?php
namespace system;

use PDO;
use Exception;
abstract class Model {    
    /**
     * @var WebApplication
     */
    public $application;
    /**
     *
     * @var array 
     */
    public $config;
    
    /**
     *
     * @var PDO
     */
    public $db;
    
    public abstract function tablename();
    
    function getApplication(): WebApplication {
        return $this->application;
    }

    function getConfig() {
        return $this->config;
    }

    function getDb(): PDO {
        return $this->db;
    }

    function setApplication(WebApplication $application) {
        $this->application = $application;
    }

    function setConfig($config) {
        $this->config = $config;
    }

    function setDb(PDO $db) {
        $this->db = $db;
    }


    
}