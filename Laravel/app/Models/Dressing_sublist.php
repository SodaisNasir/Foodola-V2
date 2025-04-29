<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dressing_sublist extends Model
{

use HasFactory;
protected $table = 'dressing_sublist';
   public $timestamps = false; 
protected $fillable  = [
    'dressing_id',
    'dressing_title',
    'dressing_title_user',
    'dressing_name'

];
 
}