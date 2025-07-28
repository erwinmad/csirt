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
        Schema::create('profil', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('telp');
            $table->string('alamat');
            $table->string('website');
            $table->string('instagram')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
        $this->seedProfil();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil');
    }

    public function seedProfil()
    {
        DB::table('profil')->insert([
            'nama' => 'CSIRT',
            'email' => 'csirt@cianjurkab.go.id',
            'telp' => '123456789',
            'alamat' => 'Jl. Raya Cianjur No.1',
            'website' => 'https://csirt.cianjurkab.go.id',
            'instagram' => 'https://instagram.com/csirtcianjur',
        ]);
    }
};
