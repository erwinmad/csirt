<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SKPDModel extends Model
{

    protected $table = 'daftar_skpd';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_skpd',
        'slug_skpd',
        'alias_skpd',
        'email_skpd',
        'no_telp_skpd',
        'website_skpd',
        'logo_skpd',
        'alamat_skpd',
        'skpd_id'
    ];

    public function apps()
    {
        return $this->hasMany(AppsModel::class, 'skpd_id', 'id');
    }
    
}
