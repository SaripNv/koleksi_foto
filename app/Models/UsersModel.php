<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['username', 'password', 'role', 'created_at', 'updated_at'];

    // Ambil user berdasarkan username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}