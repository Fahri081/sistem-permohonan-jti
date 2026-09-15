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

    /**
     * =========================
     * HALAMAN LOGIN
     * =========================
     */
    public function login()
    {
        if (session('logged_in')) {
            if (session('role') === 'admin') {
                return redirect()->to('/admin');
            }

            return redirect()->to('/mahasiswa');
        }

        return view('auth/login');
    }

    /**
     * =========================
     * PROSES LOGIN
     * =========================
     */
    public function attempt()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email = trim(
            (string) $this->request->getPost('email')
        );

        $password = (string) $this->request->getPost('password');

        $user = $this->users
            ->where('email', $email)
            ->first();

        if (
            ! $user ||
            ! password_verify(
                $password,
                $user['password']
            )
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Email atau password salah.'
                );
        }

        // Regenerate session untuk keamanan
        session()->regenerate();

        session()->set([
            'logged_in'    => true,
            'id_user'      => $user['id_user'],
            'nama_lengkap' => $user['nama_lengkap'],
            'role'         => $user['role'],
            'nim'          => $user['nim'],
        ]);

        /*
         * Redirect berdasarkan role
         */
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin');
        }

        return redirect()->to('/mahasiswa');
    }

    /**
     * =========================
     * LOGOUT
     * =========================
     */
    public function logout()
    {
        session()->destroy();

        return redirect()
            ->to('/login')
            ->with(
                'success',
                'Berhasil logout.'
            );
    }
}