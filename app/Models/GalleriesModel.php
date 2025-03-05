<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleriesModel extends Model
{
    protected $table = 'galleries';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_foto', 'foto', 'deskripsi', 'tanggal_diambil', 'kategori_id'];

    public function getAllGalleries()
{
    return $this->select('galleries.*, categories.nama_kategori')
                ->join('categories', 'categories.id = galleries.kategori_id', 'left')
                ->orderBy('tanggal_diambil', 'DESC')
                ->findAll();
}

    public function getByCategory($kategori_id)
    {
        return $this->where('kategori_id', $kategori_id)->findAll();
    }

    public function getByDate($tanggal)
    {
        return $this->where('tanggal_diambil', $tanggal)->findAll();
    }
}