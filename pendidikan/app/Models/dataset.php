<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataset extends Model
{
    use HasFactory;

    protected $table = 'datasets'; // Nama tabel di database

    // Tentukan kolom-kolom yang bisa diisi melalui mass assignment
    protected $fillable = [
        'pokok',
        'tingkat',
        'ket',
        'provinsi',
        'nilai'
    ];
}
