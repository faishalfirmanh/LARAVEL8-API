<?php
namespace App\Repository\K1\GenerateNewTransaction;

use App\Models\k1\K1_Generate_New_Transaction;

class GenerateTransRepoImpelemnt implements GenerateTransRepo{
    
    private $model;
    public function __construct(K1_Generate_New_Transaction $model)
    {
        $this->model = $model;   
    }

    public function GenerateNewTransaction($data)
    {
        $new = $this->model;
        $new->kode_transaction = $data;
        $new->save();
        return $new->fresh();
    }

    public function UpdateGenerateTransaction($kode,$status)
    {
        $trans = $this->model->query()->where('kode_transaction',$kode)->first();
        $trans->status = $status;
        $trans->save();
        return $trans->fresh();
    }


}