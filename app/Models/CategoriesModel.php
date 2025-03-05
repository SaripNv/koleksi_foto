<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriesModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_kategori'];

    // Ambil semua kategori
    public function getAllCategories()
    {
        return $this->findAll();
    }
}