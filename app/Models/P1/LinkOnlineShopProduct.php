<?php

namespace App\Models\P1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkOnlineShopProduct extends Model
{
    use HasFactory;
    protected $table = 'p1_productlinkonlineshop';
    protected $fillable = [
        'id',
        'id_onlineshop',
        'id_product',
        'url'
    ];
}
