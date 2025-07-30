<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AduanSiber extends Model
{
    protected $table = 'aduan_siber';

    protected $fillable = [
        'aplikasi_id',
        'judul_aduan',
        'deskripsi_aduan',
        'foto_aduan',
    ];

    public function pelapor()
    {
        return $this->hasOne(AduanSiberPelapor::class, 'aduan_siber_id');
    }

    public function progres()
    {
        return $this->hasMany(ProgresAduanSiber::class, 'aduan_siber_id');
    }

    public function aplikasi()
    {
        return $this->belongsTo(DaftarAplikasiModel::class,'aplikasi_id');
    }

}
