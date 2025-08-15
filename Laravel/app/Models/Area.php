<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

    use HasFactory;
protected $table = 'tbl_areas';
protected $fillable  = [
'area_name',
'min_order_amount',
'branch_id'
];
 
}
