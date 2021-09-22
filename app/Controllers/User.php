<?php

namespace App\Controllers;

use App\Models\UserModel;

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
        $session = session();
        $model = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $data = $model->where('email', $email)->first();
        
        if($data){
            $pass = $data['password'];
            $pass_hash = password_hash($password, PASSWORD_BCRYPT);
            $verify_pass = password_verify($password, $pass_hash);
            // echo $pass_hash;
            // echo '\n';
            // echo $password;
            // exit;
            if($verify_pass){
                $ses_data = [
                    'user_id'       => $data['id'],
                    'user_email'    => $data['email'],
                    'user_role'    => $data['user_role'],
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/refer-a-friend');
            }else{
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/login');
            }
        }else{
            $session->setFlashdata('msg', 'Email not Found');
            return redirect()->to('login');
        }
    }
   public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
