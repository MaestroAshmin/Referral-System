<?php 
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EmailModel;

class DashBoard extends BaseController{

    public function __construct(){
     helper(['url','form']);
   }
   public function index(){
       echo view('includes/header.php');
        echo view('pages/dashboard.php');
        echo view('includes/footer.php');
   }
}