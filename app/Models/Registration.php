<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $table = 'registration';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'guest_type',
        'guest_name', 
        'guest_country',
        'contact_no',
        'email',
        'id_pass',
        'expire_date',
        'address',
        'guest_from_cat',
        'room_type',
        'meal_plan',
        'no_of_pax',
        'total_pax_count',
        'rooms_need',
        'us',
        'rs',
        'currency',
        'description',
        'adults',
        'children',
        'infants',
        'reservation_date',
        'reservation_time',
        'departure_date',
        'departure_time',
        'no_of_day',
        'reservation_code',
        'profession',
        'allocated_room_no',
        'key_room',
        'status',
        'image'
    ];

    protected $casts = [
        'expire_date' => 'date',
        'reservation_date' => 'date',
        'departure_date' => 'date',
        'reservation_time' => 'datetime:H:i',
        'departure_time' => 'datetime:H:i',
        'us' => 'decimal:2',
        'rs' => 'decimal:2',
        'total_pax_count' => 'integer',
        'rooms_need' => 'integer',
        'adults' => 'integer',
        'children' => 'integer',
        'infants' => 'integer',
        'no_of_day' => 'integer'
    ];

    // Relationship with Room model
    public function room()
    {
        return $this->belongsTo(Room::class, 'allocated_room_no', 'room_no');
    }

    // Relationship with Reservation model
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_code', 'reservation_code');
    }
}
