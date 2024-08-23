<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TambahDataModel;


class AdminDatapengguna extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->findAll();
        $data['message'] = session()->getFlashdata('message');

        return view('adminDatapengguna', $data);
    }

    public function updatePassword()
    {
        $model = new UserModel();
        $id = $this->request->getPost('id');
        $newPassword = $this->request->getPost('newPassword');

        if (!$newPassword) {
            return $this->response->setJSON(['success' => false, 'message' => 'Password baru tidak boleh kosong.']);
        }

        try {
            $model->update($id, ['password' => $newPassword]);
            return $this->response->setJSON(['success' => true, 'message' => 'Password berhasil diperbarui.']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Terjadi kesalahan saat memperbarui password.']);
        }
    }

    public function deleteDocument()
    {
        $id = $this->request->getPost('id');
        $modelTambahData = new \App\Models\TambahDataModel();
        $modelUser = new UserModel();

        $db = \Config\Database::connect();
        $db->transStart();

        // Hapus data yang bergantung pada user_id
        $modelTambahData->where('user_id', $id)->delete();

        // Hapus data dari tabel utama
        $modelUser->delete($id);

        $db->transComplete();

        if ($db->transStatus() === false) {
            log_message('error', 'Gagal menghapus dokumen dengan ID ' . $id);
            return $this->response->setStatusCode(500, 'Failed to delete document');
        } else {
            log_message('debug', 'Dokumen dengan ID ' . $id . ' berhasil dihapus.');
            return $this->response->setJSON(['success' => true]);
        }
    }
}
