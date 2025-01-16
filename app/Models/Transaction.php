<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $fillable = [
        'bill_no',
        'ex_cat',
        'amount',
        'handle_by',
        'description',
        'status',
        'date'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];
}
