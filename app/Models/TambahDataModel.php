<?php

namespace App\Models;

use CodeIgniter\Model;

class TambahDataModel extends Model
{
    protected $table = 'tambahdata';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_dokumen',
        'jenis_dokumen',
        'nama_bidang',
        'KABID',
        'tanggal',
        'user_id',
        'status_tor',
        'status_budgeting',
        'status_ppbj',
        'status_pesan',
        'status_selesai',
        'jumlah', // Tambahkan kolom ini
        'harga_satuan', // Tambahkan kolom ini
        'total_harga' // Tambahkan kolom ini
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';
    
    protected $createdField  = 'created_at'; // Nama kolom untuk created_at
    protected $updatedField  = 'updated_at'; // Nama kolom untuk updated_at

    public function getDataWithKepala()
    {
        return $this->select('tambahdata.*, kepala_bidang.nama_kepala as KABID')
            ->join('kepala_bidang', 'tambahdata.nama_bidang = kepala_bidang.nama_bidang')
            ->orderBy('tambahdata.tanggal', 'DESC') // Urutkan berdasarkan tanggal terbaru
            ->findAll();
    }

    // Model method to delete document
    public function deleteDocument($id)
    {
        return $this->where('id', $id)->delete();
    }
    public function getDataByMonth($month)
    {
        $builder = $this->builder();
        $builder->where("DATE_FORMAT(tanggal, '%Y-%m')", $month);
        return $builder->get()->getResultArray();
    }
}
