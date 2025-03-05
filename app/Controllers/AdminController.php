<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\GalleriesModel;
use App\Models\CategoriesModel;

class AdminController extends Controller
{
    protected $galleryModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->galleryModel = new GalleriesModel();
        $this->categoryModel = new CategoriesModel();
    }

    // Dashboard Admin
    public function index()
    {
        $data = [
            'total_galleries' => $this->galleryModel->countAll(),
            'total_categories' => $this->categoryModel->countAll(),
            'recent_galleries' => $this->galleryModel->orderBy('tanggal_diambil', 'DESC')->limit(5)->find(),
        ];
        return view('layouts/base', $data);
    }

}