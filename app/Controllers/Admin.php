<?php

namespace App\Controllers;

use App\Libraries\NotificationService;
use App\Models\BerkasPermohonanModel;
use App\Models\BuktiFisikPermohonanModel;
use App\Models\BuktiPengambilanPermohonanModel;
use App\Models\PermohonanModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
/**
 * =====================================================
 * DASHBOARD ADMIN
 * =====================================================
 */
public function index()
{
    $permohonan = new PermohonanModel();

    /*
     * =====================================================
     * DATA PERMOHONAN TERBARU
     * =====================================================
     */
    $data['permohonan'] = $permohonan
        ->select(
            'permohonan.*,
             users.nama_lengkap,
             users.nim,
             tujuan.nama_tujuan,
             status.nama_status'
        )
        ->join(
            'users',
            'users.id_user = permohonan.id_user'
        )
        ->join(
            'tujuan',
            'tujuan.id_tujuan = permohonan.id_tujuan'
        )
        ->join(
            'status',
            'status.id_status = permohonan.id_status'
        )
        ->orderBy(
            'permohonan.id_permohonan',
            'DESC'
        )
        ->findAll();

    /*
     * =====================================================
     * STATUS MENUNGGU VERIFIKASI PENGAMBILAN
     * =====================================================
     */
    $pendingPickupStatus = db_connect()
        ->table('status')
        ->where(
            'nama_status',
            'MENUNGGU VERIFIKASI PENGAMBILAN'
        )
        ->get()
        ->getRowArray();

    $pendingPickupStatusId = $pendingPickupStatus
        ? (int) $pendingPickupStatus['id_status']
        : 0;

    /*
     * =====================================================
     * STATISTIK
     *
     * 1 = Diajukan
     * 2 = Diproses
     * 3 = Ditolak
     * 4 = Selesai
     * 5 = Diambil
     * =====================================================
     */
    $data['statistik'] = [
        'total' => (new PermohonanModel())
            ->countAll(),

        'diajukan' => (new PermohonanModel())
            ->where('id_status', 1)
            ->countAllResults(),

        'diproses' => (new PermohonanModel())
            ->where('id_status', 2)
            ->countAllResults(),

        'ditolak' => (new PermohonanModel())
            ->where('id_status', 3)
            ->countAllResults(),

        'selesai' => (new PermohonanModel())
            ->where('id_status', 4)
            ->countAllResults(),

        'diambil' => (new PermohonanModel())
            ->where('id_status', 5)
            ->countAllResults(),

        'menunggu_pengambilan' => 0,
    ];

    /*
     * =====================================================
     * HITUNG MENUNGGU VERIFIKASI PENGAMBILAN
     * =====================================================
     */
    if ($pendingPickupStatusId > 0) {
        $data['statistik']['menunggu_pengambilan'] =
            (new PermohonanModel())
                ->where(
                    'id_status',
                    $pendingPickupStatusId
                )
                ->countAllResults();
    }

    /*
     * Kirim ID status ke dashboard
     * agar tombol "Verifikasi Pengambilan"
     * bisa mengarah ke filter yang benar.
     */
    $data['pendingPickupStatusId'] = $pendingPickupStatusId;

    /*
     * =====================================================
     * LIMA AKTIVITAS TERBARU
     * =====================================================
     */
    $data['aktivitas'] = array_slice(
        $data['permohonan'],
        0,
        5
    );
    /*
 * =====================================================
 * PERMOHONAN PERLU PERHATIAN
 *
 * Diajukan:
 * - Menunggu pemeriksaan admin
 *
 * Menunggu Verifikasi Pengambilan:
 * - Menunggu pemeriksaan bukti pengambilan
 * =====================================================
 */
$perluPerhatian = array_filter(
    $data['permohonan'],
    static function (array $item) use ($pendingPickupStatusId): bool {

        $statusId = (int) ($item['id_status'] ?? 0);

        return $statusId === 1
            || (
                $pendingPickupStatusId > 0
                && $statusId === $pendingPickupStatusId
            );
    }
);

usort(
    $perluPerhatian,
    static function (array $a, array $b) use ($pendingPickupStatusId): int {

        $statusA = (int) ($a['id_status'] ?? 0);
        $statusB = (int) ($b['id_status'] ?? 0);

        $priorityA = $statusA === $pendingPickupStatusId ? 1 : 2;
        $priorityB = $statusB === $pendingPickupStatusId ? 1 : 2;

        if ($priorityA !== $priorityB) {
            return $priorityA <=> $priorityB;
        }

        return (int) ($b['id_permohonan'] ?? 0)
            <=> (int) ($a['id_permohonan'] ?? 0);
    }
);

$data['perluPerhatian'] = array_slice(
    array_values($perluPerhatian),
    0,
    5
);

    return view(
        'admin/dashboard',
        $data
    );
}
    /**
     * =====================================================
     * SEMUA PERMOHONAN
     * =====================================================
     */
    public function all()
{
    $permohonanModel = new PermohonanModel();

    /*
     * =====================================================
     * FILTER DARI URL
     * =====================================================
     */
    $keyword = trim(
        (string) $this->request->getGet('keyword')
    );

    $statusFilter = trim(
        (string) $this->request->getGet('status')
    );


    /*
     * =====================================================
     * STATUS MENUNGGU VERIFIKASI PENGAMBILAN
     * =====================================================
     */
    $pendingPickupStatus = db_connect()
        ->table('status')
        ->where(
            'nama_status',
            'MENUNGGU VERIFIKASI PENGAMBILAN'
        )
        ->get()
        ->getRowArray();
    $pendingPickupStatusId = $pendingPickupStatus
        ? (int) $pendingPickupStatus['id_status']
        : 0;

    /*
     * =====================================================
     * STATISTIK GLOBAL
     *
     * Statistik ini TIDAK BOLEH terkena filter.
     * =====================================================
     */
    $statistik = [
        'total' => (new PermohonanModel())
            ->countAll(),

        'diajukan' => (new PermohonanModel())
            ->where('id_status', 1)
            ->countAllResults(),

        'diproses' => (new PermohonanModel())
            ->where('id_status', 2)
            ->countAllResults(),

        'ditolak' => (new PermohonanModel())
            ->where('id_status', 3)
            ->countAllResults(),

        'selesai' => (new PermohonanModel())
            ->where('id_status', 4)
            ->countAllResults(),

        'diambil' => (new PermohonanModel())
            ->where('id_status', 5)
            ->countAllResults(),

        'menunggu_pengambilan' => 0,
    ];


    /*
     * Hitung status menunggu verifikasi pengambilan
     */
    if ($pendingPickupStatus) {
        $statistik['menunggu_pengambilan'] =
            (new PermohonanModel())
                ->where(
                    'id_status',
                    (int) $pendingPickupStatus['id_status']
                )
                ->countAllResults();
    }


    /*
     * =====================================================
     * QUERY UTAMA DAFTAR PERMOHONAN
     *
     * Query ini BOLEH terkena filter.
     * =====================================================
     */
    $builder = $permohonanModel
        ->select(
            'permohonan.*,
             users.nama_lengkap,
             users.nim,
             tujuan.nama_tujuan,
             status.nama_status'
        )
        ->join(
            'users',
            'users.id_user = permohonan.id_user'
        )
        ->join(
            'tujuan',
            'tujuan.id_tujuan = permohonan.id_tujuan'
        )
        ->join(
            'status',
            'status.id_status = permohonan.id_status'
        );


    /*
     * =====================================================
     * SEARCH
     * =====================================================
     */
    if ($keyword !== '') {

        $builder
            ->groupStart()

            ->like(
                'users.nama_lengkap',
                $keyword
            )

            ->orLike(
                'users.nim',
                $keyword
            )

            ->orLike(
                'permohonan.id_permohonan',
                $keyword
            )

            ->orLike(
                'tujuan.nama_tujuan',
                $keyword
            )

            ->orLike(
                'status.nama_status',
                $keyword
            )

            ->groupEnd();
    }


    /*
     * =====================================================
     * FILTER STATUS
     * =====================================================
     */
    $allowedStatusFilters = [
        '1',
        '2',
        '3',
        '4',
        '5',
    ];

    if ($pendingPickupStatus) {
        $allowedStatusFilters[] =
            (string) $pendingPickupStatus['id_status'];
    }

    if (
        $statusFilter !== '' &&
        in_array(
            $statusFilter,
            $allowedStatusFilters,
            true
        )
    ) {

        $builder->where(
            'permohonan.id_status',
            (int) $statusFilter
        );
    }


    /*
     * =====================================================
     * AMBIL DATA HASIL FILTER
     * =====================================================
     */
    $data['permohonan'] = $builder
        ->orderBy(
            'permohonan.id_permohonan',
            'DESC'
        )
        ->findAll();


    /*
     * =====================================================
     * KIRIM DATA KE VIEW
     * =====================================================
     */
    $data['keyword'] = $keyword;
    $data['statusFilter'] = $statusFilter;
    $data['statistik'] = $statistik;
    $data['pendingPickupStatusId'] = $pendingPickupStatusId;

    return view(
        'admin/permohonan',
        $data
    );
}


    /**
     * =====================================================
     * DETAIL PERMOHONAN
     * =====================================================
     */
    public function show(int $id)
{
    $permohonan = new PermohonanModel();

    /*
     * Ambil data permohonan + mahasiswa
     */
    $row = $permohonan
        ->select(
            'permohonan.*,
             users.nama_lengkap,
             users.nim,
             users.email,
             users.no_hp,
             tujuan.nama_tujuan,
             status.nama_status'
        )
        ->join(
            'users',
            'users.id_user = permohonan.id_user'
        )
        ->join(
            'tujuan',
            'tujuan.id_tujuan = permohonan.id_tujuan'
        )
        ->join(
            'status',
            'status.id_status = permohonan.id_status'
        )
        ->find($id);

    /*
     * Jika tidak ditemukan
     */
    if (! $row) {
        return redirect()
            ->to('/admin/permohonan')
            ->with(
                'error',
                'Permohonan tidak ditemukan.'
            );
    }

    /*
     * Ambil seluruh berkas
     */
    $berkas = (new BerkasPermohonanModel())
        ->where(
            'id_permohonan',
            $id
        )
        ->findAll();

    $buktiFisik = (new BuktiFisikPermohonanModel())
        ->where('id_permohonan', $id)
        ->orderBy('id_bukti', 'ASC')
        ->findAll();

    if (empty($buktiFisik) && ! empty($row['bukti_fisik'])) {
        $buktiFisik = [[
            'id_bukti' => null,
            'id_permohonan' => $id,
            'nama_file' => $row['bukti_fisik'],
        ]];
    }

    /*
     * Ambil SEMUA bukti pengambilan
     */
    $buktiPengambilan = (new BuktiPengambilanPermohonanModel())
        ->where('id_permohonan', $id)
        ->orderBy('id_bukti_pengambilan', 'ASC')
        ->findAll();

    return view(
        'admin/show',
        [
            'permohonan' => $row,
            'berkas' => [],
            'buktiFisik' => $buktiFisik,
            'buktiPengambilan' => $buktiPengambilan,
        ]
    );
}


    /**
     * =====================================================
     * UPDATE STATUS PERMOHONAN
     * =====================================================
     */
    public function updateStatus(int $id)
    {
        $permohonanModel = new PermohonanModel();
        $notification = new NotificationService();

        $permohonan = $permohonanModel
            ->select(
                'permohonan.*,
                 users.nama_lengkap,
                 tujuan.nama_tujuan,
                 status.nama_status'
            )
            ->join('users', 'users.id_user = permohonan.id_user')
            ->join('tujuan', 'tujuan.id_tujuan = permohonan.id_tujuan')
            ->join('status', 'status.id_status = permohonan.id_status')
            ->find($id);

        if (! $permohonan) {
            return redirect()
                ->back()
                ->with('error', 'Permohonan tidak ditemukan.');
        }

        $statusLama = (int) $permohonan['id_status'];

        $statusName = strtoupper(
            trim(
                (string) $this->request->getPost('status')
            )
        );

        $keteranganPenolakan = trim(
            (string) $this->request->getPost('keterangan_penolakan')
        );

        /*
         * Mapping sesuai database:
         *
         * 1 = Diajukan
         * 2 = Diproses
         * 3 = Ditolak
         * 4 = Selesai
         * 5 = Diambil
         *
         * Status "Menunggu Verifikasi Pengambilan" mempunyai
         * ID sendiri dan tidak boleh diubah melalui form status umum.
         */
        $map = [
            'DIAJUKAN' => 1,
            'DIPROSES' => 2,
            'DITOLAK'  => 3,
            'SELESAI'  => 4,
        ];

        if ($statusName === 'DIAMBIL') {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Status Diambil ditentukan melalui verifikasi bukti pengambilan mahasiswa.'
                );
        }

        /*
         * Jangan biarkan status "Menunggu Verifikasi Pengambilan"
         * diubah melalui form status umum.
         */
        $pendingPickupStatus = db_connect()
            ->table('status')
            ->where(
                'nama_status',
                'MENUNGGU VERIFIKASI PENGAMBILAN'
            )
            ->get()
            ->getRowArray();

        if (
            $pendingPickupStatus &&
            $statusLama === (int) $pendingPickupStatus['id_status']
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Permohonan sedang menunggu verifikasi pengambilan. Gunakan menu verifikasi pengambilan.'
                );
        }

        $statusId = $map[$statusName] ?? null;

        if (! $statusId) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Status tidak valid.'
                );
        }

        /*
         * Status yang sama boleh disimpan kembali.
         * Yang dibatasi adalah perpindahan ke status lain.
         */
        if ($statusLama !== $statusId) {
            $allowedTransitions = [
                // Diajukan -> Diproses / Ditolak
                1 => [2, 3],

                // Diproses -> Ditolak / Selesai
                2 => [3, 4],

                // Ditolak -> Diproses
                // Biasanya perubahan ini dilakukan otomatis ketika
                // mahasiswa memperbaiki bukti fisik.
                3 => [2],

                // Selesai adalah tahap sebelum mahasiswa mengambil
                // dokumen. Perubahan status dilakukan melalui alur
                // pengambilan, bukan form status umum.
                4 => [],

                // Diambil adalah status akhir.
                5 => [],
            ];

            $allowed = $allowedTransitions[$statusLama] ?? [];

            if (! in_array($statusId, $allowed, true)) {
                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Perubahan status tidak mengikuti alur permohonan.'
                    );
            }
        }

        /*
         * Alasan penolakan wajib diisi.
         */
        if (
            $statusName === 'DITOLAK' &&
            $keteranganPenolakan === ''
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Alasan penolakan wajib diisi terlebih dahulu.'
                );
        }

        /*
         * Jika status bukan Ditolak, bersihkan alasan penolakan
         * agar catatan lama tidak tertinggal pada permohonan
         * yang sudah kembali diproses/selesai.
         */
        $data = [
            'id_status' => $statusId,
        ];

        if ($statusName === 'DITOLAK') {
            $data['keterangan_penolakan'] = $keteranganPenolakan;
        } elseif ($statusLama === 3) {
            $data['keterangan_penolakan'] = null;
        }

        if (
            $statusName === 'SELESAI' &&
            $statusLama !== $statusId
        ) {
            $data['tanggal_selesai'] = date('Y-m-d H:i:s');
        }

        /*
         * Update database.
         */
        if (! $permohonanModel->update($id, $data)) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Gagal memperbarui status permohonan.'
                );
        }

        /*
         * Kirim notifikasi hanya ketika status benar-benar berubah.
         */
        if ($statusLama !== $statusId) {
            $pesan = match ($statusName) {
                'DIAJUKAN' => 'Permohonan #' . $id . ' berstatus Diajukan.',
                'DIPROSES' => 'Permohonan #' . $id . ' sedang diproses oleh admin.',
                'DITOLAK'  => 'Permohonan #' . $id . ' ditolak. Alasan: ' . $keteranganPenolakan,
                'SELESAI'  => 'Permohonan #' . $id . ' telah selesai dan siap diambil.',
                default    => 'Status permohonan #' . $id . ' telah diperbarui.',
            };

            $notification->create(
                (int) $permohonan['id_user'],
                'Status Permohonan Diperbarui',
                $pesan,
                'mahasiswa/permohonan/' . $id
            );
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Status permohonan berhasil diperbarui.'
            );
    }

    /**
     * =====================================================
     * UPDATE STATUS BERKAS
     * =====================================================
     */

    /**
     * =====================================================
     * TANDAI SUDAH DIAMBIL
     * =====================================================
     */

    /**
     * =====================================================
     * VERIFIKASI BUKTI PENGAMBILAN
     * =====================================================
     */
