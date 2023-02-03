<?php

namespace App\Http\Controllers\API\K1;

use App\Http\Controllers\Controller;
use App\Service\K1\Supplier\SupplierService;
use Illuminate\Http\Request;

class SupplierControllerK1 extends Controller
{
    //
    private $service_supplier;
    public function __construct(SupplierService $service_supplier)
    {
        $this->service_supplier = $service_supplier;
    }

    public function get_allSupplier_con()
    {
        return $this->service_supplier->getAllSupplierService();
    }
    public function get_allSupplier_paginate_con(Request $request)
    {
         return $this->service_supplier->getSupplierServicePaginate($request);
    }

    public function get_SupplierById_con(Request $request)
    {
        return $this->service_supplier->getSupplierByIdService($request);
    }
    public function ajaxGetPhoneSupplier(Request $request)
    {
        return $this->service_supplier->getPhoneSupplierService($request);
    }
    public function post_Supplier_con(Request $request)
    {
        return $this->service_supplier->postSupplierService($request);
    }
    public function update_Supplier_con(Request $request)
    {
        $id = $request->id_supplier;
        $name = $request->name;
        $phone = $request->phone_number;
        $pt = $request->name_pt;
        return $this->service_supplier->updateSupplierService($request,$id,$name,$phone,$pt);
    }

    public function delete_Supplier_con(Request $request)
    {
        return $this->service_supplier->deleteSupplierService($request);
    }

    
}
