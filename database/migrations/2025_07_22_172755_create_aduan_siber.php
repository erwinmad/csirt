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

        // $this->seedAduan();
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


    private function seedAduan()
    {
        // Data jenis aduan
        $jenisAduan = [
            [
                'jenis_aduan' => 'Bug/Aplikasi Error',
                'slug_jenis_aduan' => 'bug-aplikasi-error',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'jenis_aduan' => 'Kinerja Lambat',
                'slug_jenis_aduan' => 'kinerja-lambat',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'jenis_aduan' => 'Masuk ke Akun Orang Lain',
                'slug_jenis_aduan' => 'masuk-ke-akun-orang-lain',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'jenis_aduan' => 'Konten Tidak Pantas',
                'slug_jenis_aduan' => 'konten-tidak-pantas',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'jenis_aduan' => 'Keamanan Data',
                'slug_jenis_aduan' => 'keamanan-data',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'jenis_aduan' => 'Lainnya',
                'slug_jenis_aduan' => 'lainnya',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('jenis_aduan')->insert($jenisAduan);

        // Asumsi ada aplikasi dengan id 1 di tabel daftar_aplikasi
        $aduanSiber = [
            [
                'aplikasi_id' => 1,
                'jenis_aduan_id' => 1,
                'judul_aduan' => 'Error saat submit form pendaftaran',
                'deskripsi_aduan' => 'Setelah mengisi semua field dan klik submit, muncul error 500',
                'foto_aduan' => null,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(1)
            ],
            [
                'aplikasi_id' => 1,
                'jenis_aduan_id' => 2,
                'judul_aduan' => 'Loading dashboard sangat lambat',
                'deskripsi_aduan' => 'Waktu loading dashboard lebih dari 10 detik',
                'foto_aduan' => null,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(2)
            ]
        ];

        DB::table('aduan_siber')->insert($aduanSiber);

        // Data pelapor aduan
        $pelapor = [
            [
                'aduan_siber_id' => 1,
                'nama_pengadu' => 'Budi Santoso',
                'email_pengadu' => 'budi.santoso@example.com',
                'no_telp_pengadu' => '081234567890',
                'tanggapan' => 'Terima kasih atas laporannya, kami sedang mengecek masalah ini',
                'is_resolved' => false,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(1)
            ],
            [
                'aduan_siber_id' => 2,
                'nama_pengadu' => 'Ani Wijaya',
                'email_pengadu' => 'ani.wijaya@example.com',
                'no_telp_pengadu' => '082345678901',
                'tanggapan' => 'Kami sudah mengoptimalkan query database untuk memperbaiki masalah ini',
                'is_resolved' => true,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(2)
            ]
        ];

        DB::table('aduan_siber_pelapor')->insert($pelapor);

        // Data progres aduan
        $progres = [
            [
                'aduan_siber_id' => 1,
                'status' => 'Dalam Proses',
                'catatan' => 'Tim developer sedang mengecek source code terkait error ini',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2)
            ],
            [
                'aduan_siber_id' => 1,
                'status' => 'Diterima',
                'catatan' => 'Laporan telah diterima dan sedang diverifikasi',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3)
            ],
            [
                'aduan_siber_id' => 2,
                'status' => 'Diterima',
                'catatan' => 'Laporan telah diterima',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5)
            ],
            [
                'aduan_siber_id' => 2,
                'status' => 'Dalam Proses',
                'catatan' => 'Melakukan optimasi query database',
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4)
            ],
            [
                'aduan_siber_id' => 2,
                'status' => 'Selesai',
                'catatan' => 'Masalah telah diperbaiki dan di-deploy ke production',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2)
            ]
        ];

        DB::table('progres_aduan_siber')->insert($progres);
    }
    
};
