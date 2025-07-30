<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DaftarAplikasiModel extends Model
{
    protected $table = 'daftar_aplikasi';

    public function pentests()
    {
        return $this->hasMany(Pentest::class, 'aplikasi_id','id');
    }
}
