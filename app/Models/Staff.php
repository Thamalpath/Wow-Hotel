<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'known_name',
        'full_name',
        'contact_no',
        'address',
        'department',
        'id_no',
        'religion',
        'blood_group',
        'em_contact_no',
        'account_no',
        'account_name',
        'bank',
        'branch',
        'special_skills',
        'pre_worked',
        'joined_date',
        'currently_employed',
        'resign_date',
        'reason',
        'comments',
        'image'
    ];

    protected $casts = [
        'joined_date' => 'date:Y-m-d',
        'resign_date' => 'date:Y-m-d',
        'currently_employed' => 'string'
    ];
}
