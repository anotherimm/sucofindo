<?php

namespace App\Controllers;

use App\Models\TambahKontrakModel;

class AdminKontrak extends BaseController
{
  public function index()
  {
    $model = new TambahKontrakModel();
    $tambahdata_id = $this->request->getGet('tambahdata_id');

    // Siapkan data form untuk ditampilkan
    if ($tambahdata_id) {
      $form_data = $model->where('tambahdata_id', $tambahdata_id)->first();
      $data['form_data'] = $form_data ?? [
        'id' => '', // Default 'id' jika tidak ada
        'nomor_kontrak' => '',
        'tanggal_kontrak' => '',
        'vendor_pemenang' => '',
        'harga_kontrak' => '',
        'tambahdata_id' => $tambahdata_id
      ];

      if (isset($data['form_data']['harga_kontrak']) && is_numeric($data['form_data']['harga_kontrak'])) {
        $hargaKontrak = (float)$data['form_data']['harga_kontrak'];
        $data['form_data']['harga_kontrak'] = 'Rp. ' . number_format($hargaKontrak, 0, ',', '.');
      } else {
        // Jika harga_umk kosong atau bukan angka, set ke default format tanpa angka
        $data['form_data']['harga_kontrak'] = 'Rp.';
      }

      // Set status form
      $data['is_locked'] = $form_data ? true : false;
    } else {
      $data['form_data'] = [
        'id' => '', // Default 'id'
        'nomor_kontrak' => '',
        'tanggal_kontrak' => '',
        'vendor_pemenang' => '',
        'harga_kontrak' => '',
        'tambahdata_id' => ''
      ];
      $data['is_locked'] = false;
    }

    return view('adminKontrak', $data);
  }


  public function prosesKontrak()
  {
    $tambahdataId = $this->request->getGet('tambahdata_id');
    $model = new TambahKontrakModel();

    if ($tambahdataId) {
      $form_data = $model->where('tambahdata_id', $tambahdataId)->first();
      $data['form_data'] = $form_data ?? [
        'tambahdata_id' => $tambahdataId,
        'nomor_kontrak' => '',
        'tanggal_kontrak' => '',
        'vendor_pemenang' => '',
        'harga_kontrak' => 0.00
      ];

      if (isset($data['form_data']['harga_kontrak']) && is_numeric($data['form_data']['harga_kontrak'])) {
        $hargaKontrak = (float)$data['form_data']['harga_kontrak'];
        $data['form_data']['harga_kontrak'] = 'Rp. ' . number_format($hargaKontrak, 0, ',', '.');
      } else {
        // Jika harga_umk kosong atau bukan angka, set ke default format tanpa angka
        $data['form_data']['harga_kontrak'] = 'Rp.';
      }

      // Set status form
      $data['is_locked'] = $form_data ? true : false;
    } else {
      return redirect()->to('/admin/dashboard');
    }

    return view('adminKontrak', $data);
  }

  public function saveKontrak()
  {
    $model = new TambahKontrakModel();

    $tambahdataId = $this->request->getPost('tambahdata_id');
    $nomorKontrak = $this->request->getPost('nomor_kontrak');
    $tanggalKontrak = $this->request->getPost('tanggal_kontrak');
    $vendorPemenang = $this->request->getPost('vendor_pemenang');
    $hargaKontrak = $this->request->getPost('harga_kontrak');

    if (empty($tambahdataId)) {
      session()->setFlashdata('error', 'ID data tidak boleh kosong.');
      return redirect()->back()->withInput();
    }

    // Convert hargaKontrak dari format Rupiah ke format numerik
    $hargaKontrak = str_replace(['Rp. ', '.'], '', $hargaKontrak);
    $hargaKontrak = str_replace(',', '.', $hargaKontrak); // Jika ada koma dalam input, ganti dengan titik

    $data = [
      'tambahdata_id' => $tambahdataId,
      'nomor_kontrak' => $nomorKontrak,
      'tanggal_kontrak' => $tanggalKontrak,
      'vendor_pemenang' => $vendorPemenang,
      'harga_kontrak' => $hargaKontrak
    ];

    try {
      $existingData = $model->where('tambahdata_id', $tambahdataId)->first();
      if ($existingData) {
        $model->update($existingData['id'], $data);
      } else {
        $model->insert($data);
      }

      session()->setFlashdata('message', 'Data Kontrak berhasil disimpan.');
      return redirect()->to('/adminKontrak?tambahdata_id=' . $tambahdataId);
    } catch (\Exception $e) {
      session()->setFlashdata('error', 'Gagal menyimpan data: ' . $e->getMessage());
      return redirect()->back()->withInput();
    }
  }
  public function resetKontrak()
  {
    $model = new TambahKontrakModel();
    $tambahdataId = $this->request->getGet('tambahdata_id');

    if ($tambahdataId) {
      $model->where('tambahdata_id', $tambahdataId)->delete();
      session()->setFlashdata('message', 'Data Kontrak berhasil direset.');
    }

    return redirect()->to('/adminKontrak?tambahdata_id=' . $tambahdataId);
  }
}
