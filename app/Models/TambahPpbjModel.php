<?php

namespace App\Models;

use CodeIgniter\Model;

class TambahPpbjModel extends Model
{
    protected $table = 'tambahppbj';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'tambahdata_id',
        'nomor_ppbj',
        'tanggal_ppbj',
        'nilai_ppbj',
        'tanggal_pelimpahan',
        'penerima_dokumenppbj'
    ];

    // Nonaktifkan penggunaan timestamp
    protected $useTimestamps = false;
}
