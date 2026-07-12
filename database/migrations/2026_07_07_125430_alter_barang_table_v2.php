<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            // Hapus kolom yang tidak diperlukan
            $table->dropForeign(['kategori_id']);
            $table->dropColumn([
                'kategori_id',
                'merk',
                'model',
                'serial_number',
                'tanggal_pengadaan',
                'harga_perolehan',
            ]);

            // Ganti stok → jumlah_barang
            $table->renameColumn('stok', 'jumlah_barang');

            // Tambah kategori sebagai teks manual
            $table->string('kategori')->nullable()->after('nama_barang');

            // waktu_input jadi timestamp otomatis (sudah ada kolom, tapi ubah default)
            $table->string('waktu_input')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->renameColumn('jumlah_barang', 'stok');
            $table->dropColumn('kategori');
            $table->string('merk')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->date('tanggal_pengadaan')->nullable();
            $table->decimal('harga_perolehan', 15, 2)->nullable();
            $table->unsignedBigInteger('kategori_id')->nullable();
        });
    }
};
