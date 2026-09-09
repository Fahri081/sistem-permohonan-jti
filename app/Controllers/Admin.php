<?php

namespace App\Controllers;

use App\Models\BerkasPermohonanModel;
use App\Models\PermohonanModel;
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
         * Data permohonan terbaru
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
         * Statistik
         *
         * 1 = Diajukan
         * 2 = Diproses
         * 3 = Ditolak
         * 4 = Selesai
         * 5 = Diambil
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
        ];

        /*
         * Lima aktivitas terbaru
         */
        $data['aktivitas'] = array_slice(
            $data['permohonan'],
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
        $permohonan = new PermohonanModel();

        /*
         * Keyword pencarian
         */
        $keyword = trim(
            (string) $this->request->getGet('keyword')
        );

        /*
         * Filter status
         */
        $status = $this->request->getGet('status');

        /*
         * Query utama
         */
        $builder = $permohonan
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
         * Search
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
                ->groupEnd();
        }

        /*
         * Filter status
         */
        if (
            $status !== null &&
            $status !== '' &&
            in_array(
                $status,
                ['1', '2', '3', '4', '5'],
                true
            )
        ) {
            $builder->where(
                'permohonan.id_status',
                (int) $status
            );
        }

        /*
         * Ambil data
         */
        $data['permohonan'] = $builder
            ->orderBy(
                'permohonan.id_permohonan',
                'DESC'
            )
            ->findAll();

        /*
         * Kirim filter ke view
         */
        $data['keyword'] = $keyword;
        $data['statusFilter'] = $status;

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

        return view(
            'admin/show',
            [
                'permohonan' => $row,
                'berkas' => $berkas,
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
        $statusName = strtoupper(
            trim(
                (string) $this->request
                    ->getPost('status')
            )
        );

        /*
         * Mapping sesuai database
         *
         * 1 = Diajukan
         * 2 = Diproses
         * 3 = Ditolak
         * 4 = Selesai
         * 5 = Diambil
         */
        $map = [
            'DIAJUKAN' => 1,
            'DIPROSES' => 2,
            'DITOLAK'  => 3,
            'SELESAI'  => 4,
            'DIAMBIL'  => 5,
        ];

        $statusId =
            $map[$statusName] ?? null;

        /*
         * Validasi
         */
        if (! $statusId) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Status tidak valid.'
                );
        }

        /*
         * Data update
         */
        $data = [
            'id_status' => $statusId,
        ];

        /*
         * Jika selesai
         */
        if ($statusName === 'SELESAI') {
            $data['tanggal_selesai'] =
                date('Y-m-d H:i:s');
        }

        /*
         * Jika diambil
         */
        if ($statusName === 'DIAMBIL') {
            $data['tanggal_diambil'] =
                date('Y-m-d H:i:s');
        }

        /*
         * Jika ditolak
         */
        if ($statusName === 'DITOLAK') {
            $data['keterangan_penolakan'] =
                $this->request
                    ->getPost(
                        'keterangan_penolakan'
                    );
        }

        /*
         * Update database
         */
        (new PermohonanModel())
            ->update(
                $id,
                $data
            );

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
    public function updateBerkasStatus(int $id)
    {
        $done =
            (int) $this->request
                ->getPost('selesai') === 1;

        (new BerkasPermohonanModel())
            ->update(
                $id,
                [
                    'selesai' => $done,

                    'tanggal_selesai' =>
                        $done
                            ? date('Y-m-d H:i:s')
                            : null,
                ]
            );

        return redirect()
            ->back()
            ->with(
                'success',
                'Status berkas berhasil diperbarui.'
            );
    }


    /**
     * =====================================================
     * TANDAI SUDAH DIAMBIL
     * =====================================================
     */
    public function markPickedUp(int $id)
    {
        (new PermohonanModel())
            ->update(
                $id,
                [
                    'id_status' => 5,

                    'tanggal_diambil' =>
                        date('Y-m-d H:i:s'),
                ]
            );

        return redirect()
            ->back()
            ->with(
                'success',
                'Permohonan ditandai sudah diambil.'
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

        $tanggalMulai =
            $this->request->getGet('mulai')
            ?: date('Y-m-01');

        $tanggalAkhir =
            $this->request->getGet('akhir')
            ?: date('Y-m-t');


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
         */

        $data['bulanan'] =
            $permohonan
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
                    ) AS total
                    "
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