public function verifikasiPengambilan(int $id)
{
    $decision = strtoupper(
        trim(
            (string) $this->request->getPost('keputusan')
        )
    );

    $catatan = trim(
        (string) $this->request->getPost('catatan_verifikasi')
    );

    if (! in_array($decision, ['DITERIMA', 'DITOLAK'], true)) {
        return redirect()
            ->back()
            ->with(
                'error',
                'Keputusan verifikasi tidak valid.'
            );
    }

    $db = db_connect();

    $permohonanModel = new PermohonanModel();

    $permohonan = $permohonanModel
        ->select(
            'permohonan.*,
             users.nama_lengkap,
             status.nama_status'
        )
        ->join(
            'users',
            'users.id_user = permohonan.id_user'
        )
        ->join(
            'status',
            'status.id_status = permohonan.id_status'
        )
        ->find($id);

    if (! $permohonan) {
        return redirect()
            ->back()
            ->with(
                'error',
                'Permohonan tidak ditemukan.'
            );
    }
    

    /*
     * =====================================================
     * CEK STATUS MENUNGGU VERIFIKASI PENGAMBILAN
     * =====================================================
     */
    $pendingStatus = $db
        ->table('status')
        ->where(
            'nama_status',
            'MENUNGGU VERIFIKASI PENGAMBILAN'
        )
        ->get()
        ->getRowArray();

    if (
        ! $pendingStatus
        || (int) $permohonan['id_status']
            !== (int) $pendingStatus['id_status']
    ) {
        return redirect()
            ->back()
            ->with(
                'error',
                'Permohonan tidak sedang menunggu verifikasi pengambilan.'
            );
    }

    /*
     * =====================================================
     * AMBIL SEMUA BUKTI YANG MASIH MENUNGGU
     * =====================================================
     */
    $buktiModel = new BuktiPengambilanPermohonanModel();

    $buktiMenunggu = $buktiModel
        ->where(
            'id_permohonan',
            $id
        )
        ->where(
            'status_verifikasi',
            'menunggu'
        )
        ->orderBy(
            'id_bukti_pengambilan',
            'DESC'
        )
        ->findAll();

    if (empty($buktiMenunggu)) {
        return redirect()
            ->back()
            ->with(
                'error',
                'Bukti pengambilan yang menunggu verifikasi belum tersedia.'
            );
    }

    /*
     * =====================================================
     * SIAPKAN HASIL VERIFIKASI
     * =====================================================
     */
    if ($decision === 'DITERIMA') {

        $statusBukti = 'diterima';
        $keterangan = $catatan !== ''
            ? $catatan
            : null;

        $statusPermohonan = 5;
        $tanggalDiambil = date('Y-m-d H:i:s');

        $title = 'Pengambilan Diverifikasi';

        $message =
            'Bukti pengambilan permohonan #'
            . $id
            . ' telah diverifikasi. Status menjadi Diambil.';

        $successMessage =
            'Semua foto bukti pengambilan berhasil diverifikasi.';

    } else {

        $statusBukti = 'ditolak';

        $keterangan = $catatan !== ''
            ? $catatan
            : 'Bukti pengambilan belum dapat diverifikasi. '
              . 'Silakan unggah ulang foto yang sesuai.';

        /*
         * Jika ditolak, permohonan kembali ke Selesai
         * agar mahasiswa dapat mengunggah ulang.
         */
        $statusPermohonan = 4;
        $tanggalDiambil = null;

        $title = 'Bukti Pengambilan Ditolak';

        $message =
            'Bukti pengambilan permohonan #'
            . $id
            . ' belum dapat diverifikasi. '
            . $keterangan;

        $successMessage =
            'Semua foto bukti pengambilan ditolak dan mahasiswa dapat mengunggah ulang.';
    }

    /*
     * =====================================================
     * TRANSACTION
     * =====================================================
     *
     * Foto bukti + status permohonan harus berhasil
     * bersama-sama.
     */
    $db->transBegin();

    try {

        /*
         * Update semua foto bukti pengambilan
         */
        foreach ($buktiMenunggu as $bukti) {

            $updated = $buktiModel->update(
                (int) $bukti['id_bukti_pengambilan'],
                [
                    'status_verifikasi' => $statusBukti,
                    'keterangan'        => $keterangan,
                ]
            );

            if (! $updated) {
                throw new \RuntimeException(
                    'Gagal memperbarui bukti pengambilan.'
                );
            }
        }

        /*
         * Update status permohonan
         */
        $updatedPermohonan = $permohonanModel->update(
            $id,
            [
                'id_status'       => $statusPermohonan,
                'tanggal_diambil' => $tanggalDiambil,
            ]
        );

        if (! $updatedPermohonan) {
            throw new \RuntimeException(
                'Gagal memperbarui status permohonan.'
            );
        }

        /*
         * Cek transaction
         */
        if (! $db->transStatus()) {
            throw new \RuntimeException(
                'Transaction database gagal.'
            );
        }

        $db->transCommit();

    } catch (\Throwable $e) {

        $db->transRollback();

        log_message(
            'error',
            'Verifikasi pengambilan gagal untuk permohonan #{id}: {message}',
            [
                'id'      => $id,
                'message' => $e->getMessage(),
            ]
        );

        return redirect()
            ->back()
            ->with(
                'error',
                'Verifikasi gagal. Tidak ada perubahan data yang disimpan.'
            );
    }

    /*
     * =====================================================
     * KIRIM NOTIFIKASI
     * =====================================================
     */
    (new NotificationService())->create(
        (int) $permohonan['id_user'],
        $title,
        $message,
        'mahasiswa/permohonan/' . $id
    );

    return redirect()
        ->back()
        ->with(
            'success',
            $successMessage
        );
}

