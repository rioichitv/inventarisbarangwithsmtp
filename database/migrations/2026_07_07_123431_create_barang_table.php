<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->string('merk')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->enum('status', ['Tersedia', 'Digunakan', 'Dipinjam', 'Rusak'])->default('Tersedia');
            $table->string('lokasi')->nullable();
            $table->string('penanggung_jawab')->nullable();
            $table->date('tanggal_pengadaan')->nullable();
            $table->time('waktu_input')->nullable();
            $table->decimal('harga_perolehan', 15, 2)->nullable();
            $table->integer('stok')->default(1);
            $table->text('spesifikasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('foto')->nullable();
            $table->string('dokumen')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
