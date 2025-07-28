<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresAduanSiber extends Model
{
    protected $table = 'progres_aduan_siber';

    protected $fillable = [
        'aduan_siber_id',
        'status',
        'keterangan',
        'tanggal',
    ];

    public function aduanSiber()
    {
        return $this->belongsTo(AduanSiber::class, 'aduan_siber_id');
    }
}
