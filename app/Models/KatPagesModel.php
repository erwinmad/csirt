<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KatPagesModel extends Model
{
    public $table = 'kategori_halaman';

    public function pages()
    {
        return $this->hasMany(PagesModel::class, 'kategori_id', 'id');
    }
}