/**
 * =====================================================
 * MANAGE USER
 * =====================================================
 */
public function users()
{
    $userModel = new UserModel();

    $currentUserId = (int) session('id_user');

    /*
     * =====================================================
     * AMBIL USER AKTIF UNTUK STATISTIK
     * =====================================================
     *
     * 1 = Aktif
     * 2 = Tidak Aktif
     */
    $allUsers = $userModel
        ->select(
            'id_user,
             nama_lengkap,
             nim,
             email,
             no_hp,
             role,
             id_status_akun,
             created_at'
        )
        ->where(
            'id_status_akun',
            1
        )
        ->orderBy(
            'id_user',
            'DESC'
        )
        ->findAll();

    /*
     * =====================================================
     * HITUNG STATISTIK USER AKTIF
     * =====================================================
     */
    $totalUsers = count($allUsers);

    $totalMahasiswa = 0;
    $totalAdmin = 0;
    $totalSuperAdmin = 0;

    foreach ($allUsers as $user) {

        switch ($user['role'] ?? '') {

            case 'mahasiswa':
                $totalMahasiswa++;
                break;

            case 'admin':
                $totalAdmin++;
                break;

            case 'super_admin':
                $totalSuperAdmin++;
                break;
        }
    }

    /*
     * =====================================================
     * DATA UNTUK TABEL
     * =====================================================
     *
     * Akun yang sedang login tidak ditampilkan.
     */
    $users = array_values(
        array_filter(
            $allUsers,
            static function ($user) use ($currentUserId) {
                return (int) $user['id_user'] !== $currentUserId;
            }
        )
    );

    /*
     * =====================================================
     * KIRIM DATA KE VIEW
     * =====================================================
     */
    return view(
        'admin/users',
        [
            'users'           => $users,
            'totalUsers'      => $totalUsers,
            'totalMahasiswa'  => $totalMahasiswa,
            'totalAdmin'      => $totalAdmin,
            'totalSuperAdmin' => $totalSuperAdmin,
        ]
    );
}

