<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders_Zee extends Model
{
    use HasFactory;
    protected $table='orders_zee';
    protected $fillable=[
        'status',
        'user_id',
        'order_total_price',
        'payment_type',
        'delivered_at',
        'rider_id'
    ];

    public $timestamps = false;
}

