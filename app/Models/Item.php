<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = false;
    
    protected $table = 'items';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'item_code',
        'item_name',
        'price',
        'item_cat'
    ];
}
