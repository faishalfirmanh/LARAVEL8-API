<?php

namespace App\Repository\K1\TransactionStruck;

use App\Models\k1\K1_Transacion_struck;
use App\Repository\K1\TransactionStruck\TransactionStruckRepository;

class TransactionStruckRepositoryImplement implements TransactionStruckRepository{
 
    private $model_struck;
    public function __construct(K1_Transacion_struck $model_struck)
    {
        $this->model_struck = $model_struck;
    }

    public function PostTransactionStruck($data)
    {
        $new = $this->model_struck;
        $new->total_harga = $data->amount; //auto
        $new->kode_transaction = $data->kode; //auto
        $new->total_bayar = $data->money_from_user;
        $new->kembalian = 0;
        $new->status = 0;
        $new->save();
        return $new->fresh();
    }
    
    public function UpdateTransactionStruck($data)
    {
        
    }

    public function GetTransactionStruckByCodeTrans($code_transaction)
    {
        $find = $this->model_struck->where('kode_transaction',$code_transaction->kode_transaction)->first();
        return $find;
    }
}