<?php

namespace App\Controllers;

use App\Models\PermohonanModel;
use App\Models\TujuanModel;
use CodeIgniter\Controller;

class Mahasiswa extends Controller
{
    public function index()
    {
        $model = new PermohonanModel();
        $data['permohonan'] = $model
            ->select('permohonan.*, tujuan.nama_tujuan, status.nama_status')
            ->join('tujuan', 'tujuan.id_tujuan = permohonan.id_tujuan')
            ->join('status', 'status.id_status = permohonan.id_status')
            ->where('permohonan.id_user', session('id_user'))
            ->orderBy('permohonan.id_permohonan', 'DESC')
            ->findAll();

        return view('mahasiswa/dashboard', $data);
    }

    public function create()
    {
        return view('mahasiswa/create', [
            'tujuan' => (new TujuanModel())->findAll(),
        ]);
    }

    public function store()
    {
        $files = $this->request->getFileMultiple('berkas');
        $validFiles = array_values(array_filter($files ?? [], static fn ($file) => $file && $file->isValid()));

        if (! $validFiles) {
            return redirect()->back()->withInput()->with('error', 'Minimal satu berkas harus diunggah.');
        }

        $model = new PermohonanModel();
        $db = db_connect();

        $db->transStart();

        $permohonanId = $model->insert([
            'id_user' => session('id_user'),
            'id_tujuan' => (int) $this->request->getPost('id_tujuan'),
            'id_status' => 1, // DIAJUKAN
            'keperluan' => $this->request->getPost('keperluan'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'tanggal_pengajuan' => date('Y-m-d H:i:s'),
        ], true);

        foreach ($validFiles as $file) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/berkas', $newName);
            $db->table('berkas_permohonan')->insert([
                'id_permohonan' => $permohonanId,
                'nama_berkas' => $file->getClientName(),
                'bukti_foto' => $newName,
                'selesai' => 0,
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Permohonan gagal disimpan.');
        }

        return redirect()->to('/mahasiswa')->with('success', 'Permohonan berhasil diajukan.');
    }
}
