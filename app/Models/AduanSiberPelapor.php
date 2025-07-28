<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AduanSiberPelapor extends Model
{
    protected $table = 'aduan_siber_pelapor';

    protected $fillable = [
        'aduan_siber_id',
        'nama_pengadu',
        'email_pengadu',
        'no_telp_pengadu',
        'tanggapan',
        'is_resolved',
    ];

    public function aduanSiber()
    {
        return $this->belongsTo(AduanSiber::class, 'aduan_siber_id');
    }
}