/**
 * =====================================================
 * DETAIL USER
 * =====================================================
 */
public function userDetail(int $id)
{
    $userModel = new UserModel();

    $currentUserId = (int) session('id_user');

    if ($id === $currentUserId) {
        return redirect()
            ->to(site_url('admin/users'))
            ->with(
                'error',
                'Anda tidak dapat membuka detail akun sendiri melalui Manage User.'
            );
    }

    $user = $userModel
        ->select(
            'id_user,
             nama_lengkap,
             nim,
             email,
             no_hp,
             role,
             created_at,
             updated_at'
        )
        ->find($id);

    if (! $user) {
        return redirect()
            ->to(site_url('admin/users'))
            ->with(
                'error',
                'Data user tidak ditemukan.'
            );
    }

    return view(
        'admin/user_detail',
        [
            'user' => $user,
        ]
    );
}

/**
 * =====================================================
 * EDIT USER
 * =====================================================
 */
public function editUser(int $id)
{
    $userModel = new UserModel();

    $currentUserId = (int) session('id_user');

    if ($id === $currentUserId) {
        return redirect()
            ->to(site_url('admin/users'))
            ->with(
                'error',
                'Akun yang sedang digunakan tidak dapat diedit melalui Manage User.'
            );
    }

    $user = $userModel->find($id);

    if (! $user) {
        return redirect()
            ->to(site_url('admin/users'))
            ->with(
                'error',
                'Data user tidak ditemukan.'
            );
    }

    return view(
        'admin/user_edit',
        [
            'user' => $user,
        ]
    );
}
/**
 * =====================================================
 * NONAKTIFKAN USER
 * =====================================================
 */
