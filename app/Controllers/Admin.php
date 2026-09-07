<?php

namespace App\Controllers;

use App\Models\BerkasPermohonanModel;
use App\Models\PermohonanModel;
use App\Models\StatusModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    public function index()
    {
        $permohonan = new PermohonanModel();
        $data['permohonan'] = $permohonan
            ->select('permohonan.*, users.nama_lengkap, users.nim, tujuan.nama_tujuan, status.nama_status')
            ->join('users', 'users.id_user = permohonan.id_user')
            ->join('tujuan', 'tujuan.id_tujuan = permohonan.id_tujuan')
            ->join('status', 'status.id_status = permohonan.id_status')
            ->orderBy('permohonan.id_permohonan', 'DESC')
            ->findAll();

        return view('admin/dashboard', $data);
    }

    public function show(int $id)
    {
        $permohonan = new PermohonanModel();
        $row = $permohonan
            ->select('permohonan.*, users.nama_lengkap, users.nim, users.email, users.no_hp, tujuan.nama_tujuan, status.nama_status')
            ->join('users', 'users.id_user = permohonan.id_user')
            ->join('tujuan', 'tujuan.id_tujuan = permohonan.id_tujuan')
            ->join('status', 'status.id_status = permohonan.id_status')
            ->find($id);

        if (! $row) {
            return redirect()->to('/admin')->with('error', 'Permohonan tidak ditemukan.');
        }

        $berkas = (new BerkasPermohonanModel())->where('id_permohonan', $id)->findAll();
        return view('admin/show', ['permohonan' => $row, 'berkas' => $berkas]);
    }

    public function updateStatus(int $id)
    {
        $statusName = $this->request->getPost('status');
        $map = ['DIAJUKAN' => 1, 'DITOLAK' => 2, 'DIPROSES' => 3, 'SELESAI' => 4, 'DIAMBIL' => 5];
        $statusId = $map[$statusName] ?? null;

        if (! $statusId) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $data = ['id_status' => $statusId];
        if ($statusName === 'SELESAI') $data['tanggal_selesai'] = date('Y-m-d H:i:s');
        if ($statusName === 'DIAMBIL') $data['tanggal_diambil'] = date('Y-m-d H:i:s');
        if ($statusName === 'DITOLAK') $data['keterangan_penolakan'] = $this->request->getPost('keterangan_penolakan');

        (new PermohonanModel())->update($id, $data);
        return redirect()->back()->with('success', 'Status permohonan diperbarui.');
    }

    public function updateBerkasStatus(int $id)
    {
        $done = (int) $this->request->getPost('selesai') === 1;
        (new BerkasPermohonanModel())->update($id, [
            'selesai' => $done,
            'tanggal_selesai' => $done ? date('Y-m-d H:i:s') : null,
        ]);

        return redirect()->back()->with('success', 'Status berkas diperbarui.');
    }

    public function markPickedUp(int $id)
    {
        (new PermohonanModel())->update($id, [
            'id_status' => 5,
            'tanggal_diambil' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Permohonan ditandai sudah diambil.');
    }
}
