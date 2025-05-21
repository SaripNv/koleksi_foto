<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'My Profile',
            'user' => $this->userModel->find(session('user_id'))
        ];

        return view('dashboard/profile/index', $data);
    }

    public function edit()
    {
        $data = [
            'title' => 'Edit Profile',
            'user' => $this->userModel->find(session('user_id')),
            'validation' => \Config\Services::validation()
        ];

        return view('dashboard/profile/edit', $data);
    }

    public function update()
    {
        $userId = session('user_id');
        $user = $this->userModel->find($userId);

        $rules = [
            'username' => "required|min_length[3]|max_length[100]|is_unique[user.username,id,$userId]",
            'email' => "required|valid_email|is_unique[user.email,id,$userId]"
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email')
        ];

        $this->userModel->update($userId, $data);
        
        // Update session data
        session()->set([
            'username' => $data['username'],
            'email' => $data['email']
        ]);

        return redirect()->to('dashboard/profile')->with('success', 'Profile updated successfully');
    }

    // Tambahkan method baru di ProfileController
public function uploadPhoto()
{
    $userId = session('user_id');
    $user = $this->userModel->find($userId);

    $validation = \Config\Services::validation();
    $validation->setRules([
        'profile_picture' => [
            'label' => 'Profile Picture',
            'rules' => 'uploaded[profile_picture]'
                . '|max_size[profile_picture,2048]'
                . '|mime_in[profile_picture,image/jpg,image/jpeg,image/png]'
                . '|ext_in[profile_picture,jpg,jpeg,png]'
                . '|is_image[profile_picture]'
        ]
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    $file = $this->request->getFile('profile_picture');
    
    // Pastikan folder upload ada
    $uploadPath = FCPATH . 'uploads/profile'; // Perubahan path
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }

    // Generate nama file unik
    $newName = $file->getRandomName();

    // Hapus foto lama jika bukan default
    if ($user['profile_picture'] != 'default.png') {
        @unlink($uploadPath . '/' . $user['profile_picture']);
    }

    // Pindahkan file ke folder upload
    if ($file->move($uploadPath, $newName)) {
        // Update database
        $this->userModel->update($userId, ['profile_picture' => $newName]);
        
        // Update session
        session()->set('profile_picture', $newName);
        
        return redirect()->to('dashboard/profile')->with('success', 'Profile picture updated successfully');
    }

    return redirect()->back()->with('error', 'Failed to upload image');
}

    public function changePassword()
    {
        $userId = session('user_id');
        $user = $this->userModel->find($userId);

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
            return redirect()->back()->with('error', 'Current password is incorrect');
        }

        $this->userModel->update($userId, [
            'password' => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT)
        ]);

        return redirect()->to('dashboard/profile')->with('success', 'Password changed successfully');
    }
}