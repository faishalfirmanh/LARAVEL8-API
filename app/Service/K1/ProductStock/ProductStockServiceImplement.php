<?php 

namespace App\Service\K1\ProductStock;

use App\Repository\K1\ProductStock\ProductStockRepo;
use App\Service\K1\ProductStockService;


class ProductStockServiceImplement implements ProductStockService{

    protected $repo_product_stock;
    public function __construct(ProductStockRepo $repo_product_stock)
    {
        $this->repo_product_stock = $repo_product_stock;
    }

    public function getAllProductStockService(){

    }

    public function getProductStockServiceById($id)
    {

    }

    public function postProductStockService($data)
    {
        return $this->repo_product_stock->postProductStockRepo($data);
    }

    public function updateProductStockService($id, $data)
    {

    }

    public function deleteProductStockService($id)
    {

    }
}