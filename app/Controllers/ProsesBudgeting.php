<?php

namespace App\Controllers;

use App\Models\TambahBudgetModel;
use App\Models\TambahPenerimaModel;
use CodeIgniter\Controller;

class ProsesBudgeting extends Controller
{

  public function index()
  {
    $model = new TambahBudgetModel();
    $penerimaModel = new TambahPenerimaModel();

    $data['penerima_options'] = $penerimaModel->getPenerimaByRole('Penerima Budgeting');

    $tambahdata_id = $this->request->getGet('tambahdata_id');

    if ($tambahdata_id) {
      $form_data = $model->where('tambahdata_id', $tambahdata_id)->first();
      $data['form_data'] = $form_data ?? [
        'id' => '',
        'tanggal_masuk_budget' => '',
        'tanggal_diterima_setelah_budgeting' => '',
        'penerima_dokumen_budget' => '', // Pastikan ini konsisten
        'tambahdata_id' => $tambahdata_id
      ];

      $data['is_locked'] = $form_data ? true : false;
    } else {
      $data['form_data'] = [
        'id' => '',
        'tanggal_masuk_budget' => '',
        'tanggal_diterima_setelah_budgeting' => '',
        'penerima_dokumen_budget' => '', // Pastikan ini konsisten
        'tambahdata_id' => ''
      ];
      $data['is_locked'] = false;
    }

    // Debugging output
    log_message('info', 'Form Data: ' . print_r($data['form_data'], true));

    return view('prosesBudgeting', $data);
  }

  public function saveBudget()
  {
    $model = new TambahBudgetModel();
    $penerimaModel = new TambahPenerimaModel();

    $tambahdataId = $this->request->getPost('tambahdata_id');
    $tanggalMasukBudget = $this->request->getPost('tanggalMasukBudget');
    $tanggalDiterimaSetelahBudgeting = $this->request->getPost('tanggalDiterimaSetelahBudgeting');
    $penerimaId = $this->request->getPost('penerimaDokumenBudget');

    if (empty($penerimaId)) {
      session()->setFlashdata('error', 'Penerima Dokumen tidak boleh kosong.');
      return redirect()->back()->withInput();
    }

    $penerima = $penerimaModel->find($penerimaId);
    $penerimaNama = $penerima['nama_penerima'] ?? '';

    $data = [
      'tambahdata_id' => $tambahdataId,
      'tanggal_masuk_budget' => $tanggalMasukBudget,
      'tanggal_diterima_setelah_budgeting' => $tanggalDiterimaSetelahBudgeting,
      'penerima_dokumen_budget' => $penerimaNama // Simpan nama penerima, bukan ID
    ];

    try {
      $existingData = $model->where('tambahdata_id', $tambahdataId)->first();
      if ($existingData) {
        $model->update($existingData['id'], $data);
      } else {
        $model->insert($data);
      }

      session()->setFlashdata('message', 'Data Budget berhasil disimpan.');
      return redirect()->to('/prosesBudgeting?tambahdata_id=' . $tambahdataId);
    } catch (\Exception $e) {
      log_message('error', 'Error saving Budget: ' . $e->getMessage());
      session()->setFlashdata('error', 'Gagal menyimpan data: ' . $e->getMessage());
      return redirect()->back()->withInput();
    }
  }
  public function resetBudget()
  {
    $model = new TambahBudgetModel();
    $tambahdataId = $this->request->getGet('tambahdata_id');

    if ($tambahdataId) {
      $model->where('tambahdata_id', $tambahdataId)->delete();
      session()->setFlashdata('message', 'Data Budegting berhasil direset.');
    }

    return redirect()->to('/prosesBudgeting?tambahdata_id=' . $tambahdataId);
  }
}
