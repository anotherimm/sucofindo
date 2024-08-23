<?php

namespace App\Models;

use CodeIgniter\Model;

class TambahKontrakModel extends Model
{
    protected $table = 'kontrak'; // Nama tabel yang terkait dengan model ini
    protected $primaryKey = 'id'; // Primary key tabel

    protected $allowedFields = [
        'tambahdata_id',
        'nomor_kontrak',
        'tanggal_kontrak',
        'vendor_pemenang',
        'harga_kontrak'
    ];

    // Menonaktifkan manajemen timestamp otomatis
    protected $useTimestamps = false;
}
