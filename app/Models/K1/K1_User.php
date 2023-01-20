<?php

namespace App\Models\K1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class K1_User extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    
    protected $table = 'k1_user';
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
