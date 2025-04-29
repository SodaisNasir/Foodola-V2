<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon_sublist extends Model
{

    use HasFactory;
     public $timestamps = false; 
protected $table = 'addon_sublist';

protected $fillable  = [

'ao_id',
'ao_title',
'as_name',
'as_price',
'isFreeInDeal'

];
 
}