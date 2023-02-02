<?php
namespace App\Repository\K1\ProductCategory;

interface ProductCategoryRepo{
    public function GetProductCategoryByIdProdAndCategory($data);
    public function PostProductCategory($data);
}