public function deleteUser(int $id)
{
    $userModel = new UserModel();

    $currentUserId = (int) session('id_user');

    /*
     * Tidak boleh menonaktifkan akun sendiri
     */
    if ($id === $currentUserId) {
        return redirect()
            ->to(site_url('admin/users'))
            ->with(
                'error',
                'Akun yang sedang digunakan tidak dapat dinonaktifkan.'
            );
    }

    /*
     * Cek user
     */
    $user = $userModel->find($id);

    if (! $user) {
        return redirect()
            ->to(site_url('admin/users'))
            ->with(
                'error',
                'Data user tidak ditemukan.'
            );
    }

    /*
     * Nonaktifkan akun
     * 1 = Aktif
     * 2 = Tidak Aktif
     */
    if (! $userModel->update(
        $id,
        [
            'id_status_akun' => 2,
        ]
    )) {
        return redirect()
            ->to(site_url('admin/users'))
            ->with(
                'error',
                'Gagal menonaktifkan akun.'
            );
    }

    return redirect()
        ->to(site_url('admin/users'))
        ->with(
            'success',
            'Akun berhasil dinonaktifkan.'
        );
}
/**
 * =====================================================
 * UPDATE USER
 * =====================================================
 */
public function updateUser(int $id)
{
    $userModel = new UserModel();

    $currentUserId = (int) session('id_user');

    // Tidak boleh mengubah akun sendiri
    if ($id === $currentUserId) {
        return redirect()
            ->to(site_url('admin/users'))
            ->with(
                'error',
                'Akun yang sedang digunakan tidak dapat diubah melalui Manage User.'
            );
    }

    // Cek user
    $user = $userModel->find($id);

    if (! $user) {
        return redirect()
            ->to(site_url('admin/users'))
            ->with(
                'error',
                'Data user tidak ditemukan.'
            );
    }

    // Ambil input form
    $namaLengkap = trim(
        (string) $this->request->getPost('nama_lengkap')
    );

    $email = trim(
        (string) $this->request->getPost('email')
    );

    $noHp = trim(
        (string) $this->request->getPost('no_hp')
    );

    $nim = trim(
        (string) $this->request->getPost('nim')
    );

    $role = trim(
        (string) $this->request->getPost('role')
    );

    // Validasi
    $rules = [
        'nama_lengkap' => 'required|min_length[3]|max_length[100]',
        'email'        => 'required|valid_email|max_length[100]',
        'no_hp'        => 'permit_empty|max_length[15]',
        'nim'          => 'permit_empty|max_length[20]',
        'role'         => 'required|in_list[mahasiswa,admin,super_admin]',
    ];

    if (! $this->validate($rules)) {
        return redirect()
            ->back()
            ->withInput()
            ->with(
                'error',
                'Data yang dimasukkan belum valid.'
            );
    }

    // Cek email tidak boleh dipakai user lain
    $emailExists = $userModel
        ->where('email', $email)
        ->where('id_user !=', $id)
        ->first();

    if ($emailExists) {
        return redirect()
            ->back()
            ->withInput()
            ->with(
                'error',
                'Email tersebut sudah digunakan oleh user lain.'
            );
    }

    // NIM hanya untuk mahasiswa
    if ($role !== 'mahasiswa') {
        $nim = null;
    }

    // Update database
    $updated = $userModel->update(
        $id,
        [
            'nama_lengkap' => $namaLengkap,
            'email'        => $email,
            'no_hp'        => $noHp !== '' ? $noHp : null,
            'nim'          => $nim !== '' ? $nim : null,
            'role'         => $role,
        ]
    );

    if (! $updated) {
        return redirect()
            ->back()
            ->withInput()
            ->with(
                'error',
                'Gagal memperbarui data user.'
            );
    }

    return redirect()
        ->to(site_url('admin/users/' . $id))
        ->with(
            'success',
            'Data user berhasil diperbarui.'
        );
}
    /**
     * =====================================================
     * LAPORAN & STATISTIK
     * =====================================================
     */
