<?php

namespace App\Controllers;

use App\Models\TambahPenerimaModel;
use CodeIgniter\Controller;

class AdminTambahpenerima extends Controller
{
    public function index()
    {
        // Hapus session data jika ada
        session()->remove('formData');

        $model = new TambahPenerimaModel();

        // Ambil data penerima dengan role 'Penerima Budgeting'
        $data['penerima_options'] = $model->where('role', 'Penerima Budgeting')->findAll();

        // Tampilkan form tambah penerima
        return view('adminTambahpenerima');
    }

    public function tambahData()
    {
        $model = new TambahPenerimaModel();

        // Ambil data dari POST request
        $namaPenerima = $this->request->getPost('nama_penerima');
        $role = $this->request->getPost('role');

        // Ambil user_id dari session
        $userId = session()->get('id');

        // Persiapkan data untuk disimpan
        $data = [
            'nama_penerima' => $namaPenerima,
            'role' => $role,
            'user_id' => $userId
        ];

        // Simpan data ke database
        $model->insert($data);

        // Set flashdata untuk pesan sukses
        session()->setFlashdata('message', 'Data berhasil disimpan.');

        // Redirect ke halaman adminPenerima
        return redirect()->to('/adminPenerima');
    }
}
