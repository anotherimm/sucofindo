<?php

namespace App\Controllers;

use App\Models\TambahDataModel;
use App\Models\TambahTorModel;
use App\Models\TambahBudgetModel;
use App\Models\TambahPpbjModel;
use App\Models\BidangModel;
use App\Models\TambahSuratpesananModel;
use App\Models\TambahSpphModel;
use App\Models\TambahKontrakModel;
use App\Models\TambahUmkModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $model = new TambahDataModel();
        $sortOrder = $this->request->getGet('sort_order') ?? 'desc';
        $date = $this->request->getGet('date');
        $search = $this->request->getGet('search');
        $jenisDokumen = $this->request->getGet('jenis_dokumen');
        $namaBidang = $this->request->getGet('nama_bidang');

        // Order by the timestamp column in descending order to show newest first
        $builder = $model->orderBy('created_at', $sortOrder);

        if ($date) {
            $builder->where('tanggal', $date);
        }

        if ($search) {
            $builder->like('nama_dokumen', $search)
                ->orLike('jenis_dokumen', $search)
                ->orLike('nama_bidang', $search);
        }

        if ($jenisDokumen) {
            $builder->where('jenis_dokumen', $jenisDokumen);
        }

        if ($namaBidang) {
            $builder->where('nama_bidang', $namaBidang);
        }

        $data['documents'] = $builder->findAll();
        return view('adminDashboard', $data);
    }


    public function updateStatus()
    {
        $model = new TambahDataModel();
        $id = $this->request->getPost('id');
        $statusTor = $this->request->getPost('status_tor');
        $statusBudgeting = $this->request->getPost('status_budgeting');
        $statusPpbj = $this->request->getPost('status_ppbj');
        $statusUmk = $this->request->getPost('status_umk');
        $statusPesanan = $this->request->getPost('status_pesanan');
        $statusSpph = $this->request->getPost('status_spph');
        $statusKontrak = $this->request->getPost('status_kontrak');
        $statusSelesai = $this->request->getPost('status_selesai');


        // Tentukan status_pesan berdasarkan prioritas status yang diisi
        $statusPesan = 'pending'; // default value
        if ($statusUmk == 'diterima') {
            $statusPesan = 'diterima';
        } elseif ($statusPesanan == 'diterima') {
            $statusPesan = 'diterima';
        } elseif ($statusSpph == 'diterima') {
            $statusPesan = 'diterima';
        } elseif ($statusKontrak == 'diterima') {
            $statusPesan = 'diterima';
        } elseif ($statusUmk == 'syarat_tidak_terpenuhi' || $statusPesanan == 'syarat_tidak_terpenuhi' || $statusSpph == 'syarat_tidak_terpenuhi' || $statusKontrak == 'syarat_tidak_terpenuhi') {
            $statusPesan = 'syarat_tidak_terpenuhi';
        }

        $model->update($id, [
            'status_tor' => $statusTor,
            'status_budgeting' => $statusBudgeting,
            'status_ppbj' => $statusPpbj,
            'status_umk' => $statusUmk,
            'status_pesan' => $statusPesanan,
            'status_spph' => $statusSpph,
            'status_kontrak' => $statusKontrak,
            'status_selesai' => $statusSelesai,
            'status_pesan' => $statusPesan,
        ]);


        return redirect()->to('/admin/dashboard');
    }


    public function getDocument($id)
    {
        $model = new TambahDataModel();
        $document = $model->find($id);

        if ($document) {
            return $this->response->setJSON($document);
        } else {
            return $this->response->setStatusCode(404, 'Document not found');
        }
    }


    public function getDocumentDetails()
    {
        $id = $this->request->getVar('id');
        $dataModel = new TambahDataModel();
        $torModel = new TambahTorModel();
        $budgetModel = new TambahBudgetModel();
        $ppbjModel = new TambahPpbjModel();
        $bidangModel = new BidangModel();
        $suratpesananModel = new TambahSuratpesananModel();
        $umkModel = new TambahUmkModel();
        $spphModel = new TambahSpphModel();
        $kontrakModel = new TambahKontrakModel();

        // Ambil data dokumen berdasarkan ID
        $document = $dataModel->find($id);

        // Ambil data TOR, Budgeting, dan PPBJ yang terkait
        $torDetails = $torModel->where('tambahdata_id', $id)->first();
        $budgetDetails = $budgetModel->where('tambahdata_id', $id)->first();
        $ppbjDetails = $ppbjModel->where('tambahdata_id', $id)->first();
        $suratpesananDetails = $suratpesananModel->where('tambahdata_id', $id)->first();
        $umkDetails = $umkModel->where('tambahdata_id', $id)->first();
        $spphDetails = $spphModel->where('tambahdata_id', $id)->first();
        $kontrakDetails = $kontrakModel->where('tambahdata_id', $id)->first();

        // Ambil nama_kepala dari kepala_bidang berdasarkan ID KABID
        $kabidId = $document['KABID'];
        $bidangData = $bidangModel->find($kabidId);
        $namaKepala = $bidangData['nama_kepala'] ?? '';

        // Fungsi untuk format Rupiah
        function formatRupiah($angka)
        {
            return 'Rp ' . number_format($angka, 0, ',', '.');
        }

        if ($document) {
            // Format harga satuan, total harga, dan nilai-nilai lainnya
            $document['harga_satuan'] = formatRupiah($document['harga_satuan']);
            $document['total_harga'] = formatRupiah($document['total_harga']);

            // Format nilai-nilai tambahan
            $ppbjDetails['nilai_ppbj'] = formatRupiah($ppbjDetails['nilai_ppbj'] ?? 0);
            $suratpesananDetails['harga_pesanan'] = formatRupiah($suratpesananDetails['harga_pesanan'] ?? 0);
            $umkDetails['harga_umk'] = formatRupiah($umkDetails['harga_umk'] ?? 0);
            $kontrakDetails['harga_kontrak'] = formatRupiah($kontrakDetails['harga_kontrak'] ?? 0);

            // Gabungkan data dokumen dengan data lainnya
            $data = array_merge($document, $torDetails ?? [], $budgetDetails ?? [], $ppbjDetails ?? [], $suratpesananDetails ?? [], $umkDetails ?? [], $spphDetails ?? [], $kontrakDetails ?? [], ['nama_kepala' => $namaKepala]);

            // Kembalikan data dalam format JSON
            return $this->response->setJSON($data);
        } else {
            // Kembalikan response error jika data tidak ditemukan
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Document not found']);
        }
    }


    public function deleteDocument()
    {
        $id = $this->request->getPost('id');
        $modelTambahData = new TambahDataModel();
        $modelTambahBudget = new \App\Models\TambahBudgetModel(); // Pastikan Anda mengimpor model yang benar
        $modelTambahTor = new \App\Models\TambahTorModel();
        $modelTambahPpbj = new \App\Models\TambahPpbjModel();
        $modelTambahSuratpesanan = new \App\Models\TambahSuratpesananModel();
        $modelTambahSpph = new \App\Models\TambahSpphModel();
        $modelTambahKontrak = new \App\Models\TambahKontrakModel();
        $modelTambahUmk = new \App\Models\TambahUmkModel();

        $db = \Config\Database::connect();
        $db->transStart();

        // Hapus data terkait dari tabel lain terlebih dahulu
        $modelTambahBudget->where('tambahdata_id', $id)->delete();
        $modelTambahTor->where('tambahdata_id', $id)->delete();
        $modelTambahPpbj->where('tambahdata_id', $id)->delete();
        $modelTambahSuratpesanan->where('tambahdata_id', $id)->delete();
        $modelTambahSpph->where('tambahdata_id', $id)->delete();
        $modelTambahKontrak->where('tambahdata_id', $id)->delete();
        $modelTambahUmk->where('tambahdata_id', $id)->delete();


        // Hapus data dari tabel utama
        $modelTambahData->delete($id);

        $db->transComplete();

        if ($db->transStatus() === false) {
            log_message('error', 'Gagal menghapus dokumen dengan ID ' . $id);
            return $this->response->setStatusCode(500, 'Failed to delete document');
        } else {
            log_message('debug', 'Dokumen dengan ID ' . $id . ' berhasil dihapus.');
            return $this->response->setJSON(['success' => true]);
        }
    }
    // Method to update kepala bidang




    // public function rekapBulanan()
    // {
    //     if (session()->get('role') !== 'admin') {
    //         return redirect()->to('/auth/login');
    //     }

    //     $model = new TambahDataModel();
    //     $currentMonth = date('Y-m'); // Format YYYY-MM
    //     $data['documents'] = $model->where("DATE_FORMAT(tanggal, '%Y-%m')", $currentMonth)->findAll();

    //     return view('rekap_bulanan', $data);
    // }

    // public function rekapMingguan()
    // {
    //     if (session()->get('role') !== 'admin') {
    //         return redirect()->to('/auth/login');
    //     }

    //     $model = new TambahDataModel();
    //     $startOfWeek = date('Y-m-d', strtotime('monday this week'));
    //     $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
    //     $data['documents'] = $model->where('tanggal >=', $startOfWeek)
    //                                 ->where('tanggal <=', $endOfWeek)
    //                                 ->findAll();

    //     return view('rekap_mingguan', $data);
    // }

    // public function rekapHarian()
    // {
    //     if (session()->get('role') !== 'admin') {
    //         return redirect()->to('/auth/login');
    //     }

    //     $model = new TambahDataModel();
    //     $currentDate = date('Y-m-d'); // Format YYYY-MM-DD
    //     $data['documents'] = $model->where('tanggal', $currentDate)->findAll();

    //     return view('rekap_harian', $data);
    // }




}
