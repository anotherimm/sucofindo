<?php

namespace App\Controllers;

use App\Models\TambahSuratpesananModel;

class AdminSuratpesanan extends BaseController
{
  // Method to show the main page
  public function index()
  {
    $model = new TambahSuratpesananModel();
    $tambahdata_id = $this->request->getGet('tambahdata_id');

    if ($tambahdata_id) {
      $form_data = $model->where('tambahdata_id', $tambahdata_id)->first();
      $data['form_data'] = $form_data ?? [
        'id' => '', // Default 'id' jika tidak ada
        'nomor_pesanan' => '',
        'tanggal_pesanan' => '',
        'harga_pesanan' => '',
        'nama_vendor' => '',
        'tambahdata_id' => $tambahdata_id
      ];

      if (isset($data['form_data']['harga_pesanan']) && is_numeric($data['form_data']['harga_pesanan'])) {
        $hargaPesanan = (float)$data['form_data']['harga_pesanan'];
        $data['form_data']['harga_pesanan'] = 'Rp. ' . number_format($hargaPesanan, 0, ',', '.');
      } else {
        // Jika harga_umk kosong atau bukan angka, set ke default format tanpa angka
        $data['form_data']['harga_pesanan'] = 'Rp.';
      }

      $data['is_locked'] = $form_data ? true : false;
    } else {
      $data['form_data'] = [
        'id' => '', // Default 'id'
        'nomor_pesanan' => '',
        'tanggal_pesanan' => '',
        'harga_pesanan' => '',
        'nama_vendor' => '',
        'tambahdata_id' => ''
      ];
      $data['is_locked'] = false;
    }

    return view('adminSuratpesanan', $data);
  }

  // Method to process and display Surat Pesanan data
  public function prosesSuratpesanan()
  {
    $tambahdataId = $this->request->getGet('tambahdata_id');
    $model = new TambahSuratpesananModel();

    if ($tambahdataId) {
      $form_data = $model->where('tambahdata_id', $tambahdataId)->first();
      $data['form_data'] = $form_data ?? [
        'tambahdata_id' => $tambahdataId,
        'nomor_pesanan' => '',
        'tanggal_pesanan' => '',
        'harga_pesanan' => 0.00,
        'nama_vendor' => ''
      ];

      if (isset($data['form_data']['harga_pesanan']) && is_numeric($data['form_data']['harga_pesanan'])) {
        $hargaPesanan = (float)$data['form_data']['harga_pesanan'];
        $data['form_data']['harga_pesanan'] = 'Rp. ' . number_format($hargaPesanan, 0, ',', '.');
      } else {
        // Jika harga_umk kosong atau bukan angka, set ke default format tanpa angka
        $data['form_data']['harga_pesanan'] = 'Rp.';
      }

      // Set status form
      $data['is_locked'] = $form_data ? true : false;
    } else {
      $data['form_data'] = [
        'tambahdata_id' => $tambahdataId,
        'nomor_pesanan' => '',
        'tanggal_pesanan' => '',
        'harga_pesanan' => 0.00,
        'nama_vendor' => ''
      ];
      $data['is_locked'] = false;
    }

    return view('adminSuratpesanan', $data);
  }

  // Method to save Surat Pesanan data
  public function saveSuratpesanan()
  {
    $model = new TambahSuratpesananModel();

    $tambahdataId = $this->request->getPost('tambahdata_id');
    $nomorPesanan = $this->request->getPost('nomor_pesanan');
    $tanggalPesanan = $this->request->getPost('tanggal_pesanan');
    $hargaPesanan = $this->request->getPost('harga_pesanan');
    $namaVendor = $this->request->getPost('nama_vendor');
    $status = $this->request->getPost('status');

    // Debugging: Cek apakah 'tambahdata_id' ada
    if (empty($tambahdataId)) {
      session()->setFlashdata('error', 'ID data tidak boleh kosong.');
      return redirect()->back()->withInput();
    }

    // Convert hargaPesanan dari format Rupiah ke format numerik
    $hargaPesanan = str_replace(['Rp. ', '.'], '', $hargaPesanan);
    $hargaPesanan = str_replace(',', '.', $hargaPesanan); // Jika ada koma dalam input, ganti dengan titik

    $data = [
      'tambahdata_id' => $tambahdataId,
      'nomor_pesanan' => $nomorPesanan,
      'tanggal_pesanan' => $tanggalPesanan,
      'harga_pesanan' => $hargaPesanan,
      'nama_vendor' => $namaVendor,
      'status' => $status
    ];



    try {
      $existingData = $model->where('tambahdata_id', $tambahdataId)->first();
      if ($existingData) {
        $model->update($existingData['id'], $data);
      } else {
        $model->insert($data);
      }

      session()->setFlashdata('message', 'Data Surat Pesanan berhasil disimpan.');
      return redirect()->to('/adminSuratpesanan?tambahdata_id=' . $tambahdataId);
    } catch (\Exception $e) {
      session()->setFlashdata('error', 'Gagal menyimpan data: ' . $e->getMessage());
      return redirect()->back()->withInput();
    }
  }
  public function resetSuratpesanan()
  {
    $model = new TambahSuratpesananModel();
    $tambahdataId = $this->request->getGet('tambahdata_id');

    if ($tambahdataId) {
      $model->where('tambahdata_id', $tambahdataId)->delete();
      session()->setFlashdata('message', 'Data Surat Pesanan berhasil direset.');
    }

    return redirect()->to('/adminSuratpesanan?tambahdata_id=' . $tambahdataId);
  }
}
