<?php

namespace App\Models;

use CodeIgniter\Model;

class TambahPenerimaModel extends Model
{
    protected $table = 'tambahpenerima'; // Nama tabel
    protected $primaryKey = 'id'; // Nama kolom primary key

    protected $allowedFields = [
        'nama_penerima',
        'role'
    ]; // Kolom yang diperbolehkan untuk diinsert/update


    public function updateNamapenerima($id, $nama_penerima)
    {
        return $this->update($id, ['nama_penerima' => $nama_penerima]);
    }

    public function getPenerimaByRole($role)
    {
        return $this->where('role', $role)->findAll(); // Gunakan kolom yang benar
    }
}
