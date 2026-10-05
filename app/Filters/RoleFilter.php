<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Belum login
        if (! session('logged_in')) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }

        $role = session('role');

        // Role yang diizinkan dari route
        $allowedRoles = $arguments ?? [];

        // Jika role user tidak termasuk role yang diizinkan
        if (
            empty($allowedRoles) ||
            ! in_array($role, $allowedRoles, true)
        ) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Anda tidak memiliki akses ke halaman tersebut.'
                );
        }
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ): void {
    }
}