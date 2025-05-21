<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UsersController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'users' => $this->userModel->findAll()
        ];
        return view('dashboard/users/index', $data);
    }

    public function create()
    {
        return view('dashboard/users/create');
    }

    public function store()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[user.username]',
            'email' => 'required|valid_email|is_unique[user.email]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[admin,user]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'profile_picture' => 'default.png',
            'status_aktif' => 1
        ];

        $this->userModel->insert($data);
        return redirect()->to(route_to('users.index'))->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            'user' => $this->userModel->find($id)
        ];
        return view('dashboard/users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        $usernameRule = $user->username == $this->request->getPost('username') ? 'permit_empty' : 'is_unique[user.username]';
        $emailRule = $user->email == $this->request->getPost('email') ? 'permit_empty' : 'is_unique[user.email]';

        $rules = [
            'username' => "required|min_length[3]|max_length[50]|{$usernameRule}",
            'email' => "required|valid_email|{$emailRule}",
            'role' => 'required|in_list[admin,user]',
            'status_aktif' => 'required|in_list[0,1]'
        ];

        $passwordRule = $this->request->getPost('password') ? 'min_length[6]' : 'permit_empty';
        $rules['password'] = $passwordRule;

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'status_aktif' => $this->request->getPost('status_aktif')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        return redirect()->to(route_to('users.index'))->with('success', 'User berhasil diupdate');
    }

    public function toggleStatus($id)
    {
        $user = $this->userModel->find($id);
        $status = $user['status_aktif'] ? 0 : 1;
        $this->userModel->update($id, ['status_aktif' => $status]);
        return redirect()->to(route_to('users.index'))->with('success', 'Status user berhasil diubah');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to(route_to('users.index'))->with('success', 'User berhasil dihapus');
    }
}