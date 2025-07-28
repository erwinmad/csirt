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
        Schema::create('kategori_skpd', function (Blueprint $table) {
            $table->id();
            $table->string('kategori_skpd');
            $table->string('slug_kategori_skpd');
        });

        Schema::create('daftar_skpd', function (Blueprint $table) {
            $table->id();
            $table->string('nama_skpd');
            $table->string('slug_skpd');
            $table->string('alias_skpd');
            $table->foreignId('skpd_id')->constrained('kategori_skpd')->cascadeOnDelete();
            $table->string('email_skpd')->nullable();
            $table->string('no_telp_skpd')->nullable();
            $table->string('website_skpd')->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('logo_skpd')->nullable();
            $table->string('alamat_skpd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_skpd');
    }
};
