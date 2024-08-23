<?php

namespace App\Models;

use CodeIgniter\Model;

class TambahBudgetModel extends Model
{
    protected $table = 'tambahbudget';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tambahdata_id',
        'tanggal_masuk_budget',
        'tanggal_diterima_setelah_budgeting',
        'penerima_dokumen_budget',
    ];

    // Nonaktifkan pengelolaan timestamp
    protected $useTimestamps = false;
    protected $returnType = 'array'; // Data return type
}
