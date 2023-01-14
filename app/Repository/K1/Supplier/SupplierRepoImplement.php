<?php
namespace App\Repository\K1\Supplier;
use App\Models\k1\K1_Supplier;

use function Doctrine\Common\Cache\Psr6\get;

class SupplierRepoImplement implements SupplierRepo{
    private $model;
    public function __construct(K1_Supplier $model)
    {
        $this->model = $model;
    }

    public function getAllSupplier()
    {
        return $this->model->all();
    }
    public function getSupplierById($id)
    {
        return $this->model->where('id',$id)->first();
    }
    public function getPhoneSupplier($phone){
        return cekPhoneNumberSupplier($phone);
    }
    

    public function postSupplier($data)
    {
        $model = $this->model;
        $model->name = $data->name;
        $model->phone_number = $data->phone_number;
        $model->name_pt = $data->name_pt;
        $model->save();
        return $model->fresh();
    }

    public function updateSupplier($id, $name, $phone, $pt)
    {
        $find_data = $this->model->where('id',$id)->first();
        $find_data->name = $name;
        $find_data->phone_number = $phone;
        $find_data->name_pt = $pt;     
        $find_data->save();
        return $find_data->fresh();
    }

    public function deleteSupplier($id)
    {
        $find_data = $this->model->find($id);
        return $find_data->delete();
    }
}