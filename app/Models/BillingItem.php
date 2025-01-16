<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingItem extends Model
{
    protected $table = 'billing_item';
    public $timestamps = false;

    protected $fillable = [
        'item_code',
        'item_name',
        'price',
        'allocated_room_no',
        'bill_date',
        'qty',
        'bill_total',
        'bill_no',
        'guest_name',
        'item_cat',
        'reservation_date',
        'reservation_code',
        'key_room'
    ];

    protected $casts = [
        'bill_date' => 'date',
        'reservation_date' => 'date',
        'price' => 'decimal:2',
        'bill_total' => 'decimal:2',
    ];

    public function scopeRestaurantBillings($query)
    {
        return $query->where('item_cat', 'R');
    }

    public function scopeOtherBillings($query)
    {
        return $query->where('item_cat', 'O');
    }
}
