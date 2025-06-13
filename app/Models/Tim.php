<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    protected $table = 'tim';
    protected $fillable = ['nama', 'kota'];

    public function pertandinganHome()
    {
        return $this->hasMany(Pertandingan::class, 'tim_home_id');
    }

    public function pertandinganAway()
    {
        return $this->hasMany(Pertandingan::class, 'tim_away_id');
    }
}
