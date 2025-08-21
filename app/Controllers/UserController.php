<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;
use CodeIgniter\Exceptions\PageNotFoundException;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = model(UserModel::class);
    }

    public function index()
    {
        $data = [
            'users' => $this->userModel->findAll(),
            'title' => 'User Management'
        ];

        return view('user/user_management', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create User',
            'mode' => 'create'
        ];

        return view('user/user_management', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'email' => 'required|valid_email|is_unique[users.email]',
            'username' => 'required|alpha_numeric|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[8]',
            'active' => 'permit_empty|in_list[0,1]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password_hash' => Password::hash($this->request->getPost('password')),
            'active' => $this->request->getPost('active', FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
        ];

        if (!$this->userModel->insert($data)) {
            return redirect()->back()->withInput()->with('error', 'Failed to create user.');
        }

        return redirect()->to('/user')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound();
        }

        $data = [
            'user' => $user,
            'title' => 'Edit User',
            'mode' => 'edit'
        ];

        return view('user/user_management', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound();
        }

        $validation = \Config\Services::validation();

        $validation->setRules([
            'email' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
            'username' => 'required|alpha_numeric|min_length[3]|is_unique[users.username,id,' . $id . ']',
            'password' => 'permit_empty|min_length[8]',
            'active' => 'permit_empty|in_list[0,1]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'active' => $this->request->getPost('active', FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password_hash'] = Password::hash($password);
        }

        if (!$this->userModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', 'Failed to update user.');
        }

        return redirect()->to('/user')->with('success', 'User updated successfully.');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound();
        }

        if (!$this->userModel->delete($id)) {
            return redirect()->back()->with('error', 'Failed to delete user.');
        }

        return redirect()->to('/user')->with('success', 'User deleted successfully.');
    }
}