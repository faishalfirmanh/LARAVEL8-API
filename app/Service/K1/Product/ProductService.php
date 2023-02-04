<?php
namespace App\Service\K1\Product;

interface ProductService{
    public function getAllProductServiceAndSearch($search);
    public function getProductServicePaginate($page);
    public function getProducByIdService($id);
    public function postProductService($data);
    public function updateProductService($id, $data);
    public function deleteProductService($id);
}