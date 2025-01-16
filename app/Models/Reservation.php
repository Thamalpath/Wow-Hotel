<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'guest_type',
        'guest_name',
        'guest_country',
        'contact_no',
        'email',
        'agent_code',
        'guest_from_cat',
        'room_type',
        'meal_plan',
        'no_of_pax',
        'total_pax_count',
        'rooms_need',
        'us',
        'rs',
        'description',
        'adults',
        'children',
        'infants',
        'reservation_date',
        'reservation_time',
        'departure_date',
        'no_of_day',
        'reservation_code',
        'status'
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'departure_date' => 'date',
        'reservation_time' => 'datetime',
        'us' => 'decimal:2',
        'rs' => 'decimal:2'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'Reservation');
    }
}
