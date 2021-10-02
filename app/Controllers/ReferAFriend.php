<?php

namespace App\Controllers;
use App\Models\ReferFormModel;
use CodeIgniter\Controller;
use App\Libraries\Ciqrcode;
use App\Models\EmailModel;

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
            $qr_path = $this->qrcodeGenerator($referral_code);
            $emailModel = new EmailModel();
            $emailModel->send_qr_code($email, $qr_path);
            // $discount_code = $this->discountCouponGenerator();
            $data = [
                'name'  => $name,
                'email' => $email,
                'phone' => $phone,
                'referred_by'   =>  $referral_id,
                'referral_code' =>  $referral_code,
                // 'discount_code' =>  $discount_code
            ];
            $formModel->insert($data);
            // $data = [
            //     'referral_code' => $referral_code,
            //     'discount_code' =>  $discount_code
            // ];
            $session = session();
            $session->setFlashdata('message', 'Successfully Referred!');
            return redirect()->to('dashboard');
        }
    }
    public function referralCodeGenerator(){
        return strtoupper(random_string('alnum', 8));
    }
    public function discountCouponGenerator(){
        return strtoupper(random_string('alnum', 8));
    }
    public function qrcodeGenerator ($qrtext)
	{
        $save_name = $qrtext.'.png';
        $dir = 'referral-qr-codes/';
        $config['cacheable']    = true;
        $config['imagedir']     = $dir;
        $config['quality']      = true;
        $config['size']         = '1024';
        $config['black']        = [255, 255, 255];
        $config['white']        = [255, 255, 255];

        $qr = new Ciqrcode($config);

        $params['data']     = $qrtext;
        $params['level']    = 'L';
        $params['size']     = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $save_name;
        if($qr->generate($params)){
            return $params['savename'];
        }
        else{
            return false;
        }
        exit;
	}
}
