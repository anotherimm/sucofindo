<?php

namespace App\Controllers;
use App\Models\BidangModel;

class AdminDatakepala extends BaseController
{
    public function index()
    {
        $model = new BidangModel();
        $data['bidangs'] = $model->findAll(); // Mengambil semua data dari model

        return view('adminDatakepala', $data);
    }

    public function updateKepalaBidang()
    {
        $model = new BidangModel();

        $id = $this->request->getPost('id');
        $nama_kepala = $this->request->getPost('namaKepala');

        $result = $model->updateKepalaBidang($id, $nama_kepala);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui data']);
        }
    }
}
