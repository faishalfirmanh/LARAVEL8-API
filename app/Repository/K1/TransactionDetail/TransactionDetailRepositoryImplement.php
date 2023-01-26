<?php

namespace App\Repository\K1\TransactionDetail;

use App\Models\k1\K1_Transaction_detail;
use App\Models\k1\K1_Transacion_struck;
use App\Models\k1\K1_Voucher_for_transaction;

class TransactionDetailRepositoryImplement implements TransactionDetailRepository{

    private $model_transaction;
    private $model_transaction_struck;
    private $model_transc_voucher;

    public function __construct(K1_Transaction_detail $model_transaction)
    {
        $this->model_transaction = $model_transaction;
    }

    public function GetTransactionByCodeTrans($code_trans)
    {
        $find = $this->model_transaction->query()
        ->select('id','id_product','total_product','harga_total_tiap_product','kode_transaction')
        ->where('kode_transaction',$code_trans)->get();
        return $find;
    }

    public function PostTransaction($data)
    {
        $new = new $this->model_transaction;
        $new->id_user = $data->id_user;
        $new->id_product = $data->id_product;
        $new->total_product = $data->total_product;
        $new->harga_total_tiap_product = $data->price_each_item;
        $new->kode_transaction = $data->kode_transaction;
        $new->save();
        return $new->fresh();
    }

    public function UpdateTransaction($data)
    {
        $update = $this->model_transaction->where('id',$data->idTransactionDetail)->first();
        $update->total_product = $data->total_product;
        $update->harga_total_tiap_product = $data->harga_total_tiap_product;
        $update->save();
        return $update->fresh();
    }

    public function DeleteTransaction($id, $code_trans)//ketika delete stock dikembalikan
    { 
        
    }

    public function AmountMusPayTransaction($code_trans)
    {
        //select SUM(harga_total_tiap_product) as 'totalBayar' 
        //FROM k1_transaction_detail WHERE kode_transaction = '';
        $data = $this->model_transaction->query()->select('kode_transaction','harga_total_tiap_product')->where('kode_transaction',$code_trans)->sum('harga_total_tiap_product');
        return $data;
    }

}