public function laporan()
{
    $permohonan = new PermohonanModel();

    /*
     * =================================================
     * FILTER TANGGAL
     * =================================================
     */

    $inputTanggalMulai = trim(
        (string) $this->request->getGet('mulai')
    );

    $inputTanggalAkhir = trim(
        (string) $this->request->getGet('akhir')
    );

    /*
     * Default:
     * tanggal awal  = hari pertama bulan berjalan
     * tanggal akhir  = hari terakhir bulan berjalan
     */
    $tanggalMulai = $inputTanggalMulai !== ''
        ? $inputTanggalMulai
        : date('Y-m-01');

    $tanggalAkhir = $inputTanggalAkhir !== ''
        ? $inputTanggalAkhir
        : date('Y-m-t');

    /*
     * =================================================
     * VALIDASI FORMAT TANGGAL
     * =================================================
     */
    $isValidDate = static function (string $date): bool {

        /*
         * Format wajib:
         * YYYY-MM-DD
         */
        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return false;
        }

        $parsed = \DateTime::createFromFormat(
            '!Y-m-d',
            $date
        );

        $errors = \DateTime::getLastErrors();

        /*
         * getLastErrors() dapat mengembalikan false
         * jika tidak ada error.
         */
        if ($parsed === false) {
            return false;
        }

        if (
            is_array($errors)
            && (
                $errors['warning_count'] > 0
                || $errors['error_count'] > 0
            )
        ) {
            return false;
        }

        /*
         * Memastikan tanggal benar-benar sama
         * setelah diparse.
         *
         * Contoh:
         * 2026-02-31 -> ditolak
         */
        return $parsed->format('Y-m-d') === $date;
    };

    /*
     * =================================================
     * CEK TANGGAL MULAI
     * =================================================
     */
    if (! $isValidDate($tanggalMulai)) {

        return redirect()
            ->to(site_url('admin/laporan'))
            ->with(
                'error',
                'Tanggal mulai tidak valid. Gunakan format YYYY-MM-DD.'
            );
    }

    /*
     * =================================================
     * CEK TANGGAL AKHIR
     * =================================================
     */
    if (! $isValidDate($tanggalAkhir)) {

        return redirect()
            ->to(site_url('admin/laporan'))
            ->with(
                'error',
                'Tanggal akhir tidak valid. Gunakan format YYYY-MM-DD.'
            );
    }

    /*
     * =================================================
     * CEK RENTANG TANGGAL
     * =================================================
     */
    if ($tanggalMulai > $tanggalAkhir) {

        return redirect()
            ->to(site_url('admin/laporan'))
            ->with(
                'error',
                'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.'
            );
    }

        /*
         * =================================================
         * TOTAL PERMOHONAN
         * =================================================
         */

        $data['total'] =
            (new PermohonanModel())
                ->where(
                    'tanggal_pengajuan >=',
                    $tanggalMulai . ' 00:00:00'
                )
                ->where(
                    'tanggal_pengajuan <=',
                    $tanggalAkhir . ' 23:59:59'
                )
                ->countAllResults();

