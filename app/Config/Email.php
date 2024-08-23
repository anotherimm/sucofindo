<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public $protocol = 'smtp';
    public $SMTPHost = 'stelle.kawaiihost.net';
    public $SMTPUser = 'admin@monitoringtor.my.id';
    public $SMTPPass = 'miskoen16'; // Password aplikasi
    public $SMTPPort = 465;
    public $SMTPCrypto = 'ssl';
    public $mailType = 'html';
    public $charset = 'utf-8';

    // Opsi SSL
    public $SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ];
}