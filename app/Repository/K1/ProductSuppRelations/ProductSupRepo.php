<?php

namespace App\Repository\K1\ProductSuppRelations;

interface ProductSupRepo{
    public function getAllRelationProductSupp();
    public function getRelationProductSuppById($id);
    public function postProductSuppRelations($data);
    public function updateProductRelationsSup($id, $data);
    public function deleteProductRelationsSup($id);
}