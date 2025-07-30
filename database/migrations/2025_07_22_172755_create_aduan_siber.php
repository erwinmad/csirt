<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

         Schema::create('jenis_aduan', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_aduan');
            $table->text('slug_jenis_aduan');
            $table->timestamps();
        });
        
        Schema::create('aduan_siber', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aplikasi_id')->constrained('daftar_aplikasi')->onDelete('cascade');
            $table->foreignId('jenis_aduan_id')->constrained('jenis_aduan')->onDelete('cascade');
            $table->string('judul_aduan');
            $table->enum('status', ['Diterima', 'Dalam Proses', 'Selesai', 'Ditolak'])->default('Diterima');
            $table->string('url_aduan');
            $table->text('deskripsi_aduan');
            $table->string('foto_aduan')->nullable();
            $table->timestamps();
        });

        Schema::create('aduan_siber_pelapor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aduan_siber_id')->constrained('aduan_siber')->onDelete('cascade');
            $table->string('nama_pengadu');
            $table->string('email_pengadu')->nullable();
            $table->string('no_telp_pengadu')->nullable();
            $table->text('tanggapan')->nullable();
            $table->boolean('is_resolved')->default(false);
            $table->timestamps();
        });

        Schema::create('progres_aduan_siber', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aduan_siber_id')->constrained('aduan_siber')->onDelete('cascade');
            $table->enum('status', ['Diterima', 'Dalam Proses', 'Selesai', 'Ditolak']);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aduan_siber');
        Schema::dropIfExists('aduan_siber_pelapor');
        Schema::dropIfExists('progres_aduan_siber');
    }


    
};
