<?php

namespace App\Controllers;

use App\Models\TambahUmkModel;

class adminUmk extends BaseController
{
    // Method to show the main page
    public function index()
    {
        $model = new TambahUmkModel();
        $tambahdata_id = $this->request->getGet('tambahdata_id');

        if ($tambahdata_id) {
            $form_data = $model->where('tambahdata_id', $tambahdata_id)->first();
            $data['form_data'] = $form_data ?? [
                'id' => '',
                'tanggal_umk' => '',
                'harga_umk' => '',
                'vendor_umk' => '',
                'tambahdata_id' => $tambahdata_id
            ];

            // Format harga_umk untuk tampilan jika ada dan bukan kosong
            if (isset($data['form_data']['harga_umk']) && is_numeric($data['form_data']['harga_umk'])) {
                $hargaUmk = (float)$data['form_data']['harga_umk'];
                $data['form_data']['harga_umk'] = 'Rp. ' . number_format($hargaUmk, 0, ',', '.');
            } else {
                // Jika harga_umk kosong atau bukan angka, set ke default format tanpa angka
                $data['form_data']['harga_umk'] = 'Rp.';
            }

            $data['is_locked'] = $form_data ? true : false;
        } else {
            $data['form_data'] = [
                'id' => '',
                'tanggal_umk' => '',
                'harga_umk' => '',
                'vendor_umk' => '',
                'tambahdata_id' => ''
            ];
            $data['is_locked'] = false;
        }

        return view('adminUmk', $data);
    }

    // Method to process and display Surat Pesanan data
    public function prosesUmk()
    {
        $tambahdata_id = $this->request->getGet('tambahdata_id');
        $model = new TambahUmkModel();

        if ($tambahdata_id) {
            $form_data = $model->where('tambahdata_id', $tambahdata_id)->first();
            $data['form_data'] = $form_data ?? [
                'tambahdata_id' => $tambahdata_id,
                'tanggal_umk' => '',
                'harga_umk' => 0.00,
                'vendor_umk' => ''
            ];

            // Format harga_umk untuk tampilan jika ada dan bukan kosong
            if (isset($data['form_data']['harga_umk']) && is_numeric($data['form_data']['harga_umk'])) {
                $hargaUmk = (float)$data['form_data']['harga_umk'];
                $data['form_data']['harga_umk'] = 'Rp. ' . number_format($hargaUmk, 0, ',', '.');
            } else {
                // Jika harga_umk kosong atau bukan angka, set ke default format tanpa angka
                $data['form_data']['harga_umk'] = 'Rp.';
            }

            $data['is_locked'] = $form_data ? true : false;
        } else {
            $data['form_data'] = [
                'tambahdata_id' => $tambahdata_id,
                'tanggal_umk' => '',
                'harga_umk' => 0.00,
                'vendor_umk' => ''
            ];
            $data['is_locked'] = false;
        }

        return view('adminUmk', $data);
    }

    public function saveUmk()
    {
        $model = new TambahUmkModel();

        $tambahdataId = $this->request->getPost('tambahdata_id');
        $tanggalUmk = $this->request->getPost('tanggal_umk');
        $hargaUmk = $this->request->getPost('harga_umk'); // Ini seharusnya tanpa format Rupiah
        $vendorUmk = $this->request->getPost('vendor_umk');
        $status = $this->request->getPost('status');

        // Debugging: Cek apakah 'tambahdata_id' ada
        if (empty($tambahdataId)) {
            session()->setFlashdata('error', 'ID data tidak boleh kosong.');
            return redirect()->back()->withInput();
        }

        // Convert hargaUmk dari format Rupiah ke format numerik
        $hargaUmk = str_replace(['Rp. ', '.'], '', $hargaUmk);
        $hargaUmk = str_replace(',', '.', $hargaUmk); // Jika ada koma dalam input, ganti dengan titik

        $data = [
            'tambahdata_id' => $tambahdataId,
            'tanggal_umk' => $tanggalUmk,
            'harga_umk' => $hargaUmk,
            'vendor_umk' => $vendorUmk,
            'status' => $status
        ];

        try {
            $existingData = $model->where('tambahdata_id', $tambahdataId)->first();
            if ($existingData) {
                $model->update($existingData['id'], $data);
            } else {
                $model->insert($data);
            }

            session()->setFlashdata('message', 'Data Uang Muka berhasil disimpan.');
            return redirect()->to('/adminUmk?tambahdata_id=' . $tambahdataId);
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Gagal menyimpan data: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    public function resetUmk()
    {
        $model = new TambahUmkModel();
        $tambahdataId = $this->request->getGet('tambahdata_id');

        if ($tambahdataId) {
            $model->where('tambahdata_id', $tambahdataId)->delete();
            session()->setFlashdata('message', 'Data UMK berhasil direset.');
        }

        return redirect()->to('/adminUmk?tambahdata_id=' . $tambahdataId);
    }
}
