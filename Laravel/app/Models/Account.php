<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Account extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

   
    protected $table = 'accounts';
    
    protected $fillable = [
        'platform_user_id',
        'role_id',
        'company_name',
        'company_email',
        'password',
        'base_url',
        
        ];
}
