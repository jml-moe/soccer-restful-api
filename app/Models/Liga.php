<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Liga extends Model
{
    //
    use HasFactory;

    protected $table = 'liga';
    protected $fillable = ['nama', 'tahun_mulai', 'tahun_selesai'];

    public function pertandingan()
    {
        return $this->hasMany(Pertandingan::class);
    }
}
