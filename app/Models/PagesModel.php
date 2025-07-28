<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagesModel extends Model
{
    protected $table = 'halaman';
    protected $guarded = ['id'];

    protected $casts = [
        'gambar' => 'array',
        'status_halaman' => 'boolean',
    ];

    public function kategori()
    {
        return $this->belongsTo(KatPagesModel::class, 'kategori_id');
    }
}
