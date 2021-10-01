<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EmailModel;

class User extends BaseController
{
   public function __construct(){
     helper(['url','form']);
   }
   public function index(){

   }
   public function login(){
        echo view('includes/header.php');
        echo view('pages/login.php');
        echo view('includes/footer.php');
   }
   public function auth()
    {
        $data = [];
        if($this->request->getMethod() == 'post'){
            $rules = [
                'email' => 'required|min_length[6]|max_length[50]|valid_email',
                'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
            ];
            $errors = [
                'password'  => [
                    'validateUser' => 'Email or Password does not match'
                ]
            ];
            if(!$this->validate($rules, $errors)){
                $data['validation'] = $this->validator;
            }
            else{
                $model = new UserModel();
                $user = $model->where('email',$this->request->getVar('email'))
                                ->first();
                $this->setUserSession($user);    
                return redirect()->to('dashboard');       
            }
        }
        echo view('includes/header.php');
        echo view('pages/login.php', $data);
        echo view('includes/footer.php');
    }
    public function register()
    {
        
        echo view('pages/register.php');
    }
    public function store(){
        $data = [];

        if ($this->request->getMethod() == 'post') {
            
            $validation =  \Config\Services::validation();
            $rules =  $validation->getRuleGroup('registration');
            if (!$this->validate($rules)) {

                return view('pages/register.php', [
                    "validation" => $this->validator,
                ]);
            } else {
                $model = new UserModel();
                $to = $this->request->getVar('email');
                $verificationText = md5((string)$to);
                $newData = [
                    'name' => $this->request->getVar('name'),
                    'phone_number' => $this->request->getVar('contact'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                    'verification_code' => $verificationText,
                    'user_role' => 1,
                ];
                $model->save($newData);
                
                $email = new EmailModel();
                $email->send_verification_email($to,$verificationText);
                $session = session();
                $session->setFlashdata('success', 'Successful Registration Please Check your email to activate your account');
                return redirect()->to('login');
            }
        }
    }
    private function setUserSession($user){
        $session = session();
        $ses_data = [
                    'user_id'       => $user['id'],
                    'user_name'     =>  $user['name'],
                    'user_email'    => $user['email'],
                    'user_role'    => $user['user_role'],
                    'isLoggedIn'     => TRUE
                ];
        $session->set($ses_data);
        return true;
    }
  
    public function verify_user(){
        $uri = current_url(true);
        $verification_code = $uri->getSegment(2);
        $model = new UserModel();
        $user = $model->where('verification_code',$verification_code)
                        ->first();
        if($user['is_activated'] == 1){
            return redirect()->to('dashboard');  
        }
        else{
            $update_data = [
                'is_activated' => 1,
            ];
            $update_activation_status = $model->update($user['id'],$update_data);
            if($update_activation_status){
                $data = [
                    'message' => 'Account has been verified successfully. Please login to Continue'
                ];
                $view = \Config\Services::renderer();
                echo view('includes/header.php');
                echo view('pages/verification.php', $data);
                echo view('includes/footer.php');
            }
            else{
                $data = [
                    'message' => 'Account Verification Failed'
                ];
                echo view('includes/header.php');
                echo view('pages/verification.php', $data);
                echo view('includes/footer.php');
            }
            
        }
        
    }
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
