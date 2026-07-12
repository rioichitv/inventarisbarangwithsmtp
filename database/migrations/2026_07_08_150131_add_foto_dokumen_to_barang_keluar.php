<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang_keluar', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('keterangan');
            $table->string('dokumen')->nullable()->after('foto');
        });
    }

    public function down(): void
    {
        Schema::table('barang_keluar', function (Blueprint $table) {
            $table->dropColumn(['foto', 'dokumen']);
        });
    }
};
