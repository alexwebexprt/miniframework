<?php
namespace controller;

use Exception;
use system\Logger;
use system\Controller;

class IndexController extends Controller {
    
    
    public $userModel  = null;
    public function init() {
        parent::init();
        $this->setLayout("default");
        $this->userModel = $this->createModel("user");;
    }    
    
    public function indexAction() {      
        
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
                $password  =   trim(filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRIPPED));
                if(empty($password) || strlen($password) < 4) {
                    throw new Exception("Please enter password.");
                }
                if($this->userModel->login($email,$password)) {
                    $this->redirect("/?task=profile");
                }
            }
        } catch (Exception $e) {
            $this->data['error'] =  $e->getMessage();
        }
        return $this->render("index/index");
    }
    
    public function registerAction() {
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
                $password  =   trim(filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRIPPED));
                if(empty($password) || strlen($password) < 4) {
                    throw new Exception("Please enter password. Min 4 characters.");
                }
                
                $name  =   trim(filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRIPPED));
                if(empty($name) || strlen($name) < 3) {
                    throw new Exception("Please enter Name. Min 3 characters.");
                }
                $user  = $this->userModel->register($name,$email,$password);
                if(empty($user) == false && $user->id > 0) {
                    $this->data['message'] = "Account [{$email}] created successfully. Please check your email.";
                    
                    $url  =  "//".$_SERVER['HTTP_HOST']."/?".
                            http_build_query([
                                'task'=>'index.confirm',
                                'code'=>$user->code
                            ]);
                    $data = [
                        "name"=>$user->name,
                        "email"=>$user->email,
                        "password"=>$password,
                        "code"=>$user->code,
                        "url"=>$url
                    ];
                    $message  = $this->renderPartial("mail/register",$data);
                    $this->mailer->send($user->email,"Account [{$email}] created successfully",$message);
                }
            }
        } catch (Exception $e) {
            $this->data['error'] =  $e->getMessage();
        }
        return $this->render("index/register");
    }
    
    public function confirmAction() {
        try {
            $code  =   trim(filter_input(INPUT_GET,"code",FILTER_SANITIZE_STRIPPED));
            $user  = $this->userModel->confirmAccount($code);
            if(empty($user)) {
                throw new Exception("Error. Activation code not valid or user not exists.");
            }
            $email = $user->email;
            $this->data['message'] = "Account [{$email}] activated successfully.";
            
        } catch (Exception $e) {
            $this->data['error'] =  $e->getMessage();
        }
        return $this->render("index/index");
    }
    
}
