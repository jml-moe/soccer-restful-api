<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pertandingan extends Model
{
    use HasFactory;


    protected $table = 'pertandingan';
    protected $fillable = [
        'tanggal', 
        'waktu', 
        'lokasi',
        'tim_home_id', 
        'tim_away_id',
        'skor_home', 
        'skor_away',
        'liga_id'
    ];

    public function liga()
    {
        return $this->belongsTo(Liga::class);
    }

    public function timHome()
    {
        return $this->belongsTo(Tim::class, 'tim_home_id');
    }

    public function timAway()
    {
        return $this->belongsTo(Tim::class, 'tim_away_id');
    }
}
