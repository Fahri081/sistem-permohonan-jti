<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        if (session('logged_in')) {
            return session('role') === 'admin'
                ? redirect()->to('/admin')
                : redirect()->to('/mahasiswa');
        }

        return redirect()->to('/login');
    }
}
