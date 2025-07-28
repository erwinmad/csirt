<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teammodel extends Model
{
    protected $table = 'team_kami';
    protected $guarded = ['id'];

    protected $casts = [
        'foto' => 'string',
    ];

    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}
