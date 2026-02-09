<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrScanLog extends Model
{
    use HasFactory;

    protected $table = 'qr_scan_logs';

    protected $fillable = [
        'raw_product_id',
        'quantity',
    ];
}
