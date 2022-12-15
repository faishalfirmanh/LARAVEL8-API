<?php

namespace App\Models\P1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'p1_product_image';
     
    protected $fillable = [
        'image_name',
        'path',
        'id_product',
    ];
}
