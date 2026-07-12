<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('no_keluar')->unique();
            $table->foreignId('barang_id')->constrained('barang')->onDelete('cascade');
            $table->integer('jumlah');
            $table->string('penerima');
            $table->string('bagian')->nullable();
            $table->date('tanggal_keluar');
            $table->string('keperluan')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('petugas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
