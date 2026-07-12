<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@inventaris.com'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('admin123'),
            ]
        );

        // Sample data barang
        $samples = [
            ['kode_barang' => 'IT-001', 'nama_barang' => 'Laptop Dell Latitude 5420',  'kategori' => 'Komputer & Laptop',    'kondisi' => 'Baik',        'status' => 'Digunakan',  'lokasi' => 'Ruang IT',     'jumlah_barang' => 5],
            ['kode_barang' => 'IT-002', 'nama_barang' => 'Switch Cisco 24 Port',        'kategori' => 'Jaringan',             'kondisi' => 'Baik',        'status' => 'Tersedia',   'lokasi' => 'Server Room',  'jumlah_barang' => 3],
            ['kode_barang' => 'IT-003', 'nama_barang' => 'Printer HP LaserJet M404dn', 'kategori' => 'Printer & Scanner',   'kondisi' => 'Baik',        'status' => 'Tersedia',   'lokasi' => 'Lantai 2',     'jumlah_barang' => 2],
            ['kode_barang' => 'IT-004', 'nama_barang' => 'Monitor LG 24 inch',         'kategori' => 'Monitor & Display',   'kondisi' => 'Baik',        'status' => 'Digunakan',  'lokasi' => 'Ruang Admin',  'jumlah_barang' => 10],
            ['kode_barang' => 'IT-005', 'nama_barang' => 'Server HP ProLiant DL380',   'kategori' => 'Server & Storage',    'kondisi' => 'Baik',        'status' => 'Digunakan',  'lokasi' => 'Server Room',  'jumlah_barang' => 1],
            ['kode_barang' => 'IT-006', 'nama_barang' => 'UPS APC 1000VA',             'kategori' => 'UPS & Power',         'kondisi' => 'Rusak Ringan','status' => 'Rusak',      'lokasi' => 'Server Room',  'jumlah_barang' => 4],
            ['kode_barang' => 'IT-007', 'nama_barang' => 'Keyboard Logitech K380',     'kategori' => 'Aksesoris IT',        'kondisi' => 'Baik',        'status' => 'Tersedia',   'lokasi' => 'Gudang IT',    'jumlah_barang' => 15],
            ['kode_barang' => 'IT-008', 'nama_barang' => 'Access Point Ubiquiti UAP',  'kategori' => 'Jaringan',            'kondisi' => 'Baik',        'status' => 'Tersedia',   'lokasi' => 'Lantai 3',     'jumlah_barang' => 6],
        ];

        foreach ($samples as $s) {
            $s['penanggung_jawab'] = 'Admin IT';
            $s['waktu_input']      = now()->format('H:i:s');
            Barang::updateOrCreate(['kode_barang' => $s['kode_barang']], $s);
        }
    }
}
