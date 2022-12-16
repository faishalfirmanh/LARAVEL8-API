<?php

namespace App\Models\P1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'p1_product';
    protected $fillable = [
        'id',
        'name_product',
        'description',
        'picture',
        'price',
        'id_category',
        'id_user',
    ];
}
