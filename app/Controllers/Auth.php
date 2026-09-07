<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected UserModel $users;

    public function __construct()
    {
        $this->users = new UserModel();
    }

    public function login()
    {
        if (session('logged_in')) {
            return redirect()->to('/');
        }

        return view('auth/login');
    }

    public function attempt()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->users->where('email', $this->request->getPost('email'))->first();

        if (! $user || ! password_verify($this->request->getPost('password'), $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        session()->regenerate();
        session()->set([
            'logged_in' => true,
            'id_user' => $user['id_user'],
            'nama_lengkap' => $user['nama_lengkap'],
            'role' => $user['role'],
            'nim' => $user['nim'],
        ]);

        return redirect()->to('/');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Berhasil logout.');
    }
}
