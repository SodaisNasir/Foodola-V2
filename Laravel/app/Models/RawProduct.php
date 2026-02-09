<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawProduct extends Model
{
    use HasFactory;

    protected $table = 'raw_products';

    protected $fillable = [
        'name',
        'unit_id',
        'sku',
        'qr_code',
        'current_stock',
    ];



    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
