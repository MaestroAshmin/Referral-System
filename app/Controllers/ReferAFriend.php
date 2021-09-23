<?php

namespace App\Controllers;
use App\Models\ReferFormModel;
use CodeIgniter\Controller;

class ReferAFriend extends BaseController
{
    public function __construct(){
        helper(['url','form','text']);
        $view = \Config\Services::renderer();
    }
    public function index()
    {   
        $session = session();
        echo view('includes/header.php');
        echo view('pages/refer-a-friend.php');
        echo view('includes/footer.php');
    }
    public function referSubmit(){
       $input = $this->validate([
            'name'  => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'phone' => 'required|numeric|max_length[10]'
       ]);
       $formModel = new ReferFormModel();
       if(!$input){
            echo view('includes/header.php');
            echo view('pages/refer-a-friend.php',[
                'validation'    =>  $this->validator
            ]);
            echo view('includes/footer.php');
       }
       else{
            $referral_id = $this->request->getPost('referrerId');
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $phone = $this->request->getPost('phone');
            $referral_code = $this->referralCodeGenerator();
            $discount_code = $this->discountCouponGenerator();
            $data = [
                'name'  => $referral_id,
                'email' => $email,
                'phone' => $phone,
                'referred_by'   =>  $referral_id,
                'referral_code' =>  $referral_code,
                'discount_code' =>  $discount_code
            ];
            $formModel->insert($data);
            $data = [
                'referral_code' => $referral_code,
                'discount_code' =>  $discount_code
            ];
            echo view('pages/refer-successful.php', $data);
        }
    }
    public function referralCodeGenerator(){
        return strtoupper(random_string('alnum', 8));
    }
    public function discountCouponGenerator(){
        return strtoupper(random_string('alnum', 8));
    }
}
