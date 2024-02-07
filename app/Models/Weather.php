<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $fillable = [
        'timestamp_dt',
        'city_name',
        'min_tmp',
        'max_tmp',
        'wind_spd'
    ];
}
