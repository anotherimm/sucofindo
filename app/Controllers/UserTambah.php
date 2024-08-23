<?php

namespace App\Controllers;

use App\Models\TambahDataModel;
use App\Models\BidangModel;
use CodeIgniter\Controller;

class UserTambah extends Controller
{
    public function index()
    {
        $model = new BidangModel();
        $data['bidangs'] = $model->findAll();

        session()->remove('formData');

        return view('userTambah', $data);
    }

    public function tambahData()
    {
        $model = new TambahDataModel();
        $bidangModel = new BidangModel();

        $namaDokumen = $this->request->getPost('nama_dokumen');
        $jenisDokumen = $this->request->getPost('jenis_dokumen');
        $namaBidang = $this->request->getPost('nama_bidang');
        $tanggal = $this->request->getPost('tanggal');
        $kabidId = $this->request->getPost('KABID'); // Ambil ID KABID
        $jumlah = $this->request->getPost('jumlah'); // Ambil jumlah
        $hargaSatuan = $this->request->getPost('harga_satuan'); // Ambil harga satuan

        // Menghapus format Rupiah sebelum menyimpan
        $hargaSatuan = str_replace(['Rp ', '.'], '', $hargaSatuan);

        // Hitung total harga
        $totalHarga = $jumlah * $hargaSatuan;

        $userId = session()->get('id');

        // Ambil nama_kepala berdasarkan ID KABID
        $bidangData = $bidangModel->find($kabidId);
        $nama_kepala = $bidangData['nama_kepala'] ?? '';

        $data = [
            'nama_dokumen' => $namaDokumen,
            'jenis_dokumen' => $jenisDokumen,
            'nama_bidang' => $namaBidang,
            'KABID' => $nama_kepala,
            'tanggal' => $tanggal,
            'user_id' => $userId,
            'jumlah' => $jumlah,
            'harga_satuan' => $hargaSatuan,
            'total_harga' => $totalHarga
        ];

        $model->insert($data);

        session()->setFlashdata('message', 'Data berhasil disimpan.');

        return redirect()->to('/userDashboard');
    }
}
