<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'rooms'; 

    protected $fillable = [
        'room_no',
        'room_type',
        'status'
    ];

    public function registration()
    {
        return $this->hasOne(Registration::class, 'allocated_room_no', 'room_no');
    }
}
