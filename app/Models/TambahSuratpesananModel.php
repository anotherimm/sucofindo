<?php

namespace App\Models;

use CodeIgniter\Model;

class TambahSuratpesananModel extends Model
{
    protected $table = 'suratpesanan'; // Table associated with this model
    protected $primaryKey = 'id'; // Primary key of the table

    protected $allowedFields = [
        'tambahdata_id',
        'nomor_pesanan',
        'tanggal_pesanan',
        'harga_pesanan',
        'nama_vendor'
    ];

    // Disables automatic timestamp management
    protected $useTimestamps = false;
}
