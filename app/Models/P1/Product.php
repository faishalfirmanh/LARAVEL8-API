<?php

namespace App\Models\P1;
use App\Models\P1\ProductImage;
use App\Models\P1\LinkOnlineShopProduct;
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

    public function listImageProduct()
    {
        return $this->hasMany(ProductImage::class, 'id_product');
    }
    public function listUrlOnlineShop()
    {
        return $this->hasMany(LinkOnlineShopProduct::class, 'id_product');
    }
}
