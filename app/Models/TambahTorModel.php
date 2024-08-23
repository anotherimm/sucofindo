<?php

namespace App\Models;

use CodeIgniter\Model;

class TambahTorModel extends Model
{
    protected $table = 'tambahtor'; // Name of the table
    protected $primaryKey = 'id'; // Primary key of the table
    protected $allowedFields = [
        'tanggal_dikirim',
        'tanggal_diterima',
        'penerima_dokumen',
        'tambahdata_id'
    ]; // Columns that are allowed to be inserted/updated
    protected $useTimestamps = false; // Disable timestamps
    protected $returnType = 'array'; // Data return type

    // You can add additional methods here if needed for custom queries
}
