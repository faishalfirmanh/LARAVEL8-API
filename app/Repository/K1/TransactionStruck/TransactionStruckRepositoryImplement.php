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

    public function PostTransactionStruck($data) //1
    {
        $new = $this->model_struck;
        $new->total_harga = $data->amount; //auto
        $new->kode_transaction_inStruck = $data->kode_transaction; //auto
        $new->total_bayar = $data->money_from_user;
        $new->kembalian = 0;
        $new->status = 0;
        $new->save();
        return $new->fresh();
    }
    
    public function UpdateTransactionStruck($data) //2
    {
        $find = $this->model_struck->where('kode_transaction_inStruck',$data->kode_transaction)->first();
        $find->total_bayar = $data->money_from_user;
        $find->kembalian = $data->kembalian;
        $find->status = $data->status;
        $find->is_voucher_code = $data->voucher;
        $find->save();
        return $find->fresh();
    }

    public function GetTransactionStruckByCodeTrans($code_transaction)
    {
        $find = $this->model_struck->where('kode_transaction_inStruck',$code_transaction->kode_transaction)->first();
        return $find;
    }
}