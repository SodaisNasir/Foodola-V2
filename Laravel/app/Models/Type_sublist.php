<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_sublist extends Model
{

    use HasFactory;
       public $timestamps = false; 
    protected $table = 'types_sublist';

    protected $fillable  = [
        'type_id',
        'type_title_user',
        'ts_name'
    ];
 
}