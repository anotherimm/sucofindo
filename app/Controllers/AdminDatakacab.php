<?php

namespace App\Controllers;

use App\Models\KacabModel; // Pastikan Anda membuat model ini

class AdminDatakacab extends BaseController
{
    public function index()
    {
        // Ambil data Kacab dari model dan kirim ke view
        $model = new KacabModel();
        $data['kacabs'] = $model->findAll(); // Mengambil semua data

        return view('adminDatakacab', $data);
    }

    public function updateKacab()
    {
        $model = new KacabModel();

        $id = $this->request->getPost('id');
        $nama_kacab = $this->request->getPost('namaKacab');

        $result = $model->updateKacab($id, $nama_kacab);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui data']);
        }
    }
}
