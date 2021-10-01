<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model{
    protected $table = 'user_login';

    protected $allowedFields = [
        'name',
        'email',
        'phone_number',
        'password',
        'user_role',
        'verification_code',
        'is_activated',
        'created_at'
    ];
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
    protected function beforeInsert(array $data) {
        $data = $this->passwordHash($data);
        return $data;
    }
    protected function beforeUpdate(array $data){
        $data = $this->passwordHash($data);
        return $data;
    }
    protected function passwordHash(array $data) {
        if(isset($data['data']['password'])){
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}