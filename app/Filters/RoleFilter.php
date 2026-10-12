<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (! $session->get('logged_in')) {
            return redirect()
                ->to('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = (int) ($session->get('id_user') ?? 0);

        if ($userId <= 0) {
            $session->destroy();

            return redirect()
                ->to('/login')
                ->with('error', 'Sesi login tidak valid. Silakan login kembali.');
        }

        // Jangan hanya memercayai role/status yang tersimpan di session.
        $user = (new UserModel())->find($userId);

        if (! $user || (int) ($user['id_status_akun'] ?? 0) !== 1) {
            $session->destroy();

            return redirect()
                ->to('/login')
                ->with('error', 'Akun tidak aktif atau sesi sudah berakhir. Silakan login kembali.');
        }

        $sessionRole = (string) ($session->get('role') ?? '');
        $databaseRole = (string) ($user['role'] ?? '');

        // Paksa login ulang apabila administrator mengubah role akun.
        if ($sessionRole === '' || $sessionRole !== $databaseRole) {
            $session->destroy();

            return redirect()
                ->to('/login')
                ->with('error', 'Hak akses akun berubah. Silakan login kembali.');
        }

        $allowedRoles = is_array($arguments) ? $arguments : [];

        if (empty($allowedRoles) || ! in_array($databaseRole, $allowedRoles, true)) {
            return redirect()
                ->to('/login')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return null;
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ): void {
    }
}
