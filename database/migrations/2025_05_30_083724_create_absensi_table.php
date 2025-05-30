<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')
                ->constrained('karyawan')
                ->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jadwal_masuk')->default('08:00:00');
            $table->time('jadwal_pulang')->default('17:00:00');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->decimal('latitude_masuk', 10, 8)->nullable();
            $table->decimal('longitude_masuk', 11, 8)->nullable();
            $table->decimal('latitude_pulang', 10, 8)->nullable();
            $table->decimal('longitude_pulang', 11, 8)->nullable();
            $table->enum('status', ['hadir', 'telat', 'sakit', 'izin'])->default('hadir');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
