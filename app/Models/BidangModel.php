<?php

namespace App\Models;

use CodeIgniter\Model;

class BidangModel extends Model
{
    protected $table = 'kepala_bidang'; // Sesuaikan dengan nama tabel Anda
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_bidang', 'nama_kepala'];

    public function updateKepalaBidang($id, $nama_kepala)
    {
        return $this->update($id, ['nama_kepala' => $nama_kepala]);
    }
}
