<?php

namespace App\Models;
use CodeIgniter\Model;

class ReferFormModel extends Model
{
    protected $table = 'referral_data';
    protected $primaryKey = 'ref_id';
    protected $allowedFields = ['name','email','phone','reffered_by','created_at'];
}