<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_halaman', function (Blueprint $table) {
            $table->id();
            $table->string('judul_halaman');
            $table->string('slug_halaman');
            $table->string('ikon_halaman');
            $table->timestamps();
        });

        Schema::create('halaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_halaman')->onDelete('cascade');
            $table->string('judul_halaman')->unique();
            $table->string('slug_halaman');
            $table->longText('deskripsi_halaman');
            $table->json('gambar');
            $table->integer('views')->default(0);
            $table->boolean('status_halaman')->default(false);
            $table->string('ikon_halaman');
            $table->timestamps();
        });

        $this->seedPages();
    }

    public function down(): void
    {
        Schema::dropIfExists('halaman');
        Schema::dropIfExists('kategori_halaman');
    }

    private function seedPages()
    {
        // Data 5 kategori
        $kategoris = [
            [
                'judul_halaman' => 'Profil',
                'slug_halaman' => 'profil',
                'ikon_halaman' => 'fa-user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul_halaman' => 'Layanan',
                'slug_halaman' => 'layanan',
                'ikon_halaman' => 'fa-cogs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul_halaman' => 'Informasi',
                'slug_halaman' => 'informasi',
                'ikon_halaman' => 'fa-info-circle',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('kategori_halaman')->insert($kategoris);

        // Data 5 halaman untuk setiap kategori
        $allKategoris = DB::table('kategori_halaman')->get();
        $halamanData = [];

        foreach ($allKategoris as $kategori) {
            for ($i = 1; $i <= 5; $i++) {
                $halamanData[] = [
                    'kategori_id' => $kategori->id,
                    'judul_halaman' => $kategori->judul_halaman . ' ' . $i,
                    'slug_halaman' => Str::slug($kategori->judul_halaman . ' ' . $i),
                    'deskripsi_halaman' => 'Ini adalah konten untuk halaman ' . $kategori->judul_halaman . ' ' . $i,
                    'gambar' => json_encode([
                        '/images/pages-placeholder.png',
                        '/images/pages-placeholder-' . $i . '.png'
                    ]),
                    'views' => rand(100, 1000),
                    'status_halaman' => true,
                    'ikon_halaman' => $kategori->ikon_halaman,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('halaman')->insert($halamanData);
    }
};