<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model{
    protected $table = 'user_login';

    protected $allowedFields = [
        'name',
        'email',
        'password',
        'user_role',
        'created_at'
    ];
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
}