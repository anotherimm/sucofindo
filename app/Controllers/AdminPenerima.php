<?php

namespace App\Controllers;

use App\Models\TambahPenerimaModel;
use CodeIgniter\Controller;

class AdminPenerima extends Controller
{
    public function index()
    {
        $model = new TambahPenerimaModel();
        $data['penerima'] = $model->findAll();

        return view('adminPenerima', $data);
    }

    public function deleteDocument()
    {
        $id = $this->request->getPost('id');
        $modelTambahPenerima = new TambahPenerimaModel();

        $db = \Config\Database::connect();
        $db->transStart();



        // Hapus data dari tabel utama
        $modelTambahPenerima->delete($id);

        $db->transComplete();

        if ($db->transStatus() === false) {
            log_message('error', 'Gagal menghapus dokumen dengan ID ' . $id);
            return $this->response->setStatusCode(500, 'Failed to delete document');
        } else {
            log_message('debug', 'Dokumen dengan ID ' . $id . ' berhasil dihapus.');
            return $this->response->setJSON(['success' => true]);
        }
    }
    public function updateNamapenerima()
    {
        $model = new TambahPenerimaModel();

        $id = $this->request->getPost('id');
        $nama_penerima = $this->request->getPost('namaPenerima');

        $result = $model->updateNamapenerima($id, $nama_penerima);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui data']);
        }
    }
}
