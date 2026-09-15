<?php

namespace App\Controllers;

use App\Libraries\NotificationService;
use App\Models\BuktiFisikPermohonanModel;
use App\Models\PermohonanModel;
use App\Models\TujuanModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Mahasiswa extends Controller
{
    /**
     * =====================================================
     * HELPER USER
     * =====================================================
     */
    private function getUserId(): ?int
    {
        $idUser = session('id_user');

        if ($idUser === null || $idUser === '') {
            return null;
        }

        return (int) $idUser;
    }


    /**
     * =====================================================
     * DATA NOTIFIKASI
     * =====================================================
     */
    private function notificationData(int $userId): array
    {
        $notification = new NotificationService();

        return [
            'notifications' => $notification->getForUser($userId, 5),
            'unreadCount' => $notification->unreadCount($userId),
        ];
    }


    /**
     * =====================================================
     * DASHBOARD MAHASISWA
     * =====================================================
     */
    public function index()
    {
        $userId = $this->getUserId();

        if (! $userId) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }

        $permohonanModel = new PermohonanModel();

        $data['permohonan'] = $permohonanModel
            ->select(
                'permohonan.*,
                 tujuan.nama_tujuan,
                 status.nama_status'
            )
            ->join(
                'tujuan',
                'tujuan.id_tujuan = permohonan.id_tujuan'
            )
            ->join(
                'status',
                'status.id_status = permohonan.id_status'
            )
            ->where(
                'permohonan.id_user',
                $userId
            )
            ->orderBy(
                'permohonan.id_permohonan',
                'DESC'
            )
            ->findAll();

        $data['total'] = count(
            $data['permohonan']
        );

        $data['totalDiproses'] =
            (new PermohonanModel())
                ->where(
                    'id_user',
                    $userId
                )
                ->where(
                    'id_status',
                    2
                )
                ->countAllResults();

        $data['totalSiapDiambil'] =
            (new PermohonanModel())
                ->where(
                    'id_user',
                    $userId
                )
                ->whereIn(
                    'id_status',
                    [4, 5]
                )
                ->countAllResults();

        $data = array_merge(
            $data,
            $this->notificationData($userId)
        );

        return view(
            'mahasiswa/dashboard',
            $data
        );
    }


    /**
     * =====================================================
     * DAFTAR PERMOHONAN SAYA
     * =====================================================
     */
    public function permohonan()
    {
        $userId = $this->getUserId();

        if (! $userId) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }

        $permohonanModel = new PermohonanModel();

        $data['permohonan'] = $permohonanModel
            ->select(
                'permohonan.*,
                 tujuan.nama_tujuan,
                 status.nama_status'
            )
            ->join(
                'tujuan',
                'tujuan.id_tujuan = permohonan.id_tujuan'
            )
            ->join(
                'status',
                'status.id_status = permohonan.id_status'
            )
            ->where(
                'permohonan.id_user',
                $userId
            )
            ->orderBy(
                'permohonan.id_permohonan',
                'DESC'
            )
            ->findAll();

        $data = array_merge(
            $data,
            $this->notificationData($userId)
        );

        return view(
            'mahasiswa/permohonan',
            $data
        );
    }


    /**
     * =====================================================
     * FORM AJUKAN PERMOHONAN
     * =====================================================
     */
