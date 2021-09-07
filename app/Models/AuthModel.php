<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table      = 'warga';
    protected $db;
    protected $primaryKey = 'nik';
}
