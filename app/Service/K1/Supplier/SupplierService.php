<?php
namespace App\Service\K1\Supplier;

interface SupplierService{
    public function getAllSupplierService();
    public function getSupplierServicePaginate($data);
    public function getSupplierByIdService($id);
    public function getPhoneSupplierService($data);
    public function postSupplierService($data);
    public function updateSupplierService($request,$id,$name,$phone,$name_pt);
    public function deleteSupplierService($id);

}