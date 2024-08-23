<?php

namespace App\Models;

use CodeIgniter\Model;

class TambahSpphModel extends Model
{
    protected $table = 'spph'; // Nama tabel yang terkait dengan model ini
    protected $primaryKey = 'id'; // Primary key tabel

    protected $allowedFields = [
        'tambahdata_id',
        'nomor_spph',
        'tanggal_spph',
        'nama_vendor1',
        'nama_vendor2',
        'nama_vendor3'
    ];

    // Menonaktifkan manajemen timestamp otomatis
    protected $useTimestamps = false;
}
