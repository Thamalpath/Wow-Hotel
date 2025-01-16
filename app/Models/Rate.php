<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $table = 'rate';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'us_rate',
        'euro_rate',
        'svat',
        'vat1',
        'service_charge'
    ];
}
