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


        // Aplikasi atau Website
        Schema::create('jenis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis');
            $table->string('slug_jenis');
            $table->timestamps();
        });

        // Web based, Mobile Based dan Desktop Based
        Schema::create('platform_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('platform_aplikasi');
            $table->string('slug_platform_aplikasi');
            $table->timestamps();
        });
        // Web based, Mobile Based dan Desktop Based
       

        // Aplikasi Umum atau Aplikasi Khusus
        Schema::create('kategori_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('kategori_aplikasi');
            $table->string('slug_kategori_aplikasi');
            $table->timestamps();
        });

        Schema::create('jenis_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_aplikasi');
            $table->string('slug_jenis_aplikasi');
            $table->timestamps();
        });
        

        Schema::create('database_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('database_aplikasi');
            $table->string('slug_database_aplikasi');
            $table->timestamps();
        });

        Schema::create('framework_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('framework_aplikasi');
            $table->string('slug_framework_aplikasi');
            $table->timestamps();
        });
        
        Schema::create('bahasa_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('bahasa_aplikasi');
            $table->string('slug_bahasa_aplikasi');
            $table->timestamps();
        });

        Schema::create('pembuat_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('pembuat_aplikasi');
            $table->string('slug_pembuat_aplikasi');
            $table->timestamps();
        });

        Schema::create('daftar_aplikasi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('skpd_id')->constrained('daftar_skpd');
        $table->string('nama_aplikasi');
        $table->string('slug_aplikasi');
        $table->string('url_aplikasi')->nullable();
        $table->foreignId('jenis_id')->constrained('jenis');
        $table->foreignId('jenis_aplikasi_id')->nullable()->constrained('jenis_aplikasi'); // Made nullable
        $table->foreignId('kategori_aplikasi_id')->nullable()->constrained('kategori_aplikasi');
        $table->foreignId('bahasa_aplikasi_id')->constrained('bahasa_aplikasi');
        $table->foreignId('database_aplikasi_id')->constrained('database_aplikasi');
        $table->foreignId('framework_aplikasi_id')->constrained('framework_aplikasi');
        $table->foreignId('platform_aplikasi_id')->constrained('platform_aplikasi');
        $table->foreignId('pembuat_aplikasi_id')->constrained('pembuat_aplikasi');
        $table->string('uraian_aplikasi')->nullable();
        $table->string('tahun_pembuatan')->nullable();
        $table->string('fungsi_aplikasi')->nullable();
        $table->string('output_aplikasi')->nullable();
        $table->string('pengembang_aplikasi')->nullable();
        $table->boolean('is_active')->default(false);
        $table->boolean('is_featured')->default(false);
        $table->boolean('is_integrated')->default(false);
        $table->timestamps();
    });

         Schema::create('status_api', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daftar_aplikasi_id')->constrained('daftar_aplikasi');
            $table->string('link_api')->nullable();
            $table->string('tahun_link_api')->nullable();
            $table->string('link_api_splp')->nullable();
            $table->string('tahun_link_api_splp')->nullable();
            $table->timestamps();
        });
    }

     

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_aplikasi');

    }
};
