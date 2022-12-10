<?php

namespace App\Models\P1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model\P1;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
class UserApi extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $table = 'usersapi';
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'token_login',
        'is_login',
        'last_login'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function products()
    {
        return $this->hasMany(P1\Product::class);
    }
}
