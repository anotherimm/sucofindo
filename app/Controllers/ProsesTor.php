<?php

namespace App\Controllers;

use App\Models\TambahTorModel;
use App\Models\TambahPenerimaModel;
use CodeIgniter\Controller;

class ProsesTor extends Controller
{
  public function index()
  {
    $model = new TambahTorModel();
    $penerimaModel = new TambahPenerimaModel();

    $data['penerima_options'] = $penerimaModel->getPenerimaByRole('Penerima TOR');

    $tambahdata_id = $this->request->getGet('tambahdata_id');

    if ($tambahdata_id) {
      $form_data = $model->where('tambahdata_id', $tambahdata_id)->first();
      $data['form_data'] = $form_data ?? [
        'id' => '',
        'tanggal_dikirim' => '',
        'tanggal_diterima' => '',
        'penerima_dokumen' => '',
        'tambahdata_id' => $tambahdata_id
      ];

      $data['is_locked'] = $form_data ? true : false;
    } else {
      $data['form_data'] = [
        'id' => '',
        'tanggal_dikirim' => '',
        'tanggal_diterima' => '',
        'penerima_dokumen' => '',
        'tambahdata_id' => ''
      ];
      $data['is_locked'] = false;
    }

    return view('prosesTor', $data);
  }

  public function saveTor()
  {
    $model = new TambahTorModel();
    $penerimaModel = new TambahPenerimaModel();

    $tambahdataId = $this->request->getPost('tambahdata_id');
    $tanggalDikirim = $this->request->getPost('tanggalDikirim');
    $tanggalDiterima = $this->request->getPost('tanggalDiterima');
    $penerimaId = $this->request->getPost('penerimaDokumenTor');

    if (empty($penerimaId)) {
      session()->setFlashdata('error', 'Penerima Dokumen tidak boleh kosong.');
      return redirect()->back()->withInput();
    }

    $penerima = $penerimaModel->find($penerimaId);
    $penerimaNama = $penerima['nama_penerima'] ?? '';

    $data = [
      'tambahdata_id' => $tambahdataId,
      'tanggal_dikirim' => $tanggalDikirim,
      'tanggal_diterima' => $tanggalDiterima,
      'penerima_dokumen' => $penerimaNama
    ];

    try {
      $existingData = $model->where('tambahdata_id', $tambahdataId)->first();
      if ($existingData) {
        $model->update($existingData['id'], $data);
      } else {
        $model->insert($data);
      }

      session()->setFlashdata('message', 'Data TOR berhasil disimpan.');
      return redirect()->to('/prosesTor?tambahdata_id=' . $tambahdataId);
    } catch (\Exception $e) {
      log_message('error', 'Error saving TOR: ' . $e->getMessage());
      session()->setFlashdata('error', 'Gagal menyimpan data: ' . $e->getMessage());
      return redirect()->back()->withInput();
    }
  }

  public function resetTor()
  {
    $model = new TambahTorModel();
    $tambahdataId = $this->request->getGet('tambahdata_id');

    if ($tambahdataId) {
      $model->where('tambahdata_id', $tambahdataId)->delete();
      session()->setFlashdata('message', 'Data TOR berhasil direset.');
    }

    return redirect()->to('/prosesTor?tambahdata_id=' . $tambahdataId);
  }
}
