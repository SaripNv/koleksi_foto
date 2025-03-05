<?php

namespace App\Controllers;

use App\Models\CategoriesModel;
use CodeIgniter\Controller;

class CategoriesController extends Controller
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoriesModel();
    }

    // Menampilkan daftar kategori
    public function index()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/categories/index', $data);
    }

    public function create()
{
    return view('admin/categories/create');
}

    // Menyimpan kategori baru dengan validasi
    public function store()
    {
        if (!$this->validate(['nama_kategori' => 'required'])) {
            return redirect()->back()->with('error', 'Nama kategori harus diisi');
        }

        $this->categoryModel->save([
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ]);

        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil ditambahkan');
    }

    // Form edit kategori
    public function edit($id)
    {
        $data['category'] = $this->categoryModel->find($id);
        if (!$data['category']) {
            return redirect()->to('/admin/categories')->with('error', 'Kategori tidak ditemukan');
        }
        return view('admin/categories/edit', $data);
    }

    // Update kategori dengan validasi
    public function update($id)
    {
        if (!$this->validate(['nama_kategori' => 'required'])) {
            return redirect()->back()->with('error', 'Nama kategori harus diisi');
        }

        $this->categoryModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ]);

        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil diperbarui');
    }

    // Hapus kategori
    public function delete($id)
    {
        if (!$this->categoryModel->find($id)) {
            return redirect()->to('/admin/categories')->with('error', 'Kategori tidak ditemukan');
        }

        $this->categoryModel->delete($id);
        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil dihapus');
    }
}