<?php

namespace App\Controllers;

use App\Models\GalleriesModel;
use App\Models\CategoriesModel;
use CodeIgniter\Controller;

class GalleriesController extends Controller
{
    protected $galleryModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->galleryModel = new GalleriesModel();
        $this->categoryModel = new CategoriesModel();
    }

    // Menampilkan daftar galeri
    public function index()
    {
        $sort = $this->request->getGet('sort') ?? 'desc'; // Default: Terbaru
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 5; // Batasi 5 data per halaman
        $offset = ($page - 1) * $perPage;
    
        $galleryQuery = $this->galleryModel
            ->select('galleries.*, categories.nama_kategori')
            ->join('categories', 'categories.id = galleries.kategori_id', 'left')
            ->orderBy('galleries.tanggal_diambil', $sort);
    
        $data['total'] = $galleryQuery->countAllResults(false);
        $data['galleries'] = $galleryQuery->findAll($perPage, $offset);
        $data['sort'] = $sort;
        $data['currentPage'] = $page;
        $data['totalPages'] = ceil($data['total'] / $perPage);
    
        return view('admin/galleries/index', $data);
    }
    
    
    

    // Form tambah foto
    public function create()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/galleries/create', $data);
    }

    // Menyimpan foto ke database dengan validasi
    public function store()
    {
        if (!$this->validate([
            'nama_foto' => 'required',
            'foto' => 'uploaded[foto]|is_image[foto]|max_size[foto,2048]', // Maks 2MB
            'deskripsi' => 'required',
            'tanggal_diambil' => 'required',
            'kategori_id' => 'required|integer'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid');
        }
    
        $file = $this->request->getFile('foto');
        $kategori = $this->request->getPost('kategori_id'); 
    
        // Pastikan kategori valid
        $category = $this->categoryModel->find($kategori);
        if (!$category) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan');
        }
    
        // Buat folder berdasarkan kategori
        $folderPath = 'uploads/galleries/' . strtolower(str_replace(' ', '_', $category['nama_kategori']));
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
    
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move($folderPath, $newName);
        } else {
            return redirect()->back()->with('error', 'Gagal mengupload gambar');
        }
    
        $this->galleryModel->save([
            'nama_foto'      => $this->request->getPost('nama_foto'),
            'foto'           => $folderPath . '/' . $newName,
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'tanggal_diambil'=> $this->request->getPost('tanggal_diambil'),
            'kategori_id'    => $kategori,
        ]);
    
        return redirect()->to('/admin/galleries')->with('success', 'Foto berhasil ditambahkan');
    }
    

    // Form edit foto
    public function edit($id)
    {
        $data['gallery'] = $this->galleryModel->find($id);
        if (!$data['gallery']) {
            return redirect()->to('/admin/galleries')->with('error', 'Foto tidak ditemukan');
        }

        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/galleries/edit', $data);
    }

    // Update data foto dengan validasi
 // Update data foto dengan validasi
public function update($id)
{
    if (!$this->request->is('post')) {
        return redirect()->to('admin/galleries')->with('error', 'Invalid request method');
    }
    

    $gallery = $this->galleryModel->find($id);
    if (!$gallery) {
        return redirect()->to('/admin/galleries')->with('error', 'Foto tidak ditemukan');
    }

    $kategori = $this->request->getPost('kategori_id');

    // Validasi kategori
    $category = $this->categoryModel->find($kategori);
    if (!$category) {
        return redirect()->back()->with('error', 'Kategori tidak ditemukan');
    }

    $folderPath = 'uploads/galleries/' . strtolower(str_replace(' ', '_', $category['nama_kategori']));
    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    $file = $this->request->getFile('foto');
    $fotoPath = $gallery['foto']; // Default tetap pakai foto lama

    if ($file && $file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        
        // Pindahkan file baru ke folder yang sesuai
        $file->move($folderPath, $newName);
        $fotoPath = $folderPath . '/' . $newName;

        // Hapus file lama jika ada
        if (!empty($gallery['foto']) && file_exists($gallery['foto'])) {
            unlink($gallery['foto']);
        }
    }

    $this->galleryModel->update($id, [
        'nama_foto'      => $this->request->getPost('nama_foto'),
        'foto'           => $fotoPath, // Gunakan path baru atau tetap yang lama
        'deskripsi'      => $this->request->getPost('deskripsi'),
        'tanggal_diambil'=> $this->request->getPost('tanggal_diambil'),
        'kategori_id'    => $kategori,
    ]);

    return redirect()->to('/admin/galleries')->with('success', 'Foto berhasil diperbarui');
}

    


    // Hapus foto
    public function delete($id)
    {
        $gallery = $this->galleryModel->find($id);
        if (!$gallery) {
            return redirect()->to('/admin/galleries')->with('error', 'Foto tidak ditemukan');
        }

        if (file_exists($gallery['foto'])) {
            unlink($gallery['foto']);
        }

        $this->galleryModel->delete($id);
        return redirect()->to('/admin/galleries')->with('success', 'Foto berhasil dihapus');
    }

    // Filter berdasarkan kategori
    public function filterByCategory($kategori_id)
    {
        $data['galleries'] = $this->galleryModel->where('kategori_id', $kategori_id)->findAll();
        return view('admin/galleries/index', $data);
    }

    // Filter berdasarkan tanggal
    public function filterByDate($tanggal)
    {
        $data['galleries'] = $this->galleryModel->where('tanggal_diambil', $tanggal)->findAll();
        return view('admin/galleries/index', $data);
    }
}