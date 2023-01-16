<?php
namespace App\Service\K1\Product;

interface ProductService{
    public function getAllProductService();
    public function getProducByIdService($id);
    public function postProductService($data);
    public function updateProductService($id, $data);
    public function deleteProductService($id);
}