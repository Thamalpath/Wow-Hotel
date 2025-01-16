<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'cat_name',
        'cat_code'
    ];

    const CATEGORY_TYPES = [
        'MP' => 'Meal Plan',
        'RT' => 'Room Types',
        'RC' => 'Room Category',
        'GF' => 'Guest From',
        'EX' => 'Expenses List',
        'DEP' => 'Department List'
    ];
}
