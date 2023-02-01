<?php

namespace App\Models\K1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\k1\K1_Product;
use App\Models\k1\K1_Product_stock;

class K1_Transacion_struck extends Model
{
    use HasFactory;
    protected $table = 'k1_transaction_struck';

    public function getStruck(){
        return $this->hasMany(K1_Transaction_detail::class,'kode_transaction','kode_transaction_inStruck');
    }

}
