<?php

namespace App\Controllers;
use App\Models\ReferFormModel;
use App\Models\UserModel;
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
            'phone' => 'required|numeric|max_length[15]'
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
            if($this->isAlreadyReferred($name,$email, $phone)){
                $session = session();
                $session->setFlashdata('failure', 'This user has already been referred previously');
                return redirect()->to('dashboard');
            }
            else{
                $referral_code = $this->referralCodeGenerator();
                $qr_path = $this->qrcodeGenerator($referral_code);
                $emailModel = new EmailModel();
                $emailModel->send_qr_code($email, $qr_path);
                $data = [
                    'name'  => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'referred_by'   =>  $referral_id,
                    'referral_code' =>  $referral_code,
                ];
                $formModel->insert($data);
                $session = session();
                $session->setFlashdata('message', 'Successfully Referred!');
                return redirect()->to('dashboard');
            }
            
        }
    }
    public function sendReferralLink(){
       $input = $this->validate([
            'name'  => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'phone' => 'required|numeric|max_length[15]'
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
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $phone = $this->request->getPost('phone');
            
            $referral_code = $this->referralCodeGenerator();
            $qr_path = $this->qrcodeGenerator($referral_code);
            $emailModel = new EmailModel();
            $emailModel->send_referral_link($email, $referral_code);
            $data = [
                'name'  => $name,
                'email' => $email,
                'phone' => $phone,
                'referral_code' =>  $referral_code,
                'qr_path'   =>  $qr_path,
            ];
            $formModel->insert($data);
            $session = session();
            $session->setFlashdata('message', 'Successfully sent Referral Link!');
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
    public function use_referral_code(){
        if($this->request->getMethod() == 'post'){
            $rules = [
                'referralCode' => 'required',
            ];
           
            if(!$this->validate($rules)){
                $session = session();
                $session->setFlashData('refer-error','Please enter Referral Code!');
            }
            else{
                $referral_code = $this->request->getVar('referralCode');
                $referModel = new ReferFormModel();
                $refer = $referModel->where('referral_code', $referral_code)
                                ->first();
                if(isset($refer)){
                    if($refer['referral_status']== 1){
                    $session = session();
                    $session->setFlashData('refer-error','This referral code has already been used');
                    }
                    else{
                        
                        $discount_code = $this->discountCouponGenerator();
                        $userModel = new UserModel();
                        $user = $userModel->where('id',$refer['referred_by'])->first();
                        $email = new EmailModel();
                        $email->send_referrer($user['email'],$discount_code);
                        $data = [
                            'referral_status'   =>  1,
                            'discount_code' => $discount_code
                        ];
                        $referModel->update($refer['ref_id'],$data);
                        $session = session();
                        $session->setFlashData('refer-success','Referral Code has been used successfully');
                    }
                }
                else{
                    $session = session();
                    $session->setFlashData('refer-error','Referral Code Wrong or not in database');
                }
                

            }
            return redirect()->to('use-referral-code');

        }
    }
    public function use_discount_code(){
        if($this->request->getMethod() == 'post'){
            $rules = [
                'discountCode' => 'required',
            ];
           
            if(!$this->validate($rules)){
                $session = session();
                $session->setFlashData('refer-error','Please enter Discount Code!');
            }
            else{
                $discount_code = $this->request->getVar('discountCode');
                $referModel = new ReferFormModel();
                $discount= $referModel->where('discount_code', $discount_code)
                                ->first();
                if(isset($discount)){
                    if($discount['discount_status']== 1){
                    $session = session();
                    $session->setFlashData('refer-error','This discount code has already been used');
                    }
                    else{
                        $data = [
                            'discount_status'   =>  1,
                        ];
                        $referModel->update($discount['ref_id'],$data);
                        $session = session();
                        $session->setFlashData('refer-success','Discount Code has been used successfully');
                    }
                }
                else{
                    $session = session();
                    $session->setFlashData('refer-error','Discount Code Wrong or not in database');
                }
                
                // print_r($refer['referral_status']);exit;
            }
            return redirect()->to('use-discount-code');

        }
    }
    public function isAlreadyReferred($name, $email, $phone){
        $db      = \Config\Database::connect();
        $builder = $db->table('referral_data');
        $builder->select('*');
        $where_array = "(name='$name' AND email='$email') OR (name='$name' AND email='$phone')";
        $builder->where($where_array);
        $query = $builder->get();
        $results = $query->getResult();
        if(!empty($results)){
            return true;
        }
        else{
            return false;
        }
    }
    public function referral_link(){
        $uri = new \CodeIgniter\HTTP\URI();
        $uri = current_url(true);
        $referral_code = $uri->getSegment(2);
        $db      = \Config\Database::connect();
        $builder = $db->table('referral_data');
        $builder->select('qr_path')->where('referral_code',$referral_code);
        $query = $builder->get();
        $results = $query->getResult();
        $image = $referral_code.'.png';
        if(!empty($results)){
            $data = [
                'image' => $image,
            ];
            echo view('includes/header.php');
            echo view('pages/referral-code-qr.php', $data);
            echo view('includes/footer.php');
        }
        else{
            return false;
        }
        
    }
}
