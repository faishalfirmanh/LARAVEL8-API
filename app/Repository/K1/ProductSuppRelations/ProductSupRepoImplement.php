<?php

namespace App\Repository\K1\ProductSuppRelations;

use App\Models\k1\K1_Product_supplier;

class ProductSupRepoImplement implements ProductSupRepo{

    private $model_product_supplier;
    public function __construct(K1_Product_supplier $model_product_supplier)
    {
        $this->model_product_supplier = $model_product_supplier;
    }

    public function getAllRelationProductSupp()
    {
        
    }

    public function getRelationProductSuppById($id)
    {
        
    }

    public function postProductSuppRelations($data)
    {
        $new_category_product = $this->model_product_supplier;
        $new_category_product->id_product = $data->id_product;
        $new_category_product->id_supplier = $data->id_supplier;
        return $new_category_product->save();
    }

    public function updateProductRelationsSup($id, $data)
    {
        
    }

    public function deleteProductRelationsSup($id)
    {
        
    }
}