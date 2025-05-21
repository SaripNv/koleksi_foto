<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    protected $userModel;
    protected $validation;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    // Tampilan Login
    public function login()
    {
        if ($this->session->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Login',
            'config' => config('Auth')
        ];

        return view('auth/login', $data);
    }

   // Proses Login
public function loginProcess()
{
    $rules = [
        'email' => 'required|valid_email',
        'password' => 'required|min_length[6]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    $user = $this->userModel->where('email', $email)->first();

    if (!$user || !password_verify($password, $user['password'])) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Email atau password salah');
    }

    // Update last login
    $this->userModel->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

    // Set session data
    $sessionData = [
        'user_id' => $user['id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'role' => $user['role'],
        'profile_picture' => $user['profile_picture'],
        'logged_in' => true
    ];

    $this->session->set($sessionData);

    // Redirect berdasarkan role
    if ($user['role'] === 'admin') {
        return redirect()->to('/dashboard');
    }
    return redirect()->to('/');
}

    // Tampilan Register (Opsional)
    public function register()
    {
        if ($this->session->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Register'
        ];

        return view('auth/register', $data);
    }

    // Proses Register (Opsional)
    public function registerProcess()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[user.username]',
            'email' => 'required|valid_email|is_unique[user.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'user', // Default role
            'profile_picture' => 'default.png'
        ];

        $this->userModel->save($data);

        return redirect()->to('/login')
            ->with('success', 'Registrasi berhasil! Silakan login');
    }

    // Logout
    public function logout()
    {
        // Hapus semua data session
        $this->session->destroy();

        // Redirect ke halaman login
        return redirect()->to('/login')
            ->with('success', 'Anda telah logout');
    }

    // Helper Method: Cek apakah email sudah terdaftar (untuk AJAX)
    public function checkEmail()
    {
        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->first();

        return $this->response->setJSON([
            'exists' => $user ? true : false
        ]);
    }
}