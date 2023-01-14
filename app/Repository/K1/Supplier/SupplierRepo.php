<?php
namespace App\Repository\K1\Supplier;

interface SupplierRepo{
    public function getAllSupplier();
    public function getSupplierById($id);
    public function getPhoneSupplier($phone);
    public function postSupplier($data);
    public function updateSupplier($id, $name, $phone, $pt);
    public function deleteSupplier($id);
}