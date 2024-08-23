<?php

namespace App\Controllers;

use App\Models\TambahDataModel;
use App\Models\TambahTorModel;
use App\Models\TambahBudgetModel;
use App\Models\TambahPpbjModel;
use App\Models\BidangModel;
use App\Models\TambahSuratpesananModel;
use App\Models\TambahUmkModel;
use App\Models\TambahSpphModel;
use App\Models\TambahKontrakModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    public function dashboard()
    {
        $session = session();

        // Cek jika pengguna sudah login
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // Ambil user_id dari sesi
        $userId = $session->get('id');

        // Debugging: Cek apakah user_id ditemukan
        if (!$userId) {
            echo "User ID tidak ditemukan dalam sesi!";
            exit;
        } else {
            echo "User ID: " . $userId;
        }

        $model = new TambahDataModel();
        $sortOrder = $this->request->getGet('sort_order') ?? 'desc';
        $date = $this->request->getGet('date');
        $search = $this->request->getGet('search');

        $builder = $model->orderBy('created_at', $sortOrder);

        if ($date) {
            $builder->where('tanggal', $date);
        }

        if ($search) {
            $builder->like('nama_dokumen', $search)
                ->orLike('jenis_dokumen', $search)
                ->orLike('nama_bidang', $search);
        }

        // Ambil data yang spesifik untuk pengguna yang sedang login
        $data['dokumen'] = $model->where('user_id', $userId)->findAll();

        return view('userDashboard', $data);
    }
    public function tambahData()
    {
        // Pastikan method yang digunakan adalah POST
        if ($this->request->getMethod() === 'post') {
            // Ambil data dari form
            $model = new TambahDataModel();
            $data = [
                'nama_dokumen' => $this->request->getPost('nama_dokumen'),
                'jenis_dokumen' => $this->request->getPost('jenis_dokumen'),
                'nama_bidang' => $this->request->getPost('nama_bidang'),
                'KABID' => $this->request->getPost('KABID'),
                'tanggal' => $this->request->getPost('tanggal')
            ];

            // Simpan data ke dalam database
            $model->insert($data);

            // Redirect kembali ke halaman dashboard setelah berhasil menyimpan data
            return redirect()->to('/userDashboard');
        }

        // Tampilkan view untuk menambahkan data baru
        return view('userTambah');
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
}