/*
 * =================================================
 * STATUS MENUNGGU VERIFIKASI PENGAMBILAN
 * =================================================
 */

$pendingPickupStatus = db_connect()
    ->table('status')
    ->where(
        'nama_status',
        'MENUNGGU VERIFIKASI PENGAMBILAN'
    )
    ->get()
    ->getRowArray();

$pendingPickupStatusId = $pendingPickupStatus
    ? (int) $pendingPickupStatus['id_status']
    : 0;


/*
 * =================================================
 * DISTRIBUSI STATUS
 * =================================================
 */

$data['status'] = [

    'diajukan' =>
        (new PermohonanModel())
            ->where(
                'id_status',
                1
            )
            ->where(
                'tanggal_pengajuan >=',
                $tanggalMulai . ' 00:00:00'
            )
            ->where(
                'tanggal_pengajuan <=',
                $tanggalAkhir . ' 23:59:59'
            )
            ->countAllResults(),

    'diproses' =>
        (new PermohonanModel())
            ->where(
                'id_status',
                2
            )
            ->where(
                'tanggal_pengajuan >=',
                $tanggalMulai . ' 00:00:00'
            )
            ->where(
                'tanggal_pengajuan <=',
                $tanggalAkhir . ' 23:59:59'
            )
            ->countAllResults(),

    'ditolak' =>
        (new PermohonanModel())
            ->where(
                'id_status',
                3
            )
            ->where(
                'tanggal_pengajuan >=',
                $tanggalMulai . ' 00:00:00'
            )
            ->where(
                'tanggal_pengajuan <=',
                $tanggalAkhir . ' 23:59:59'
            )
            ->countAllResults(),

    'selesai' =>
        (new PermohonanModel())
            ->where(
                'id_status',
                4
            )
            ->where(
                'tanggal_pengajuan >=',
                $tanggalMulai . ' 00:00:00'
            )
            ->where(
                'tanggal_pengajuan <=',
                $tanggalAkhir . ' 23:59:59'
            )
            ->countAllResults(),

    'diambil' =>
        (new PermohonanModel())
            ->where(
                'id_status',
                5
            )
            ->where(
                'tanggal_pengajuan >=',
                $tanggalMulai . ' 00:00:00'
            )
            ->where(
                'tanggal_pengajuan <=',
                $tanggalAkhir . ' 23:59:59'
            )
            ->countAllResults(),

    'menunggu_pengambilan' =>
        $pendingPickupStatusId > 0
            ? (new PermohonanModel())
                ->where(
                    'id_status',
                    $pendingPickupStatusId
                )
                ->where(
                    'tanggal_pengajuan >=',
                    $tanggalMulai . ' 00:00:00'
                )
                ->where(
                    'tanggal_pengajuan <=',
                    $tanggalAkhir . ' 23:59:59'
                )
                ->countAllResults()
            : 0,
];


        /*
         * =================================================
         * VOLUME PER TUJUAN
         * =================================================
         *
         * groupBy() CI4 menerima SATU parameter string.
         * Jadi beberapa kolom dipisahkan dengan koma.
         */

        $data['tujuan'] =
            $permohonan
                ->select(
                    'tujuan.nama_tujuan,
                     COUNT(permohonan.id_permohonan) AS total'
                )
                ->join(
                    'tujuan',
                    'tujuan.id_tujuan = permohonan.id_tujuan'
                )
                ->where(
                    'permohonan.tanggal_pengajuan >=',
                    $tanggalMulai . ' 00:00:00'
                )
                ->where(
                    'permohonan.tanggal_pengajuan <=',
                    $tanggalAkhir . ' 23:59:59'
                )
                ->groupBy(
                    'permohonan.id_tujuan, tujuan.nama_tujuan'
                )
                ->orderBy(
                    'total',
                    'DESC'
                )
                ->findAll();


        /*
         * =================================================
         * TREN PERMINGGU
         * =================================================
         */

        $data['tren'] = [];

        $mulai =
            new \DateTime(
                $tanggalMulai
            );

        $akhir =
            new \DateTime(
                $tanggalAkhir
            );

        $mulai->setTime(
            0,
            0,
            0
        );

        $akhir->setTime(
            0,
            0,
            0
        );

        $mingguKe = 1;

        $cursor =
            clone $mulai;


        while ($cursor <= $akhir) {

            $weekStart =
                clone $cursor;

            $weekEnd =
                clone $cursor;

            $weekEnd->modify(
                '+6 days'
            );


            if ($weekEnd > $akhir) {

                $weekEnd =
                    clone $akhir;
            }


            $jumlah =
                (new PermohonanModel())
                    ->where(
                        'tanggal_pengajuan >=',
                        $weekStart
                            ->format('Y-m-d')
                        . ' 00:00:00'
                    )
                    ->where(
                        'tanggal_pengajuan <=',
                        $weekEnd
                            ->format('Y-m-d')
                        . ' 23:59:59'
                    )
                    ->countAllResults();


            $data['tren'][] = [
                'label' =>
                    'W' . $mingguKe,

                'total' =>
                    $jumlah,
            ];


            $mingguKe++;

            $cursor =
                clone $weekEnd;

            $cursor->modify(
                '+1 day'
            );
        }


       /*
 * =================================================
 * LAPORAN BULANAN
 * =================================================
 *
 * Rekap jumlah permohonan per bulan
 * berdasarkan status terakhir permohonan.
 *
 * Status:
 * 1 = Diajukan
 * 2 = Diproses
 * 3 = Ditolak
 * 4 = Selesai
 * 5 = Diambil
 * pendingPickupStatusId = Menunggu Verifikasi Pengambilan
 * =================================================
 */

