<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Types_list extends Model
{

    use HasFactory;
    protected $table = 'types_list';
   public $timestamps = false; 
    protected $fillable  = [
    'type_title',
    'type_title_user',
    'type_title',
    ''
    ];
 
}