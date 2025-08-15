<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dressing_list extends Model
{
   public $timestamps = false; 
use HasFactory;
protected $table = 'dressing_list';

protected $fillable  = [
    'dressing_title',
    'dressing_title_user'

];
 
}