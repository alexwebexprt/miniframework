<?php
namespace model;

use Exception;
use system\Model;
class UserModel extends Model {
    public function tablename() {
        return "users";
    }
    
    public function confirmAccount($code) {
        $sql = "UPDATE ".$this->tablename()." "
                . "SET status = 1 "
                . "WHERE code = :code";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(":code", $code);
        $res    =   $stm->execute();
        $sql  =  "select * from ".$this->tablename()." where code=:code AND status=1 limit 1";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(":code", $code);
        $res    =   $stm->execute();
        $user   =   $stm->fetchObject();
        return $user;
    }
    
    public function login($email,$password) {
        $email     =    trim(strtolower($email));
        $password  =    md5($password);
        
        $sql  =  "select * from ".$this->tablename()." where email=:email AND password=:password AND status=:status limit 1";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(":email", $email);
        $stm->bindValue(":password", $password);
        $stm->bindValue(":status","1");
        $res    =   $stm->execute();
        $user   =   $stm->fetchObject();
        if(empty($user))
            throw new Exception ("User [{$email}] not found or password incorrect.");
        $_SESSION['user'] = $user;
        return true;
    }
    
    
    public function getByEmail($email) {
        $email     =    trim(strtolower($email));
        $sql  =  "select * from ".$this->tablename()." where email=:email limit 1";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(":email", $email);
        $stm->execute();
        $user  = $stm->fetchObject();
        return $user;
    }
    
    public function exists($email) {
        $user  =  $this->getByEmail($email);
        if(empty($user) == false && $user->id > 0)
            return true;
        return false;
    }
    
    public function register($name,$email,$password) {        
        $email     =    trim(strtolower($email));
        $password  =    md5($password);
        if($this->exists($email)) {
            throw new Exception ("User [{$email}] already exists.");
        }
        $this->db->beginTransaction();
        $sql  =  "insert into ".$this->tablename()."  (email,password,name,status,token,code) VALUES (:email,:password,:name,:status,:token,:code)";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(":email", $email);
        $stm->bindValue(":password", $password);
        $stm->bindValue(":status","0");
        $stm->bindValue(":name",$name);
        $stm->bindValue(":token",$this->createToken());
        $stm->bindValue(":code", uniqid());
        $res  = $stm->execute();
        $this->db->commit();
        
        $sql  =  "select * from ".$this->tablename()." where email=:email limit 1";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(":email", $email);
        $stm->execute();
        $user  = $stm->fetchObject();
        return $user;
    }
    
    public function updateAccount($email,$name,$password = "") {
        $old  =  $this->logged();
        if(empty($old))
            throw new Exception("Error. Account information not saved.");
        
        if(strlen($password) > 3) {
            $password  = md5($password);
        } else {
            $password =  $old->password;
        }
        
        $sql = "UPDATE ".$this->tablename()." "
                . "SET email = :email,  name = :name, password = :password WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(":email", $email);
        $stm->bindValue(":name",$name);
        $stm->bindValue(":password", $password);
        $stm->bindValue(":id",$old->id);
        $res    =   $stm->execute();
        $sql  =  "select * from ".$this->tablename()." where id=:id limit 1";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(":id", $old->id);
        $res    =   $stm->execute();
        $user   =   $stm->fetchObject();
        if(empty($user))
            throw new Exception("Error. Account information not saved.");
        
        $_SESSION['user'] = $user;
        return $user;
    }
    

    public function logged() {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }
    public function isLogged() {
        $user  = $this->logged();
        if(empty($user) == false && $user->id > 0) {
            return true;
        }
        return false;
    }
    
    public function createToken() {
        return uniqid()."-".uniqid()."-".uniqid();
    }
    
}