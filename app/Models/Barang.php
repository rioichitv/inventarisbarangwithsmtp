<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'kondisi',
        'status',
        'lokasi',
        'penanggung_jawab',
        'waktu_input',
        'jumlah_barang',
        'spesifikasi',
        'keterangan',
        'foto',
        'dokumen',
    ];

    protected $casts = [
        'waktu_input' => 'datetime',
    ];
}
