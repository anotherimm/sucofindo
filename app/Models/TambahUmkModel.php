<?php

namespace App\Models;

use CodeIgniter\Model;

class TambahUmkModel extends Model
{
    protected $table = 'umk'; // Table associated with this model
    protected $primaryKey = 'id'; // Primary key of the table

    protected $allowedFields = [
        'tambahdata_id',
        'tanggal_umk',
        'harga_umk',
        'vendor_umk'
    ];

    // Disables automatic timestamp management
    protected $useTimestamps = false;
}
