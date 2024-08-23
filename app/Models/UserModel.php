<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // Nama tabel pengguna

    protected $primaryKey = 'id'; // Primary key dari tabel

    protected $allowedFields = ['email', 'username', 'password', 'role', 'reset_token', 'reset_expires']; // Kolom yang dapat diisi

    protected $useTimestamps = false; // Nonaktifkan penggunaan timestamp

    protected $returnType = 'array'; // Tipe data yang dikembalikan oleh model


}