$data['bulanan'] =

    (new PermohonanModel())
        ->select(
            "
            DATE_FORMAT(
                tanggal_pengajuan,
                '%Y-%m'
            ) AS periode,

            DATE_FORMAT(
                tanggal_pengajuan,
                '%M %Y'
            ) AS bulan,

            COUNT(
                id_permohonan
            ) AS total,

            SUM(
                CASE
                    WHEN id_status = 1
                    THEN 1
                    ELSE 0
                END
            ) AS diajukan,

            SUM(
                CASE
                    WHEN id_status = 2
                    THEN 1
                    ELSE 0
                END
            ) AS diproses,

            SUM(
                CASE
                    WHEN id_status = 3
                    THEN 1
                    ELSE 0
                END
            ) AS ditolak,

            SUM(
                CASE
                    WHEN id_status = 4
                    THEN 1
                    ELSE 0
                END
            ) AS selesai,

            SUM(
                CASE
                    WHEN id_status = 5
                    THEN 1
                    ELSE 0
                END
            ) AS diambil,

            SUM(
                CASE
                    WHEN id_status = {$pendingPickupStatusId}
                    THEN 1
                    ELSE 0
                END
            ) AS menunggu_pengambilan
            ",
            false
        )
        ->where(
            'tanggal_pengajuan >=',
            $tanggalMulai . ' 00:00:00'
        )
        ->where(
            'tanggal_pengajuan <=',
            $tanggalAkhir . ' 23:59:59'
        )
        ->groupBy(
            'periode, bulan'
        )
        ->orderBy(
            'periode',
            'DESC'
        )
        ->findAll();
        /*
         * =================================================
         * DATA UNTUK VIEW
         * =================================================
         */

        $data['tanggalMulai'] =
            $tanggalMulai;

        $data['tanggalAkhir'] =
            $tanggalAkhir;


        return view(
            'admin/laporan',
            $data
        );
    }
}