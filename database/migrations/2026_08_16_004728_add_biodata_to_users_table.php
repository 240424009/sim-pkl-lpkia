<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nisn')->nullable()->after('email');
            $table->string('asal_sekolah')->nullable()->after('nisn');
            $table->string('departemen_lpkia')->nullable()->after('asal_sekolah'); // misal: IT Support, Keuangan, Marketing
            $table->date('tanggal_mulai_pkl')->nullable()->after('departemen_lpkia');
            $table->date('tanggal_selesai_pkl')->nullable()->after('tanggal_mulai_pkl');
            $table->string('no_hp')->nullable()->after('tanggal_selesai_pkl');
            $table->text('alamat')->nullable()->after('no_hp');
            $table->string('nama_orang_tua')->nullable()->after('alamat');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nisn', 'asal_sekolah', 'departemen_lpkia', 
                'tanggal_mulai_pkl', 'tanggal_selesai_pkl', 
                'no_hp', 'alamat', 'nama_orang_tua'
            ]);
        });
    }
};