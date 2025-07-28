<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kategori_berita', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->string('slug_kategori');
            $table->timestamps();
        });

        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_berita')->onDelete('cascade');
            $table->string('judul_berita')->unique();
            $table->string('slug_berita');
            $table->date('tgl_berita');
            $table->longText('isi_berita');
            $table->json('gambar');
            $table->boolean('status_berita')->default(false);
            $table->boolean('featured_berita')->default(false);
            $table->integer('views')->default(0);
            $table->timestamps();
        });

        // Panggil seeder
        $this->seedBerita();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
        Schema::dropIfExists('kategori_berita');
    }

    /**
     * Seed berita dan kategori berita
     */
    private function seedBerita()
    {
        // Seed kategori berita
        DB::table('kategori_berita')->insert([
            [
                'nama_kategori' => 'Berita',
                'slug_kategori' => 'resmi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Pengumuman',
                'slug_kategori' => 'pengumuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Artikel',
                'slug_kategori' => 'artikel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed berita
        DB::table('berita')->insert([
            [
                'kategori_id' => 1,
                'judul_berita' => 'Peluncuran Sistem Pembayaran Pajak Online Terbaru',
                'slug_berita' => 'peluncuran-sistem-pembayaran-pajak-online-terbaru',
                'tgl_berita' => '2023-06-15',
                'isi_berita' => '<p>Dinas Pajak Daerah meluncurkan sistem pembayaran pajak online terbaru dengan fitur-fitur yang lebih lengkap dan antarmuka yang lebih user-friendly.</p>',
                'gambar' => json_encode(['images/news-placeholder.png']),
                'status_berita' => true,
                'featured_berita' => true,
                'views' => 325,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 1,
                'judul_berita' => 'Peningkatan Pendapatan Pajak Daerah Triwulan II 2023',
                'slug_berita' => 'peningkatan-pendapatan-pajak-daerah-triwulan-ii-2023',
                'tgl_berita' => '2023-07-10',
                'isi_berita' => '<p>Pendapatan pajak daerah menunjukkan peningkatan sebesar 15% pada triwulan II tahun 2023 dibandingkan periode yang sama tahun sebelumnya.</p>',
                'gambar' => json_encode(['images/news-placeholder.png']),
                'status_berita' => true,
                'featured_berita' => false,
                'views' => 278,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 2,
                'judul_berita' => 'Jadwal Libur Pelayanan Pajak Hari Kemerdekaan',
                'slug_berita' => 'jadwal-libur-pelayanan-pajak-hari-kemerdekaan',
                'tgl_berita' => '2023-08-15',
                'isi_berita' => '<p>Berikut jadwal libur pelayanan pajak dalam rangka memperingati Hari Kemerdekaan Republik Indonesia.</p>',
                'gambar' => json_encode(['images/news-placeholder.png']),
                'status_berita' => true,
                'featured_berita' => false,
                'views' => 189,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 2,
                'judul_berita' => 'Pengumuman Perubahan Jam Pelayanan Kantor Pajak',
                'slug_berita' => 'pengumuman-perubahan-jam-pelayanan-kantor-pajak',
                'tgl_berita' => '2023-09-01',
                'isi_berita' => '<p>Mulai 1 September 2023, jam pelayanan kantor pajak akan berubah menjadi pukul 08.00-15.00 WIB.</p>',
                'gambar' => json_encode(['images/news-placeholder.png']),
                'status_berita' => true,
                'featured_berita' => false,
                'views' => 210,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 3,
                'judul_berita' => 'Tips Memahami Perhitungan Pajak Progresif Kendaraan',
                'slug_berita' => 'tips-memahami-perhitungan-pajak-progresif-kendaraan',
                'tgl_berita' => '2023-05-20',
                'isi_berita' => '<p>Artikel ini menjelaskan cara mudah memahami perhitungan pajak progresif untuk kendaraan bermotor pribadi.</p>',
                'gambar' => json_encode(['images/news-placeholder.png']),
                'status_berita' => true,
                'featured_berita' => true,
                'views' => 412,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 3,
                'judul_berita' => 'Manfaat Membayar Pajak Tepat Waktu',
                'slug_berita' => 'manfaat-membayar-pajak-tepat-waktu',
                'tgl_berita' => '2023-04-10',
                'isi_berita' => '<p>Artikel ini mengulas berbagai manfaat yang didapat ketika membayar pajak tepat waktu, baik bagi wajib pajak maupun pembangunan daerah.</p>',
                'gambar' => json_encode(['images/news-placeholder.png']),
                'status_berita' => true,
                'featured_berita' => false,
                'views' => 356,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
};