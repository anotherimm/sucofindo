<?php

namespace App\Controllers;

use App\Models\TambahDataModel;

class User extends BaseController
{
    public function dashboard()
    {
        // Pastikan hanya user yang bisa akses dashboard
        if (session()->get('role') !== 'user') {
            return redirect()->to('/auth/login');
        }

        // Ambil data dari model
        $model = new TambahDataModel();
        $data['tambah_data'] = $model->findAll(); // Ambil semua data dokumen

        return view('userDashboard', $data); // Tampilkan view userDashboard dengan data
    }
}
