<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleriesModel extends Model
{
    protected $table = 'galleries';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_foto', 'foto', 'deskripsi', 'tanggal_diambil', 'kategori_id'];

 protected $useTimestamps = true;
}