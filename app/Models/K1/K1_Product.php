<?php

namespace App\Models\k1;
use App\Models\k1\K1_Product_supplier;
use App\Models\k1\K1_Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class K1_Product extends Model
{
    use HasFactory;
    protected $table = 'k1_Product';

    public function supplierProduct(){
        return $this->belongsToMany(K1_Supplier::class, 'k1_product_supplier', 'id_product', 'id_supplier')
        ->select('k1_supplier.id','name','phone_number','name_pt');
    }
}
