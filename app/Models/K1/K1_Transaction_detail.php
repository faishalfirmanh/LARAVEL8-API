<?php

namespace App\Models\K1;

use App\Models\k1\K1_Product;
use App\Models\k1\K1_Product_stock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class K1_Transaction_detail extends Model
{
    use HasFactory;
    protected $table = 'k1_transaction_detail';

    public function temporaryStruck()
    {
        return $this->hasOne(K1_Product::class,'id','id_product')->select('name_product');
    }

    public function hargaSatuProduct()
    {
        return $this->hasOne(K1_Product_stock::class,'id_product','id_product')->select('harga_jual');
    }
}
