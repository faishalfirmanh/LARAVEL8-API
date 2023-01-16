<?php 
namespace App\Service\K1\ProductStock;

interface ProductStockService{
    public function getAllProductStockService();
    public function getProductStockServiceById($id);
    public function postProductStockService($data);
    public function updateProductStockService($id,$data);
    public function deleteProductStockService($id);
}