<?php

namespace App\Models;

use App\Models\Tim;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Klasemen extends Model
{
    //
    use HasFactory;

    protected $table = 'klasemen';
    protected $fillable = [
        'tim_id',
        'points',
        'wins',
        'draws',
        'losses',
        'goals_for',
        'goals_against',
    ];

    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }

}
