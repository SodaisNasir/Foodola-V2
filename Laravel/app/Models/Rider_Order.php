<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rider_Order extends Model
{
    use HasFactory;
    protected $table='orders_zee';
    protected $fillable=[
        'rider_id',
        'id',
        'status',
    ];
}
