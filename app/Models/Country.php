<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    
    protected $table = 'countries_national';
    public $timestamps = false;
    
    protected $fillable = [
        'country_name',
        'nationality',
        'spoken_language'
    ];
}
