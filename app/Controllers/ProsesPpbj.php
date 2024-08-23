<?php

namespace App\Controllers;

use App\Models\TambahPpbjModel;

use App\Models\TambahPenerimaModel;
use CodeIgniter\Controller;

class ProsesPpbj extends Controller
{
  public function index()
  {
    $model = new TambahPpbjModel();
    $penerimaModel = new TambahPenerimaModel();

    $session_id = session()->get('id');
    $data['penerima_options'] = $penerimaModel->getPenerimaByRole('Penerima PPBJ');
    $data['all_data'] = $session_id ? $model->where('session_id', $session_id)->findAll() : [];

    $tambahdata_id = $this->request->getGet('tambahdata_id');

    if ($tambahdata_id) {
      $form_data = $model->where('tambahdata_id', $tambahdata_id)->first();
      if ($form_data) {
        // Set penerima_dokumenppbj ke ID penerima
        $penerimaModel = new TambahPenerimaModel();
        $penerima = $penerimaModel->where('nama_penerima', $form_data['penerima_dokumenppbj'])->first();
        $form_data['penerima_dokumenppbj'] = $penerima ? $penerima['id'] : '';
      }

      $data['form_data'] = $form_data ?? [
        'id' => '',
        'nomor_ppbj' => '',
        'tanggal_ppbj' => '',
        'nilai_ppbj' => '',
        'tanggal_pelimpahan' => '',
        'penerima_dokumenppbj' => '',
        'tambahdata_id' => $tambahdata_id
      ];

      if (isset($data['form_data']['nilai_ppbj']) && is_numeric($data['form_data']['nilai_ppbj'])) {
        $nilaiPpbj = (float)$data['form_data']['nilai_ppbj'];
        $data['form_data']['nilai_ppbj'] = 'Rp. ' . number_format($nilaiPpbj, 0, ',', '.');
      } else {
        // Jika harga_umk kosong atau bukan angka, set ke default format tanpa angka
        $data['form_data']['nilai_ppbj'] = 'Rp.';
      }

      $data['is_locked'] = $form_data ? true : false;
    } else {
      $data['form_data'] = [
        'id' => '',
        'nomor_ppbj' => '',
        'tanggal_ppbj' => '',
        'nilai_ppbj' => '',
        'tanggal_pelimpahan' => '',
        'penerima_dokumenppbj' => '',
        'tambahdata_id' => ''
      ];
      $data['is_locked'] = false;
    }

    return view('prosesPpbj', $data);
  }

  public function savePpbj()
  {
    $model = new TambahPpbjModel();
    $penerimaModel = new TambahPenerimaModel();

    if (!$this->validate([
      'nomorPpbj' => 'required',
      'tanggalPpbj' => 'required',
      'nilaiPpbj' => 'required|numeric',
      'tanggalPelimpahan' => 'required',
      'penerimaDokumenppbj' => 'required'
    ])) {
      return redirect()->back()->withInput()->with('error', 'Data tidak valid.');
    }

    $tambahdataId = $this->request->getPost('tambahdata_id');
    $nomorPpbj = $this->request->getPost('nomorPpbj');
    $tanggalPpbj = $this->request->getPost('tanggalPpbj');
    $nilaiPpbj = $this->request->getPost('nilaiPpbj');
    $tanggalPelimpahan = $this->request->getPost('tanggalPelimpahan');
    $penerimaId = $this->request->getPost('penerimaDokumenppbj');

    // Ambil nama penerima berdasarkan id
    $penerima = $penerimaModel->find($penerimaId);
    $penerimaNama = $penerima['nama_penerima'] ?? '';

    $nilaiPpbj = str_replace(['Rp. ', '.'], '', $nilaiPpbj);
    $nilaiPpbj = str_replace(',', '.', $nilaiPpbj); // Jika ada koma dalam input, ganti dengan titik


    $data = [
      'tambahdata_id' => $tambahdataId,
      'nomor_ppbj' => $nomorPpbj,
      'tanggal_ppbj' => $tanggalPpbj,
      'nilai_ppbj' => $nilaiPpbj,
      'tanggal_pelimpahan' => $tanggalPelimpahan,
      'penerima_dokumenppbj' => $penerimaNama // Simpan nama penerima
    ];

    try {
      if ($model->where('tambahdata_id', $tambahdataId)->first()) {
        $model->update($tambahdataId, $data);
      } else {
        $model->insert($data);
      }

      session()->setFlashdata('message', 'Data PPBJ berhasil disimpan.');
      return redirect()->to('/prosesPpbj?tambahdata_id=' . $tambahdataId);
    } catch (\Exception $e) {
      log_message('error', 'Gagal menyimpan data: ' . $e->getMessage());
      session()->setFlashdata('error', 'Gagal menyimpan data: ' . $e->getMessage());
      return redirect()->back()->withInput();
    }
  }
  public function resetPpbj()
  {
    $model = new TambahPpbjModel();
    $tambahdataId = $this->request->getGet('tambahdata_id');

    if ($tambahdataId) {
      $model->where('tambahdata_id', $tambahdataId)->delete();
      session()->setFlashdata('message', 'Data Ppbk berhasil direset.');
    }

    return redirect()->to('/prosesPpbj?tambahdata_id=' . $tambahdataId);
  }
}
