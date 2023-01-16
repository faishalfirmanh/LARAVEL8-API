<?php

namespace App\Repository\K1\ProductStock;


interface ProductStockRepo{
    public function getAllProductStockRepo();
    public function getProductStockByIdRepo($idProduct);
    public function postProductStockRepo($data);
    public function updateProductStockRepo($idProduct,$data);
    public function deleteProductStockRepo($idProduct);
}
