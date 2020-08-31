<?php
namespace controller;

use Exception;
use system\Logger;
use system\Controller;

class ProfileController extends Controller {
    
    
    public $userModel  = null;
    public function init() {
        parent::init();
        $this->setLayout("default");
        $this->userModel = $this->createModel("user");
        if(! $this->userModel->isLogged()) {
            $this->redirect("/?task=index.index");
        }        
        $this->data['user'] = $this->userModel->logged();
    }    
    
    public function indexAction() {
        $saved = (int)filter_input(INPUT_GET,"saved",FILTER_SANITIZE_NUMBER_INT);
        if($saved) {
            $this->data['message'] =  "Account successfully updated.";
        }
        return $this->render("profile/index");
    }
    
    public function exitAction() {
        unset($_SESSION['user']);
        $this->redirect("/?task=index.index");
    }
    public function updateAction() {
        try {
            if(!empty($_POST)) {
                $email  =   trim(filter_input(INPUT_POST,"email",FILTER_SANITIZE_STRIPPED|FILTER_SANITIZE_EMAIL));
                if(empty($email)) {
                    throw new Exception("Please enter E-mail.");
                }                
                $email  =   filter_var($email, FILTER_VALIDATE_EMAIL);
                if(empty($email)) {
                    throw new Exception("Please enter correct E-mail.");
                }                
                $name  =   trim(filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRIPPED));
                if(empty($name) || strlen($name) < 3) {
                    throw new Exception("Please enter Name. Min 3 characters.");
                }
                
                $password  =   trim(filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRIPPED));
                
                if(strlen($password) > 0 && strlen($password) < 4) {
                    throw new Exception("Please enter password. Min 4 characters.");
                }
                $password2  =   trim(filter_input(INPUT_POST,"password2",FILTER_SANITIZE_STRIPPED));
                if(strlen($password2) > 0 && strlen($password2) < 4) {
                    throw new Exception("Please enter confirm password. Min 4 characters.");
                }                
                if((strlen($password) > 0 || strlen($password2) > 0)  && strcmp($password, $password2) !== 0) {
                    throw new Exception("Please enter correct password and confirm password.");
                }
                
                $newUser  =  $this->userModel->getByEmail($email);
                if(empty($newUser) == false && $newUser->id != $this->data['user']->id) {
                    throw new Exception ("User [{$email}] already exists.");
                }                
                $user  = $this->userModel->updateAccount($email,$name,$password);
                if(empty($user) == false) {
                    $this->redirect("/?task=profile.index&saved=1");
                }
                
                
            }
        } catch (Exception $e) {
            $this->data['error'] =  $e->getMessage();
        }
        return $this->render("profile/index");
    }
    
}
