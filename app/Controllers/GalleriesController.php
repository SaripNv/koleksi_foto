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
   // Menampilkan daftar galeri
public function index()
{
    // Ambil parameter filter & sort
    $sort           = $this->request->getGet('sort') ?? 'desc';
    $filterKategori = $this->request->getGet('filter_kategori');   // Filter kategori
    $filterTanggal  = $this->request->getGet('filter_tanggal');    // Filter tanggal
    $searchTerm     = $this->request->getGet('search');            // Filter pencarian nama foto

    // Pagination
    $page    = (int) ($this->request->getGet('page') ?? 1);
    $perPage = 5;
    $offset  = ($page - 1) * $perPage;

    // Bangun query dasar
    $galleryQuery = $this->galleryModel
        ->select('galleries.*, categories.nama_kategori')
        ->join('categories', 'categories.id = galleries.kategori_id', 'left')
        ->orderBy('galleries.tanggal_diambil', $sort);

    // Terapkan filter kategori jika ada
    if ($filterKategori) {
        $galleryQuery->where('galleries.kategori_id', $filterKategori);
    }

    // Terapkan filter tanggal jika ada
    if ($filterTanggal) {
        $galleryQuery->where('galleries.tanggal_diambil', $filterTanggal);
    }

    // Terapkan pencarian berdasarkan nama foto jika ada
    if ($searchTerm) {
        $galleryQuery->like('galleries.nama_foto', $searchTerm);
    }

    // Hitung total & ambil data
    $total = $galleryQuery->countAllResults(false);
    $galleries = $galleryQuery->findAll($perPage, $offset);

    // Kirim ke view
    return view('dashboard/galleries/index', [
        'galleries'       => $galleries,
        'categories'      => $this->categoryModel->findAll(), // untuk dropdown filter
        'sort'            => $sort,
        'filterKategori'  => $filterKategori,
        'filterTanggal'   => $filterTanggal,
        'searchTerm'      => $searchTerm, // Kirim nilai pencarian ke view
        'currentPage'     => $page,
        'totalPages'      => (int) ceil($total / $perPage),
        'perPage'         => $perPage,
        'total'           => $total,
    ]);
}
    
    

    // Form tambah foto
    public function create()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('dashboard/galleries/create', $data);
    }

     // Form edit foto
    public function edit($id)
    {
        $data['gallery'] = $this->galleryModel->find($id);
        if (!$data['gallery']) {
            return redirect()->to('/dashboard/galleries')->with('error', 'Foto tidak ditemukan');
        }

        $data['categories'] = $this->categoryModel->findAll();
        return view('dashboard/galleries/edit', $data);
    }
    
    
   public function store()
{
    $rules = [
        'nama_foto'       => 'required',
        'deskripsi'       => 'required',
        'tanggal_diambil' => 'required|valid_date[Y-m-d]',
        'kategori_id'     => 'required|integer',
        'foto'            => 'uploaded[foto.0]', // Minimal 1 file
        'foto.*'          => 'permit_empty|is_image[foto.*]|max_size[foto.*,2048]',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $kategori = $this->request->getPost('kategori_id');
    $category = $this->categoryModel->find($kategori);
    
    if (!$category) {
        return redirect()->back()->withInput()->with('error', 'Kategori tidak ditemukan');
    }

    $folder = 'uploads/galleries/' . url_title(strtolower($category['nama_kategori']), '_');
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $filePaths = [];
    $count = 0;

    // Ambil semua file dari input dengan index
    for ($i = 0; $i < 10; $i++) {
        $file = $this->request->getFile("foto.{$i}");
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $name = $file->getRandomName();
            $file->move($folder, $name);
            $filePaths[] = $folder . '/' . $name;
            $count++;
        }
    }

    if (empty($filePaths)) {
        return redirect()->back()->withInput()->with('error', 'Minimal unggah satu foto.');
    }

    // Simpan semua foto dalam satu entri
    $this->galleryModel->save([
        'nama_foto'       => $this->request->getPost('nama_foto'),
        'deskripsi'       => $this->request->getPost('deskripsi'),
        'tanggal_diambil' => $this->request->getPost('tanggal_diambil'),
        'kategori_id'     => $kategori,
        'foto'            => implode(',', $filePaths),
    ]);

    return redirect()->to('/dashboard/galleries')->with('success', "{$count} foto berhasil ditambahkan");
}

    // Update data foto dengan validasi

public function update($id)
{
    $gallery = $this->galleryModel->find($id);
    if (!$gallery) {
        return redirect()->to('/dashboard/galleries')->with('error', 'Foto tidak ditemukan');
    }

    $rules = [
        'nama_foto'       => 'required',
        'deskripsi'       => 'required',
        'tanggal_diambil' => 'required|valid_date[Y-m-d]',
        'kategori_id'     => 'required|integer',
        'foto.*'          => 'permit_empty|is_image[foto.*]|max_size[foto.*,2048]',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $kategori = $this->request->getPost('kategori_id');
    $category = $this->categoryModel->find($kategori);
    
    if (!$category) {
        return redirect()->back()->withInput()->with('error', 'Kategori tidak ditemukan');
    }

    $folderPath = 'uploads/galleries/' . url_title(strtolower($category['nama_kategori']), '_');
    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    $existingPhotos = explode(',', $gallery['foto']);
    $newPhotos = [];
    $deletedPhotos = $this->request->getPost('deleted_foto') ?? [];

    // Handle existing photos
    foreach ($existingPhotos as $index => $photoPath) {
        if (!in_array($photoPath, $deletedPhotos)) {
            $newPhotos[$index] = $photoPath;
        } else {
            // Delete the file from server
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }
    }

    // Handle new uploads
    for ($i = 0; $i < 10; $i++) {
        $file = $this->request->getFile("foto.{$i}");
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move($folderPath, $newName);
            $filePath = $folderPath . '/' . $newName;
            $newPhotos[$i] = $filePath;
        }
    }

    // Remove empty slots and reindex array
    $newPhotos = array_values(array_filter($newPhotos));

    if (empty($newPhotos)) {
        return redirect()->back()->withInput()->with('error', 'Setidaknya harus ada satu foto');
    }

    $this->galleryModel->update($id, [
        'nama_foto'       => $this->request->getPost('nama_foto'),
        'deskripsi'       => $this->request->getPost('deskripsi'),
        'tanggal_diambil' => $this->request->getPost('tanggal_diambil'),
        'kategori_id'     => $kategori,
        'foto'            => implode(',', $newPhotos),
    ]);

    return redirect()->to('/dashboard/galleries')->with('success', 'Foto berhasil diperbarui');
}


    // Hapus foto
   public function delete($id)
{
    $gallery = $this->galleryModel->find($id);
    if (!$gallery) {
        return redirect()->to('/dashboard/galleries')->with('error', 'Photo not found');
    }

    // Delete all associated photos
    $photos = explode(',', $gallery['foto']);
    foreach ($photos as $photo) {
        if (file_exists($photo)) {
            unlink($photo);
        }
    }

    // Delete from database
    $this->galleryModel->delete($id);

    return redirect()->to('/dashboard/galleries')->with('success', 'Photo deleted successfully');
}
}