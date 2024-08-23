<?php

namespace App\Controllers;

use App\Models\TambahSpphModel;

class AdminSpph extends BaseController
{
  // Method to show the main page
  public function index()
  {
    $model = new TambahSpphModel();

    // Ambil tambahdata_id dari query string
    $tambahdata_id = $this->request->getGet('tambahdata_id');

    // Siapkan data form untuk ditampilkan
    if ($tambahdata_id) {
      $form_data = $model->where('tambahdata_id', $tambahdata_id)->first();
      $data['form_data'] = $form_data ?? [
        'id' => '', // Default 'id' jika tidak ada
        'nomor_spph' => '',
        'tanggal_spph' => '',
        'nama_vendor1' => '',
        'nama_vendor2' => '',
        'nama_vendor3' => '',
        'tambahdata_id' => $tambahdata_id
      ];

      // Set status form
      $data['is_locked'] = $form_data ? true : false;
    } else {
      $data['form_data'] = [
        'id' => '', // Default 'id'
        'nomor_spph' => '',
        'tanggal_spph' => '',
        'nama_vendor1' => '',
        'nama_vendor2' => '',
        'nama_vendor3' => '',
        'tambahdata_id' => ''
      ];
      $data['is_locked'] = false;
    }

    return view('adminSpph', $data);
  }

  // Method to process and display SPPH data
  public function prosesSpph()
  {
    $tambahdataId = $this->request->getGet('tambahdata_id');
    $model = new TambahSpphModel();

    if ($tambahdataId) {
      $form_data = $model->where('tambahdata_id', $tambahdataId)->first();
      $data['form_data'] = $form_data ?? [
        'tambahdata_id' => $tambahdataId,
        'nomor_spph' => '',
        'tanggal_spph' => '',
        'nama_vendor1' => '',
        'nama_vendor2' => '',
        'nama_vendor3' => ''
      ];

      // Set status form
      $data['is_locked'] = $form_data ? true : false;
    } else {
      $data['form_data'] = [
        'tambahdata_id' => $tambahdataId,
        'nomor_spph' => '',
        'tanggal_spph' => '',
        'nama_vendor1' => '',
        'nama_vendor2' => '',
        'nama_vendor3' => ''
      ];
      $data['is_locked'] = false;
    }

    return view('adminSpph', $data);
  }

  // Method to save SPPH data
  public function saveSpph()
  {
    $model = new TambahSpphModel();

    $tambahdataId = $this->request->getPost('tambahdata_id');
    $nomorSpph = $this->request->getPost('nomor_spph');
    $tanggalSpph = $this->request->getPost('tanggal_spph');
    $namaVendor1 = $this->request->getPost('nama_vendor1');
    $namaVendor2 = $this->request->getPost('nama_vendor2');
    $namaVendor3 = $this->request->getPost('nama_vendor3');

    $data = [
      'tambahdata_id' => $tambahdataId,
      'nomor_spph' => $nomorSpph,
      'tanggal_spph' => $tanggalSpph,
      'nama_vendor1' => $namaVendor1,
      'nama_vendor2' => $namaVendor2,
      'nama_vendor3' => $namaVendor3
    ];

    // Debugging: Cek apakah 'tambahdata_id' ada
    if (empty($tambahdataId)) {
      session()->setFlashdata('error', 'ID data tidak boleh kosong.');
      return redirect()->back()->withInput();
    }

    try {
      $existingData = $model->where('tambahdata_id', $tambahdataId)->first();
      if ($existingData) {
        $model->update($existingData['id'], $data);
      } else {
        $model->insert($data);
      }

      session()->setFlashdata('message', 'Data SPPH berhasil disimpan.');
      return redirect()->to('/adminSpph?tambahdata_id=' . $tambahdataId);
    } catch (\Exception $e) {
      session()->setFlashdata('error', 'Gagal menyimpan data: ' . $e->getMessage());
      return redirect()->back()->withInput();
    }
  }
  public function resetSpph()
  {
    $model = new TambahSpphModel();
    $tambahdataId = $this->request->getGet('tambahdata_id');

    if ($tambahdataId) {
      $model->where('tambahdata_id', $tambahdataId)->delete();
      session()->setFlashdata('message', 'Data SPPH berhasil direset.');
    }

    return redirect()->to('/adminSpph?tambahdata_id=' . $tambahdataId);
  }
}
