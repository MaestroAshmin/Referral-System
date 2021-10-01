<?php

namespace App\Models;
use CodeIgniter\Model;
class EmailModel extends Model {
 
 public function __construct()
    {
        parent::__construct();
        
    }
 
 function send_verification_email($to, $verificationText){

    $email = \Config\Services::email();
   //  print_r($email);exit;
    $email->setNewLine("\r\n");
    $email->setFrom('ashmin@qubylive.com', "Account Activation");
    $email->setTo($to);
    $email->setSubject("Email Verification");
    $email->setMessage("Dear User,\nPlease click on below URL or paste into your browser to verify your Email Address\n\n http://localhost:8080/verify/".$verificationText."\n"."\n\nThanks\nAdmin Team");
    if($email->send()){
       return true;
    }
    else{
       $data = $email->printDebugger(['headers']);
       print_r($data);exit;
    }
 }
}
?>