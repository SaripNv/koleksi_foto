<?php

namespace App\Controllers;

use App\Models\GalleriesModel;
use App\Models\CategoriesModel;
use CodeIgniter\Controller;

class HomeController extends Controller
{
    protected $galleryModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->galleryModel = new GalleriesModel();
        $this->categoryModel = new CategoriesModel();
    }

    public function index()
{
    $today     = date('Y-m-d');
    $threeDaysAgo = date('Y-m-d', strtotime('-3 days'));

    // Ambil kategori
    $categoriesModel = new \App\Models\CategoriesModel();
    $categories = $categoriesModel->findAll();

    // Ambil parameter filter
    $sort = $this->request->getGet('sort') ?? 'all';
    $page = $this->request->getGet('page') ?? 1;
    $perPage = 9;

    // Query dasar
    $galleryQuery = $this->galleryModel
        ->select('galleries.*, categories.nama_kategori')
        ->join('categories', 'categories.id = galleries.kategori_id', 'left')
        ->orderBy('galleries.tanggal_diambil', 'DESC');

    // Filter berdasarkan News / Old
    if ($sort === 'new') {
        $galleryQuery->where('galleries.tanggal_diambil >=', $threeDaysAgo);
    } elseif ($sort === 'old') {
        $galleryQuery->where('galleries.tanggal_diambil <', $threeDaysAgo);
    }

    // Pagination
    $totalGalleries = $galleryQuery->countAllResults(false);
    $galleries = $galleryQuery->paginate($perPage, 'default', $page);
    $totalPages = ceil($totalGalleries / $perPage);

    return view('home/index', [
        'galleries' => $galleries,
        'categories' => $categories,
        'currentPage' => $page,
        'totalPages' => $totalPages,
        'sort' => $sort,
    ]);
}

}