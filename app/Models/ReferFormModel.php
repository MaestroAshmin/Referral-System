<?php

namespace App\Models;
use CodeIgniter\Model;

class ReferFormModel extends Model
{
    protected $table = 'referral_data';
    protected $primaryKey = 'ref_id';
    protected $allowedFields = ['name','email','phone','created_at','qr_path','referral_code','discount_code','referral_status','discount_status'];
}