<?php

namespace App\Models;

use CodeIgniter\Model;

class KacabModel extends Model
{
    protected $table = 'kacab'; // Sesuaikan dengan nama tabel Anda
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_kacab']; // Sesuaikan dengan field yang ada di tabel

    public function updateKacab($id, $nama_kacab)
    {
        return $this->update($id, ['nama_kacab' => $nama_kacab]);
    }
}
