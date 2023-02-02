<?php
namespace App\Repository\K1\ProductCategory;

use App\Models\k1\K1_Product_category;

class ProductCategoryRepoImplement implements ProductCategoryRepo{

    private $model;
    public function __construct(K1_Product_category $model)
    {
        $this->model = $model;
    }

    public function GetProductCategoryByIdProdAndCategory($data)
    {
        
    }

    public function PostProductCategory($data)
    {
        $new = $this->model;
        $new->id_product = $data->idProd;
        $new->id_category = $data->id_category;
        $new->save();
        return $new->id;
    }

}