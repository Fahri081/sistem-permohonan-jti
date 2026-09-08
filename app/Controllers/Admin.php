<?php

namespace App\Controllers;

use App\Models\BerkasPermohonanModel;
use App\Models\PermohonanModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    /**
     * ==========================================
     * DASHBOARD ADMIN
     * ==========================================
     */
    public function index()
    {
        $permohonan = new PermohonanModel();

        /*
         * ------------------------------------------
         * DATA PERMOHONAN TERBARU
         * ------------------------------------------
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
         * ------------------------------------------
         * STATISTIK DASHBOARD
         *
         * 1 = DIAJUKAN
         * 2 = DIPROSES
         * 3 = DITOLAK
         * 4 = SELESAI
         * 5 = DIAMBIL
         * ------------------------------------------
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
         * ------------------------------------------
         * 5 AKTIVITAS TERBARU
         * ------------------------------------------
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
     * ==========================================
     * SEMUA PERMOHONAN
     * ==========================================
     */
    public function all()
    {
        $permohonan = new PermohonanModel();

        /*
         * Ambil keyword pencarian
         */
        $keyword = trim(
            (string) $this->request->getGet('keyword')
        );

        /*
         * Ambil filter status
         */
        $status = $this->request->getGet('status');


        /*
         * Query dasar
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
         * ------------------------------------------
         * SEARCH
         * ------------------------------------------
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
         * ------------------------------------------
         * FILTER STATUS
         *
         * 1 = DIAJUKAN
         * 2 = DIPROSES
         * 3 = DITOLAK
         * 4 = SELESAI
         * 5 = DIAMBIL
         * ------------------------------------------
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
         * ------------------------------------------
         * DATA HASIL
         * ------------------------------------------
         */
        $data['permohonan'] = $builder
            ->orderBy(
                'permohonan.id_permohonan',
                'DESC'
            )
            ->findAll();


        /*
         * Kirim kembali filter ke View
         */
        $data['keyword'] = $keyword;

        $data['statusFilter'] = $status;


        return view(
            'admin/permohonan',
            $data
        );
    }


    /**
     * ==========================================
     * DETAIL PERMOHONAN
     * ==========================================
     */
    public function show(int $id)
    {
        $permohonan = new PermohonanModel();

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
         * Permohonan tidak ditemukan
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
         * milik permohonan
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
     * ==========================================
     * UPDATE STATUS PERMOHONAN
     * ==========================================
     */
    public function updateStatus(int $id)
    {
        $statusName =
            strtoupper(
                trim(
                    (string) $this->request
                        ->getPost('status')
                )
            );


        /*
         * Mapping sesuai database
         *
         * 1 = DIAJUKAN
         * 2 = DIPROSES
         * 3 = DITOLAK
         * 4 = SELESAI
         * 5 = DIAMBIL
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
         * Validasi status
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
         * Data yang akan diupdate
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
         * Jika sudah diambil
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
     * ==========================================
     * UPDATE STATUS BERKAS
     * ==========================================
     */
    public function updateBerkasStatus(int $id)
    {
        $done =
            (int) $this->request
                ->getPost('selesai') === 1;


        /*
         * Update status berkas
         */
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
     * ==========================================
     * TANDAI SUDAH DIAMBIL
     * ==========================================
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
}