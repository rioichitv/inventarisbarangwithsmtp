<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';

    protected $fillable = [
        'no_keluar',
        'barang_id',
        'jumlah',
        'penerima',
        'bagian',
        'tanggal_keluar',
        'keperluan',
        'keterangan',
        'petugas',
        'foto',
        'dokumen',
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
