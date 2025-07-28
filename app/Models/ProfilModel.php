<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilModel extends Model
{
    protected $table = 'profil';
    
    protected $fillable = [
        'nama',
        'email',
        'telp',
        'alamat',
        'website',
        'instagram',
        'foto_path' // tambahkan ini jika Anda ingin menyimpan path foto
    ];
}