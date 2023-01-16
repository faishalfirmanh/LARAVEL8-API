<?php
namespace App\Service\K1\ProductSuppRelations;

use App\Repository\K1\ProductSuppRelations\ProductSupRepo;

class ProductSupServiceImpelemnt implements ProductSupService{
    
    protected $repo_product_relations;

    public function __construct(ProductSupRepo $repo_product_relations)
    {
        $this->repo_product_relations = $repo_product_relations;
    }

    public function getAllRelationProductSupplierService()
    {
        
    }

    public function getRelationsProductSupplierByIdService($id)
    {
        
    }

    public function postRelationsProductSupplierService($data)
    {
        return $this->repo_product_relations->postProductSuppRelations($data);
    }

    public function updateRelationsProductSupplierService($id, $data)
    {
        
    }

    public function deleteRelationsProductSupplierService($id)
    {
        
    }

}