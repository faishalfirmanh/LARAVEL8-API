<?php
namespace App\Service\K1\ProductSuppRelations;

interface ProductSupService{
    public function getAllRelationProductSupplierService();
    public function getRelationsProductSupplierByIdService($id);
    public function postRelationsProductSupplierService($data);
    public function updateRelationsProductSupplierService($id,$data);
    public function deleteRelationsProductSupplierService($id);
}
