<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AplikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedPlatformAplikasi();
        $this->seedKategoriAplikasi();
        $this->seedDatabaseAplikasi();
        $this->seedFrameworkAplikasi();
        $this->seedBahasaAplikasi();
        $this->seedJenisAplikasi();
        $this->seedJenis();
        $this->seedPembuatAplikasi();
    }

    private function seedJenisAplikasi()
    {
        $jenisAplikasi = [
            ['jenis_aplikasi' => 'Aplikasi Pertahanan', 'slug_jenis_aplikasi' => 'aplikasi-pertahanan'],
            ['jenis_aplikasi' => 'Aplikasi Urusan Luar Negeri', 'slug_jenis_aplikasi' => 'aplikasi-urusan-luar-negeri'],
            ['jenis_aplikasi' => 'Aplikasi Kenegaraan', 'slug_jenis_aplikasi' => 'aplikasi-kenegaraan'],
            ['jenis_aplikasi' => 'Aplikasi Ekonomi', 'slug_jenis_aplikasi' => 'aplikasi-ekonomi'],
            ['jenis_aplikasi' => 'Aplikasi Industri', 'slug_jenis_aplikasi' => 'aplikasi-industri'],
            ['jenis_aplikasi' => 'Aplikasi Perdagangan', 'slug_jenis_aplikasi' => 'aplikasi-perdagangan'],
            ['jenis_aplikasi' => 'Aplikasi Pertanian', 'slug_jenis_aplikasi' => 'aplikasi-pertanian'],
            ['jenis_aplikasi' => 'Aplikasi Perkebunan', 'slug_jenis_aplikasi' => 'aplikasi-perkebunan'],
            ['jenis_aplikasi' => 'Aplikasi Peternakan', 'slug_jenis_aplikasi' => 'aplikasi-peternakan'],
            ['jenis_aplikasi' => 'Aplikasi Perikanan', 'slug_jenis_aplikasi' => 'aplikasi-perikanan'],
            ['jenis_aplikasi' => 'Aplikasi Badan Usaha Milik Negara', 'slug_jenis_aplikasi' => 'aplikasi-badan-usaha-milik-negara'],
            ['jenis_aplikasi' => 'Aplikasi Investasi', 'slug_jenis_aplikasi' => 'aplikasi-investasi'],
            ['jenis_aplikasi' => 'Aplikasi Koperasi', 'slug_jenis_aplikasi' => 'aplikasi-koperasi'],
            ['jenis_aplikasi' => 'Aplikasi Usaha Kecil Dan Menengah', 'slug_jenis_aplikasi' => 'aplikasi-usaha-kecil-dan-menengah'],
            ['jenis_aplikasi' => 'Aplikasi Pariwisata', 'slug_jenis_aplikasi' => 'aplikasi-pariwisata'],
            ['jenis_aplikasi' => 'Aplikasi Perizinan dan Akreditasi', 'slug_jenis_aplikasi' => 'aplikasi-perizinan-dan-akreditasi'],
            ['jenis_aplikasi' => 'Aplikasi Pekerjaan Umum', 'slug_jenis_aplikasi' => 'aplikasi-pekerjaan-umum'],
            ['jenis_aplikasi' => 'Aplikasi Transmigrasi', 'slug_jenis_aplikasi' => 'aplikasi-transmigrasi'],
            ['jenis_aplikasi' => 'Aplikasi Transportasi', 'slug_jenis_aplikasi' => 'aplikasi-transportasi'],
            ['jenis_aplikasi' => 'Aplikasi Perumahan', 'slug_jenis_aplikasi' => 'aplikasi-perumahan'],
            ['jenis_aplikasi' => 'Aplikasi Pembangunan Kawasan atau Daerah Tertinggal', 'slug_jenis_aplikasi' => 'aplikasi-pembangunan-kawasan-atau-daerah-tertinggal'],
            ['jenis_aplikasi' => 'Aplikasi Kependudukan', 'slug_jenis_aplikasi' => 'aplikasi-kependudukan'],
            ['jenis_aplikasi' => 'Aplikasi Pemerintahan Daerah', 'slug_jenis_aplikasi' => 'aplikasi-pemerintahan-daerah'],
            ['jenis_aplikasi' => 'Aplikasi Kesehatan', 'slug_jenis_aplikasi' => 'aplikasi-kesehatan'],
            ['jenis_aplikasi' => 'Aplikasi Sosial', 'slug_jenis_aplikasi' => 'aplikasi-sosial'],
            ['jenis_aplikasi' => 'Aplikasi Pemberdayaan Perempuan', 'slug_jenis_aplikasi' => 'aplikasi-pemberdayaan-perempuan'],
            ['jenis_aplikasi' => 'Aplikasi Hukum', 'slug_jenis_aplikasi' => 'aplikasi-hukum'],
            ['jenis_aplikasi' => 'Aplikasi Keamanan', 'slug_jenis_aplikasi' => 'aplikasi-keamanan'],
            ['jenis_aplikasi' => 'Aplikasi Hak Asasi Manusia', 'slug_jenis_aplikasi' => 'aplikasi-hak-asasi-manusia'],
            ['jenis_aplikasi' => 'Aplikasi Pendidikan', 'slug_jenis_aplikasi' => 'aplikasi-pendidikan'],
            ['jenis_aplikasi' => 'Aplikasi Ketenagakerjaan', 'slug_jenis_aplikasi' => 'aplikasi-ketenagakerjaan'],
            ['jenis_aplikasi' => 'Aplikasi Ilmu Pengetahuan', 'slug_jenis_aplikasi' => 'aplikasi-ilmu-pengetahuan'],
            ['jenis_aplikasi' => 'Aplikasi Teknologi', 'slug_jenis_aplikasi' => 'aplikasi-teknologi'],
            ['jenis_aplikasi' => 'Aplikasi Pemuda', 'slug_jenis_aplikasi' => 'aplikasi-pemuda'],
            ['jenis_aplikasi' => 'Aplikasi Olahraga', 'slug_jenis_aplikasi' => 'aplikasi-olahraga'],
            ['jenis_aplikasi' => 'Aplikasi Pertambangan', 'slug_jenis_aplikasi' => 'aplikasi-pertambangan'],
            ['jenis_aplikasi' => 'Aplikasi Energi', 'slug_jenis_aplikasi' => 'aplikasi-energi'],
            ['jenis_aplikasi' => 'Aplikasi Kehutanan', 'slug_jenis_aplikasi' => 'aplikasi-kehutanan'],
            ['jenis_aplikasi' => 'Aplikasi Kelautan', 'slug_jenis_aplikasi' => 'aplikasi-kelautan'],
            ['jenis_aplikasi' => 'Aplikasi Lingkungan Hidup', 'slug_jenis_aplikasi' => 'aplikasi-lingkungan-hidup'],
            ['jenis_aplikasi' => 'Aplikasi Agama', 'slug_jenis_aplikasi' => 'aplikasi-agama'],
            ['jenis_aplikasi' => 'Aplikasi Kebudayaan', 'slug_jenis_aplikasi' => 'aplikasi-kebudayaan'],
            ['jenis_aplikasi' => 'Aplikasi Informasi', 'slug_jenis_aplikasi' => 'aplikasi-informasi'],
            ['jenis_aplikasi' => 'Aplikasi Komunikasi', 'slug_jenis_aplikasi' => 'aplikasi-komunikasi'],
            ['jenis_aplikasi' => 'Aplikasi Dalam Negeri', 'slug_jenis_aplikasi' => 'aplikasi-dalam-negeri'],
            ['jenis_aplikasi' => 'Aplikasi Keuangan', 'slug_jenis_aplikasi' => 'aplikasi-keuangan'],
            ['jenis_aplikasi' => 'Aplikasi Perencanaan Pembangunan Nasional', 'slug_jenis_aplikasi' => 'aplikasi-perencanaan-pembangunan-nasional'],
            ['jenis_aplikasi' => 'Aplikasi Aparatur Negara', 'slug_jenis_aplikasi' => 'aplikasi-aparatur-negara'],
            ['jenis_aplikasi' => 'Aplikasi Kesekretariatan Negara', 'slug_jenis_aplikasi' => 'aplikasi-kesekretariatan-negara'],
            ['jenis_aplikasi' => 'Aplikasi Dukungan Operasional Organisasi', 'slug_jenis_aplikasi' => 'aplikasi-dukungan-operasional-organisasi'],
            ['jenis_aplikasi' => 'Aplikasi Akuntabilitas Kinerja', 'slug_jenis_aplikasi' => 'aplikasi-akuntabilitas-kinerja'],
            ['jenis_aplikasi' => 'Aplikasi Organisasi dan Tata Kelola', 'slug_jenis_aplikasi' => 'aplikasi-organisasi-dan-tata-kelola'],
            ['jenis_aplikasi' => 'Aplikasi Data dan Informasi Pemerintahan', 'slug_jenis_aplikasi' => 'aplikasi-data-dan-informasi-pemerintahan'],
            ['jenis_aplikasi' => 'Website Pemerintah', 'slug_jenis_aplikasi' => 'website'],
        ];

        DB::table('jenis_aplikasi')->insert($jenisAplikasi);
    }

    private function seedPlatformAplikasi()
    {
        $platformAplikasi = [
            [
                'platform_aplikasi' => 'Web-Based',
                'slug_platform_aplikasi' => 'web-based',
            ],
            [
                'platform_aplikasi' => 'Mobile-Based',
                'slug_platform_aplikasi' => 'mobile-based',
            ],
            [
                'platform_aplikasi' => 'Desktop',
                'slug_platform_aplikasi' => 'desktop-based',
            ],
        ];

        DB::table('platform_aplikasi')->insert($platformAplikasi);
    }

    private function seedJenis()
    {
        $platformAplikasi = [
            [
                'nama_jenis' => 'Website',
                'slug_jenis' => 'website',
            ],
            [
                'nama_jenis' => 'Aplikasi',
                'slug_jenis' => 'aplikasi',
            ],
        ];

        DB::table('jenis')->insert($platformAplikasi);
    }

    private function seedPembuatAplikasi()
    {
        $pembuatAplikasi = [
            [
                'pembuat_aplikasi' => 'Aplikasi Pusat',
                'slug_pembuat_aplikasi' => 'aplikasi-pusat',
            ],
            [
                'pembuat_aplikasi' => 'Aplikasi Provinsi',
                'slug_pembuat_aplikasi' => 'aplikasi-provinsi',
            ],
            [
                'pembuat_aplikasi' => 'Aplikasi Daerah',
                'slug_pembuat_aplikasi' => 'aplikasi-daerah',
            ],
            [
                'pembuat_aplikasi' => 'Website',
                'slug_pembuat_aplikasi' => 'website',
            ],
        ];

        DB::table('pembuat_aplikasi')->insert($pembuatAplikasi);
    }

    private function seedKategoriAplikasi()
    {
        $kategoriAplikasi = [
            [
                'kategori_aplikasi' => 'Aplikasi Umum',
                'slug_kategori_aplikasi' => 'aplikasi-umum',
            ],
            [
                'kategori_aplikasi' => 'Aplikasi Khusus',
                'slug_kategori_aplikasi' => 'aplikasi-khusus',
            ],
            [
                'kategori_aplikasi' => 'Website',
                'slug_kategori_aplikasi' => 'website',
            ],
        ];

        DB::table('kategori_aplikasi')->insert($kategoriAplikasi);
    }

    private function seedDatabaseAplikasi()
    {
        $databaseAplikasi = [
            [
                'database_aplikasi' => 'MySQL',
                'slug_database_aplikasi' => 'mysql',
            ],
            [
                'database_aplikasi' => 'PostgreSQL',
                'slug_database_aplikasi' => 'postgresql',
            ],
            [
                'database_aplikasi' => 'Oracle',
                'slug_database_aplikasi' => 'oracle',
            ],
            [
                'database_aplikasi' => 'SQLite',
                'slug_database_aplikasi' => 'sqlite',
            ],
        ];

        DB::table('database_aplikasi')->insert($databaseAplikasi);
    }

    private function seedFrameworkAplikasi()
    {
        $frameworkAplikasi = [
            [
                'framework_aplikasi' => 'Laravel',
                'slug_framework_aplikasi' => 'laravel',
            ],
            [
                'framework_aplikasi' => 'Codeigniter',
                'slug_framework_aplikasi' => 'codeigniter',
            ],
            [
                'framework_aplikasi' => 'Yii',
                'slug_framework_aplikasi' => 'yii',
            ],
            [
                'framework_aplikasi' => 'React JS',
                'slug_framework_aplikasi' => 'react-js',
            ],
            [
                'framework_aplikasi' => 'Vue JS',
                'slug_framework_aplikasi' => 'vue-js',
            ],
            [
                'framework_aplikasi' => 'Angular JS',
                'slug_framework_aplikasi' => 'angular-js',
            ],
            [
                'framework_aplikasi' => 'PHP Native',
                'slug_framework_aplikasi' => 'php-native',
            ],
            [
                'framework_aplikasi' => 'Next JS',
                'slug_framework_aplikasi' => 'next-js',
            ],
            [
                'framework_aplikasi' => 'Nuxt JS',
                'slug_framework_aplikasi' => 'nuxt-js',
            ],
            [
                'framework_aplikasi' => 'Flutter',
                'slug_framework_aplikasi' => 'flutter',
            ],
            [
                'framework_aplikasi' => 'React Native',
                'slug_framework_aplikasi' => 'react-native',
            ],
            [
                'framework_aplikasi' => 'Ionic',
                'slug_framework_aplikasi' => 'ionic',
            ],
            [
                'framework_aplikasi' => 'Electron',
                'slug_framework_aplikasi' => 'electron',
            ],
            [
                'framework_aplikasi' => 'JavaFX',
                'slug_framework_aplikasi' => 'javafx',
            ],
            [
                'framework_aplikasi' => 'Swing',
                'slug_framework_aplikasi' => 'swing',
            ],
            [
                'framework_aplikasi' => 'Spring Boot',
                'slug_framework_aplikasi' => 'spring-boot',
            ],
            [
                'framework_aplikasi' => 'Struts',
                'slug_framework_aplikasi' => 'struts',
            ],
            [
                'framework_aplikasi' => 'Hibernate',
                'slug_framework_aplikasi' => 'hibernate',
            ],
            [
                'framework_aplikasi' => 'JSP',
                'slug_framework_aplikasi' => 'jsp',
            ],
            [
                'framework_aplikasi' => 'JSF',
                'slug_framework_aplikasi' => 'jsf',
            ],
            [
                'framework_aplikasi' => 'Primefaces',
                'slug_framework_aplikasi' => 'primefaces',
            ],
        ];

        DB::table('framework_aplikasi')->insert($frameworkAplikasi);
    }

    private function seedBahasaAplikasi()
    {
        $bahasaAplikasi = [
            [
                'bahasa_aplikasi' => 'PHP',
                'slug_bahasa_aplikasi' => 'php',
            ],
            [
                'bahasa_aplikasi' => 'Java',
                'slug_bahasa_aplikasi' => 'java',
            ],
            [
                'bahasa_aplikasi' => 'C#',
                'slug_bahasa_aplikasi' => 'c-sharp',
            ],
            [
                'bahasa_aplikasi' => 'C++',
                'slug_bahasa_aplikasi' => 'c-plus-plus',
            ],
            [
                'bahasa_aplikasi' => 'C',
                'slug_bahasa_aplikasi' => 'c',
            ],
            [
                'bahasa_aplikasi' => 'Python',
                'slug_bahasa_aplikasi' => 'python',
            ],
            [
                'bahasa_aplikasi' => 'Javascript',
                'slug_bahasa_aplikasi' => 'javascript',
            ],
        ];

        DB::table('bahasa_aplikasi')->insert($bahasaAplikasi);
    }
}