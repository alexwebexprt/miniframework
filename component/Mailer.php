<?php
namespace component;
use Exception;

class Mailer implements Component {    
    public $config = null;
    public function __construct($config) {
        $this->config  = $config;
    }
    public static function init($config) {
        $mailer  =  new self($config);
        return $mailer;
    }
    public function afterInit($config) {}
    
    public function send($to,$subject,$message) {
        $from   =   $this->config['from'];
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        // Create email headers
        $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();

        if(@mail($to, $subject, $message, $headers)){
            return true;
        } else {
            throw new Exception('Unable to send email. Please try again.');
        }
    }
}