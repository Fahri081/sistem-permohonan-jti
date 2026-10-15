<?php

namespace App\Controllers;

use App\Models\BuktiFisikPermohonanModel;
use App\Models\BuktiPengambilanPermohonanModel;
use App\Models\PermohonanModel;
use CodeIgniter\Controller;

/**
 * Serves evidence images from writable/uploads after authorization checks.
 * Do not expose these file paths directly under public/.
 */
class PrivateEvidence extends Controller
{
    public function mahasiswaBuktiFisik(int $idPermohonan, string $filename)
    {
        $permohonan = $this->findStudentPermohonan($idPermohonan);

        if (! $permohonan) {
            return $this->notFound();
        }

        return $this->serveEvidence(
            $idPermohonan,
            $filename,
            'bukti_fisik',
            $permohonan
        );
    }

    public function mahasiswaBuktiPengambilan(int $idPermohonan, string $filename)
    {
        $permohonan = $this->findStudentPermohonan($idPermohonan);

        if (! $permohonan) {
            return $this->notFound();
        }

        return $this->serveEvidence(
            $idPermohonan,
            $filename,
            'bukti_pengambilan',
            $permohonan
        );
    }

    public function adminBuktiFisik(int $idPermohonan, string $filename)
    {
        $permohonan = $this->findAdminPermohonan($idPermohonan);

        if (! $permohonan) {
            return $this->notFound();
        }

        return $this->serveEvidence(
            $idPermohonan,
            $filename,
            'bukti_fisik',
            $permohonan
        );
    }

    public function adminBuktiPengambilan(int $idPermohonan, string $filename)
    {
        $permohonan = $this->findAdminPermohonan($idPermohonan);

        if (! $permohonan) {
            return $this->notFound();
        }

        return $this->serveEvidence(
            $idPermohonan,
            $filename,
            'bukti_pengambilan',
            $permohonan
        );
    }

    private function findStudentPermohonan(int $idPermohonan): ?array
    {
        $userId = (int) (session('id_user') ?? 0);

        if (! session('logged_in') || $userId <= 0 || session('role') !== 'mahasiswa') {
            return null;
        }

        return (new PermohonanModel())
            ->where('id_permohonan', $idPermohonan)
            ->where('id_user', $userId)
            ->first();
    }

    private function findAdminPermohonan(int $idPermohonan): ?array
    {
        if (
            ! session('logged_in')
            || ! in_array((string) session('role'), ['admin', 'super_admin'], true)
        ) {
            return null;
        }

        return (new PermohonanModel())->find($idPermohonan);
    }

    private function serveEvidence(
        int $idPermohonan,
        string $filename,
        string $type,
        array $permohonan
    ) {
        // Generated evidence filenames use only ASCII letters, digits, underscore, dash, and a safe image extension.
        if (
            $filename === ''
            || $filename !== basename($filename)
            || ! preg_match('/\A[A-Za-z0-9_-]+\.(?:png|jpe?g|webp)\z/i', $filename)
        ) {
            return $this->notFound();
        }

        if ($type === 'bukti_fisik') {
            $linked = (new BuktiFisikPermohonanModel())
                ->where('id_permohonan', $idPermohonan)
                ->where('nama_file', $filename)
                ->first() !== null;

            // Compatibility for older records stored in permohonan.bukti_fisik.
            if (! $linked) {
                $linked = (string) ($permohonan['bukti_fisik'] ?? '') === $filename;
            }
        } elseif ($type === 'bukti_pengambilan') {
            $linked = (new BuktiPengambilanPermohonanModel())
                ->where('id_permohonan', $idPermohonan)
                ->where('nama_file', $filename)
                ->first() !== null;
        } else {
            return $this->notFound();
        }

        if (! $linked) {
            return $this->notFound();
        }

        $path = WRITEPATH
            . 'uploads'
            . DIRECTORY_SEPARATOR
            . $type
            . DIRECTORY_SEPARATOR
            . $filename;

        if (! is_file($path) || ! is_readable($path)) {
            return $this->notFound();
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($path);

        if (! in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return $this->notFound();
        }

        $contents = file_get_contents($path);

        if ($contents === false) {
            return $this->notFound();
        }

        return $this->response
            ->setStatusCode(200)
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Length', (string) filesize($path))
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'private, no-store, max-age=0')
            ->setHeader('Pragma', 'no-cache')
            ->setHeader('X-Content-Type-Options', 'nosniff')
            ->setBody($contents);
    }

    private function notFound()
    {
        return $this->response
            ->setStatusCode(404)
            ->setHeader('Cache-Control', 'private, no-store, max-age=0')
            ->setHeader('X-Content-Type-Options', 'nosniff')
            ->setBody('Bukti tidak ditemukan.');
    }
}
