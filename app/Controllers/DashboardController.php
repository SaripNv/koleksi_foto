<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\GalleriesModel;
use App\Models\CategoriesModel;
use App\Models\UserModel;

class DashboardController extends Controller
{
    protected $galleryModel;
    protected $categoryModel;
    protected $userModel;

    public function __construct()
    {
        $this->galleryModel = new GalleriesModel();
        $this->categoryModel = new CategoriesModel();
        $this->userModel = new UserModel();
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