<?php 
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EmailModel;
use App\Models\ReferFormModel;

class DashBoard extends BaseController{

     public function __construct(){
          helper(['url','form']);
     }
     public function index(){
          $session = session();
          // $referModel = new ReferFormModel();
          $db      = \Config\Database::connect();
          $builder = $db->table('referral_data');
          if($_SESSION['user_role'] == 1){
               $builder->select('referral_data.name, referral_data.email, referral_data.phone, referral_data.referral_code, referral_data.discount_code, referral_data.referral_status, referral_data.discount_status, referral_data.created_at');
               $builder->where('referred_by', $_SESSION['user_id'])->orderBy('referral_data.created_at','DESC');;
               $query = $builder->get();
               $results = $query->getResult();
               $data = [
                    'result' => $results,
               ];
               echo view('dashboard/dashboard.php', $data);
          }
          else{
               $builder->select('referral_data.name, referral_data.email, referral_data.phone, referral_data.referral_code, referral_data.discount_code, referral_data.referral_status, referral_data.discount_status, referral_data.created_at, user_login.name as referred_by');
               $builder->join('user_login', 'user_login.id = referral_data.referred_by')->orderBy('referral_data.created_at','DESC');
               $query = $builder->get();
               $results = $query->getResult();
               $data = [
                    'result' => $results,
               ];
               echo view('dashboard/dashboard.php', $data);

          }
     }
     public function use_referral_code(){
          echo view('dashboard/use-referral-code.php');
     }
     public function use_discount_code(){
          echo view('dashboard/use-discount-code.php');
     }
}