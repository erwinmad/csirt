<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeritaModel extends Model
{
    protected $table = 'berita';
    protected $fillable = [
        'kategori_id',
        'judul_berita',
        'slug_berita',
        'tgl_berita',
        'isi_berita',
        'gambar',
        'status_berita',
        'featured_berita',
        'views'
    ];

    protected $casts = [
        'tgl_berita' => 'date',
        'gambar' => 'array',
        'status_berita' => 'boolean',
        'featured_berita' => 'boolean'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KatBeritaModel::class, 'kategori_id');
    }

   
    public function scopeFeatured($query)
    {
        return $query->where('featured_berita', true);
    }
    
    public function scopePublished($query)
    {
        return $query->where('status_berita', true);
    }

    public function scopeBeritaDewan($query)
    {
        return $query->where('kategori_id', 1);
    }

    public function scopeBeritaSekre($query)
    {
        return $query->where('kategori_id', 2);
    }

    public function getRouteKeyName()
    {
        return 'slug_berita';
    }

    public function getGambarArrayAttribute()
    {
        if (empty($this->gambar)) {
            return [];
        }

        if (is_array($this->gambar)) {
            return $this->gambar;
        }

        $decoded = json_decode($this->gambar, true);
        return is_array($decoded) ? $decoded : [];
    }

    

}
