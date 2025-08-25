<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{

    use HasFactory;
protected $table = 'products';
protected $fillable  = [

    'csv_file',
    'addon_id',
    'type_id',
    'dressing_id',
    'sub_category_id',
    'name',
    'sku_id',
    'description',
    'cost',
    'price',
    'discount',
    'qty',
    'img'

];
 
}