public function create()
{
    $userId = $this->getUserId();

    if (! $userId) {
        return redirect()
            ->to('/login')
            ->with('error', 'Silakan login terlebih dahulu.');
    }

    $tujuanRows = (new TujuanModel())
        ->orderBy('nama_tujuan', 'ASC')
        ->findAll();

    // Hilangkan tujuan yang memiliki nama sama
    // tanpa mengubah data tujuan di database.
    $data['tujuan'] = [];
    $seenTujuan = [];

    foreach ($tujuanRows as $row) {
        $namaTujuan = trim((string) ($row['nama_tujuan'] ?? ''));

        $keyTujuan = function_exists('mb_strtolower')
            ? mb_strtolower($namaTujuan, 'UTF-8')
            : strtolower($namaTujuan);

        if ($namaTujuan === '' || isset($seenTujuan[$keyTujuan])) {
            continue;
        }

        $seenTujuan[$keyTujuan] = true;
        $data['tujuan'][] = $row;
    }

    // Ambil data notifikasi agar icon/badge
    // notifikasi tetap muncul di halaman Ajukan Permohonan.
    $data = array_merge(
        $data,
        $this->notificationData($userId)
    );

    return view('mahasiswa/create', $data);
}


    /**
     * =====================================================
     * SIMPAN PERMOHONAN BARU
     * =====================================================
     *
     * Alur baru:
     * - Mahasiswa mengisi tujuan
     * - Mahasiswa mengisi keperluan
     * - Mahasiswa dapat mengisi deskripsi
     * - Mahasiswa upload foto bukti pengumpulan
     *   berkas fisik
     *
     * Tidak ada lagi upload dokumen digital.
     */
    public function store()
    {
        $userId = $this->getUserId();

        if (! $userId) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }

        $keperluan = trim(
            (string) $this->request
                ->getPost('keperluan')
        );

        $deskripsi = trim(
            (string) $this->request
                ->getPost('deskripsi')
        );

        $idTujuan = (int) $this->request
            ->getPost('id_tujuan');

        /*
         * Validasi data utama
         */
        if (
            $idTujuan <= 0 ||
            $keperluan === ''
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Tujuan dan keperluan wajib diisi.'
                );
        }

        /*
         * Pastikan tujuan benar-benar ada
         */
        $tujuanModel = new TujuanModel();

        if (! $tujuanModel->find($idTujuan)) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Tujuan permohonan tidak valid.'
                );
        }

        /*
         * Ambil semua foto bukti fisik
         */
        $buktiFisikFiles =
            $this->request
                ->getFileMultiple('foto_bukti');

        $buktiFisikFiles =
            is_array($buktiFisikFiles)
                ? $buktiFisikFiles
                : [];

        /*
         * Buang input file yang kosong
         */
        $buktiFisikFiles = array_values(
            array_filter(
                $buktiFisikFiles,
                static function ($file) {
                    return $file &&
                        $file->getError()
                            !== UPLOAD_ERR_NO_FILE;
                }
            )
        );

        /*
         * Minimal 1 foto
         */
        if (
            count($buktiFisikFiles) === 0
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Minimal upload 1 foto bukti pengumpulan berkas fisik.'
                );
        }

        /*
         * Maksimal 10 foto
         */
        $maxFoto = 10;

        if (
            count($buktiFisikFiles) >
            $maxFoto
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Maksimal ' .
                    $maxFoto .
                    ' foto bukti yang dapat diunggah.'
                );
        }

        /*
         * Format foto yang diperbolehkan
         */
        $allowedMime = [
            'image/jpeg',
            'image/png',
            'image/jpg',
            'image/webp',
        ];

        /*
         * Validasi SEMUA foto terlebih dahulu.
         * Tujuannya supaya tidak ada upload setengah jalan.
         */
        foreach ($buktiFisikFiles as $file) {

            if (
                ! $file ||
                ! $file->isValid() ||
                $file->hasMoved()
            ) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Salah satu foto bukti tidak dapat dibaca. Silakan pilih ulang.'
                    );
            }

            if (
                ! in_array(
                    $file->getMimeType(),
                    $allowedMime,
                    true
                )
            ) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Foto bukti harus berupa JPG, JPEG, PNG, atau WEBP.'
                    );
            }

            if (
                $file->getSizeByUnit('mb') >
                5
            ) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Ukuran setiap foto bukti maksimal 5 MB.'
                    );
            }
        }

        $permohonanModel =
            new PermohonanModel();

        /*
         * Simpan permohonan
         */
        $idPermohonan =
            $permohonanModel->insert(
                [
                    'id_user' => $userId,
                    'id_tujuan' => $idTujuan,
                    'id_status' => 1,
                    'keperluan' => $keperluan,
                    'deskripsi' =>
                        $deskripsi !== ''
                            ? $deskripsi
                            : null,

                    /*
                     * Kolom lama tetap diisi
                     * dengan foto pertama.
                     */
                    'bukti_fisik' => null,

                    'tanggal_pengajuan' =>
                        date(
                            'Y-m-d H:i:s'
                        ),
                ],
                true
            );

        if (! $idPermohonan) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Permohonan gagal disimpan.'
                );
        }

        /*
         * Folder penyimpanan foto
         */
        $buktiModel =
            new BuktiFisikPermohonanModel();

        $folderBukti =
            FCPATH .
            'uploads' .
            DIRECTORY_SEPARATOR .
            'bukti_fisik';

        if (
            ! is_dir($folderBukti)
        ) {
            mkdir(
                $folderBukti,
                0777,
                true
            );
        }

        $fotoPertama = null;

        /*
         * Simpan semua foto ke tabel
         * bukti_fisik_permohonan
         */
        foreach (
            $buktiFisikFiles
            as $index => $file
        ) {
            $namaFoto =
                $file->getRandomName();

            $file->move(
                $folderBukti,
                $namaFoto
            );

            $buktiModel->insert(
                [
                    'id_permohonan' =>
                        $idPermohonan,

                    'nama_file' =>
                        $namaFoto,
                ]
            );

            if ($index === 0) {
                $fotoPertama =
                    $namaFoto;
            }
        }

        /*
         * Simpan foto pertama ke kolom lama
         */
        if (
            $fotoPertama !== null
        ) {
            $permohonanModel->update(
                $idPermohonan,
                [
                    'bukti_fisik' =>
                        $fotoPertama,
                ]
            );
        }

        /*
         * =================================================
         * NOTIFIKASI ADMIN
         * =================================================
         */
        $notification =
            new NotificationService();

        $admins = db_connect()
            ->table('users')
            ->select('id_user')
            ->where(
                'role',
                'admin'
            )
            ->get()
            ->getResultArray();

        $namaMahasiswa =
            (string) (
                session(
                    'nama_lengkap'
                ) ?? 'Mahasiswa'
            );

        foreach (
            $admins as $admin
        ) {
            $notification->create(
                (int) $admin['id_user'],
                'Permohonan Baru',
                $namaMahasiswa .
                ' mengajukan permohonan baru #' .
                $idPermohonan .
                '. Silakan periksa permohonan tersebut.',
                'admin/permohonan/' .
                $idPermohonan
            );
        }

        /*
         * Redirect ke detail
         */
        return redirect()
            ->to(
                site_url(
                    'mahasiswa/permohonan/' .
                    $idPermohonan
                )
            )
            ->with(
                'success',
                'Permohonan berhasil diajukan.'
            );
    }


    /**
     * =====================================================
     * DETAIL PERMOHONAN
     * =====================================================
     */
    public function show(int $id)
    {
        $userId = $this->getUserId();

        if (! $userId) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }

        /*
         * Ambil permohonan milik mahasiswa
         */
        $permohonan =
            (new PermohonanModel())
                ->select(
                    'permohonan.*,
                     tujuan.nama_tujuan,
                     status.nama_status'
                )
                ->join(
                    'tujuan',
                    'tujuan.id_tujuan = permohonan.id_tujuan'
                )
                ->join(
                    'status',
                    'status.id_status = permohonan.id_status'
                )
                ->where(
                    'permohonan.id_permohonan',
                    $id
                )
                ->where(
                    'permohonan.id_user',
                    $userId
                )
                ->first();

        if (! $permohonan) {
            return redirect()
                ->to(
                    site_url(
                        'mahasiswa/permohonan'
                    )
                )
                ->with(
                    'error',
                    'Permohonan tidak ditemukan.'
                );
        }

        /*
         * Ambil semua bukti fisik
         */
        $buktiFisik =
            (new BuktiFisikPermohonanModel())
                ->where(
                    'id_permohonan',
                    $id
                )
                ->orderBy(
                    'id_bukti',
                    'ASC'
                )
                ->findAll();

        /*
         * Fallback data lama
         */
        if (
            empty($buktiFisik) &&
            ! empty(
                $permohonan['bukti_fisik']
            )
        ) {
            $buktiFisik = [
                [
                    'id_bukti' =>
                        null,

                    'id_permohonan' =>
                        $id,

                    'nama_file' =>
                        $permohonan[
                            'bukti_fisik'
                        ],
                ],
            ];
        }

        $totalBuktiFisik =
            count($buktiFisik);

        /*
         * Progress berdasarkan status
         */
        $progress = match (
            (int) $permohonan['id_status']
        ) {
            1 => 25,
            2 => 50,
            3 => 25,
            4, 5 => 100,
            default => 0,
        };

        /*
         * Data dikirim ke view.
         *
         * 'berkas' tetap dikirim sebagai array kosong
         * agar view lama yang masih memakai variabel
         * tersebut tidak langsung menghasilkan undefined variable.
         */
        return view(
            'mahasiswa/show',
            [
                'permohonan' =>
                    $permohonan,

                'berkas' => [],

                'buktiFisik' =>
                    $buktiFisik,

                'totalBuktiFisik' =>
                    $totalBuktiFisik,

                'totalBerkas' => 0,

                'selesaiBerkas' => 0,

                'progress' =>
                    $progress,

                ...$this->notificationData(
                    $userId
                ),
            ]
        );
    }


    /**
     * =====================================================
     * UPDATE / UBAH BUKTI FISIK
     * =====================================================
     *
     * Mahasiswa dapat:
     * - mempertahankan foto lama
     * - menghapus foto lama
     * - menambahkan foto baru
     *
     * Maksimal total tetap 10 foto.
     */
    public function updateBuktiFisik(int $id)
    {
        $userId = $this->getUserId();

        if (! $userId) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }

        $permohonanModel =
            new PermohonanModel();

        /*
         * Pastikan permohonan memang milik
         * mahasiswa yang sedang login.
         */
        $permohonan =
            $permohonanModel
                ->where(
                    'id_permohonan',
                    $id
                )
                ->where(
                    'id_user',
                    $userId
                )
                ->first();

        if (! $permohonan) {
            return redirect()
                ->to(
                    site_url(
                        'mahasiswa/permohonan'
                    )
                )
                ->with(
                    'error',
                    'Permohonan tidak ditemukan.'
                );
        }

        /*
         * Bukti fisik hanya boleh diubah
         * ketika status Diajukan atau Ditolak.
         */
        if (
            ! in_array(
                (int) $permohonan['id_status'],
                [1, 3],
                true
            )
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Bukti fisik tidak dapat diubah pada status permohonan ini.'
                );
        }

        $buktiModel =
            new BuktiFisikPermohonanModel();

        /*
         * Ambil semua foto lama
         */
        $existing =
            $buktiModel
                ->where(
                    'id_permohonan',
                    $id
                )
                ->orderBy(
                    'id_bukti',
                    'ASC'
                )
                ->findAll();

        /*
         * ID foto yang tetap dipertahankan
         */
        $keepIds = array_map(
            'intval',
            (array) $this->request
                ->getPost('keep_bukti')
        );

        /*
         * Folder foto
         */
        $folder =
            FCPATH .
            'uploads' .
            DIRECTORY_SEPARATOR .
            'bukti_fisik';

        if (
            ! is_dir($folder)
        ) {
            mkdir(
                $folder,
                0777,
                true
            );
        }

        /*
         * Hapus foto lama yang tidak dicentang
         */
        foreach (
            $existing as $row
        ) {
            $idBukti =
                (int) $row['id_bukti'];

            if (
                ! in_array(
                    $idBukti,
                    $keepIds,
                    true
                )
            ) {
                $oldPath =
                    $folder .
                    DIRECTORY_SEPARATOR .
                    $row['nama_file'];

                if (
                    is_file($oldPath)
                ) {
                    @unlink(
                        $oldPath
                    );
                }

                $buktiModel->delete(
                    $idBukti
                );
            }
        }

        /*
         * Ambil file tambahan
         */
        $files =
            $this->request
                ->getFileMultiple(
                    'foto_bukti_tambahan'
                );

        $files =
            is_array($files)
                ? $files
                : [];

        $files = array_values(
            array_filter(
                $files,
                static function ($file) {
                    return $file &&
                        $file->getError()
                            !== UPLOAD_ERR_NO_FILE;
                }
            )
        );

        /*
         * Hitung foto yang masih tersimpan
         */
        $kept =
            $buktiModel
                ->where(
                    'id_permohonan',
                    $id
                )
                ->findAll();

        $currentCount =
            count($kept);

        /*
         * Total tidak boleh lebih dari 10
         */
        if (
            $currentCount +
            count($files) >
            10
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Maksimal total 10 foto bukti fisik.'
                );
        }

        $allowedMime = [
            'image/jpeg',
            'image/png',
            'image/jpg',
            'image/webp',
        ];

        /*
         * Validasi file tambahan
         */
        foreach (
            $files as $file
        ) {
            if (
                ! $file ||
                ! $file->isValid() ||
                $file->hasMoved()
            ) {
                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Salah satu foto tambahan tidak dapat dibaca.'
                    );
            }

            if (
                ! in_array(
                    $file->getMimeType(),
                    $allowedMime,
                    true
                )
            ) {
                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Foto harus berupa JPG, JPEG, PNG, atau WEBP.'
                    );
            }

            if (
                $file->getSizeByUnit('mb') >
                5
            ) {
                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Ukuran setiap foto maksimal 5 MB.'
                    );
            }
        }

        /*
         * Simpan file tambahan
         */
        foreach (
            $files as $file
        ) {
            $namaFoto =
                $file->getRandomName();

            $file->move(
                $folder,
                $namaFoto
            );

            $buktiModel->insert(
                [
                    'id_permohonan' =>
                        $id,

                    'nama_file' =>
                        $namaFoto,
                ]
            );
        }

        /*
         * Pastikan masih ada minimal 1 foto
         */
        $finalPhotos =
            $buktiModel
                ->where(
                    'id_permohonan',
                    $id
                )
                ->orderBy(
                    'id_bukti',
                    'ASC'
                )
                ->findAll();

        if (
            count($finalPhotos) === 0
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Minimal harus ada 1 foto bukti fisik.'
                );
        }

        /*
         * Update kolom legacy dengan foto pertama
         */
        $fotoPertama =
            $finalPhotos[0]['nama_file'];

        $updateData = [
            'bukti_fisik' =>
                $fotoPertama,
        ];

        /*
         * Jika sebelumnya ditolak,
         * setelah diperbaiki kembali ke Diproses.
         */
        if (
            (int) $permohonan['id_status'] === 3
        ) {
            $updateData['id_status'] = 2;

            $updateData[
                'keterangan_penolakan'
            ] = null;
        }

        $permohonanModel->update(
            $id,
            $updateData
        );

        /*
         * Notifikasi admin
         */
        $notification =
            new NotificationService();

        $admins = db_connect()
            ->table('users')
            ->select('id_user')
            ->where(
                'role',
                'admin'
            )
            ->get()
            ->getResultArray();

        $namaMahasiswa =
            (string) (
                session(
                    'nama_lengkap'
                ) ?? 'Mahasiswa'
            );

        foreach (
            $admins as $admin
        ) {
            $notification->create(
                (int) $admin['id_user'],
                'Bukti Fisik Diperbarui',
                $namaMahasiswa .
                ' memperbarui bukti fisik permohonan #' .
                $id .
                '. Silakan periksa kembali.',
                'admin/permohonan/' .
                $id
            );
        }

        return redirect()
            ->to(
                site_url(
                    'mahasiswa/permohonan/' .
                    $id
                )
            )
            ->with(
                'success',
                'Bukti fisik berhasil diperbarui.'
            );
    }


    /**
     * =====================================================
     * REUPLOAD LAMA
     * =====================================================
     *
     * Method ini dipertahankan supaya route lama
     * tidak menghasilkan "method not found".
     *
     * Sistem baru menggunakan updateBuktiFisik().
     */
    public function reupload(int $id)
    {
        return redirect()
            ->to(
                site_url(
                    'mahasiswa/permohonan/' .
                    $id
                )
            )
            ->with(
                'error',
                'Fitur pengajuan ulang dokumen digital sudah tidak digunakan. Silakan gunakan fitur Ubah Bukti Fisik.'
            );
    }


    /**
     * =====================================================
     * PROFIL MAHASISWA
     * =====================================================
     */
    public function profil()
    {
        $userId = $this->getUserId();

        if (! $userId) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }

        $user =
            (new UserModel())
                ->find($userId);

        if (
            ! $user ||
            $user['role'] !==
            'mahasiswa'
        ) {
            return redirect()
                ->to(
                    site_url('mahasiswa')
                )
                ->with(
                    'error',
                    'Data profil tidak ditemukan.'
                );
        }

        return view(
            'mahasiswa/profil',
            [
                'user' => $user,

                ...$this->notificationData(
                    $userId
                ),
            ]
        );
    }


    /**
     * =====================================================
     * UPDATE PROFIL MAHASISWA
     * =====================================================
     */
    public function updateProfil()
    {
        $userId = $this->getUserId();

        if (! $userId) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }

        $nama =
            trim(
                (string) $this->request
                    ->getPost(
                        'nama_lengkap'
                    )
            );

        $email =
            trim(
                (string) $this->request
                    ->getPost(
                        'email'
                    )
            );

        $noHp =
            trim(
                (string) $this->request
                    ->getPost(
                        'no_hp'
                    )
            );

        if (
            $nama === '' ||
            $email === ''
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Nama lengkap dan email wajib diisi.'
                );
        }

        if (
            ! filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            )
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Format email tidak valid.'
                );
        }

        $userModel =
            new UserModel();

        $existing =
            $userModel
                ->where(
                    'email',
                    $email
                )
                ->where(
                    'id_user !=',
                    $userId
                )
                ->first();

        if ($existing) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Email tersebut sudah digunakan akun lain.'
                );
        }

        $userModel->update(
            $userId,
            [
                'nama_lengkap' =>
                    $nama,

                'email' =>
                    $email,

                'no_hp' =>
                    $noHp !== ''
                        ? $noHp
                        : null,
            ]
        );

        session()->set(
            [
                'nama_lengkap' =>
                    $nama,
            ]
        );

        return redirect()
            ->to(
                site_url(
                    'mahasiswa/profil'
                )
            )
            ->with(
                'success',
                'Profil berhasil diperbarui.'
            );
    }


    /**
     * =====================================================
     * PENGATURAN AKUN
     * =====================================================
     */
    public function pengaturan()
    {
        $userId = $this->getUserId();

        if (! $userId) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }

        return view(
            'mahasiswa/pengaturan',
            [
                ...$this->notificationData(
                    $userId
                ),
            ]
        );
    }


    /**
     * =====================================================
     * UPDATE PASSWORD
     * =====================================================
     */
    public function updatePassword()
    {
        $userId = $this->getUserId();

        if (! $userId) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }

        $passwordLama =
            (string) $this->request
                ->getPost(
                    'password_lama'
                );

        $passwordBaru =
            (string) $this->request
                ->getPost(
                    'password_baru'
                );

        $konfirmasi =
            (string) $this->request
                ->getPost(
                    'konfirmasi_password'
                );

        if (
            $passwordLama === '' ||
            $passwordBaru === '' ||
            $konfirmasi === ''
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Semua kolom password wajib diisi.'
                );
        }

        if (
            strlen($passwordBaru) <
            6
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Password baru minimal 6 karakter.'
                );
        }

        if (
            $passwordBaru !==
            $konfirmasi
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Konfirmasi password tidak sama.'
                );
        }

        $userModel =
            new UserModel();

        $user =
            $userModel->find(
                $userId
            );

        if (
            ! $user ||
            ! password_verify(
                $passwordLama,
                $user['password']
            )
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Password lama yang kamu masukkan salah.'
                );
        }

        $userModel->update(
            $userId,
            [
                'password' =>
                    password_hash(
                        $passwordBaru,
                        PASSWORD_DEFAULT
                    ),
            ]
        );

        return redirect()
            ->to(
                site_url(
                    'mahasiswa/pengaturan'
                )
            )
            ->with(
                'success',
                'Password berhasil diubah.'
            );
    }
}