<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'username', 'email', 'password', 'about', 'status', 'last_logged_in'];
    protected $useTimestamps = true;

    protected $validationRules    = [
        'name' => 'required|max_length[100]',
        'username' => 'required|max_length[50]',
        'email' => 'required|valid_email|max_length[50]',
        'password' => 'required|max_length[50]',
    ];
    
}
