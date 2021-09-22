<?php

namespace App\Controllers;
use App\Models\ReferFormModel;
use CodeIgniter\Controller;

class ReferAFriend extends BaseController
{
    public function __construct(){
        helper(['url','form']);
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
           echo 'correct';
       }
    }
}
