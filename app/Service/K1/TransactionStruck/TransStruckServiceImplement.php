<?php

namespace App\Service\K1\TransactionStruck;

use App\Repository\K1\TransactionDetail\TransactionDetailRepository;
use App\Repository\K1\TransactionStruck\TransactionStruckRepository;


class TransStruckServiceImplement implements TransStruckService{

    private $repository;
    private $repo_trans_details;
    public function __construct(
        TransactionStruckRepository $repository,
        TransactionDetailRepository $repo_trans_details)
    {
        $this->repository = $repository;
        $this->repo_trans_details = $repo_trans_details;
    }

    public function PostTransactionStruckService($data)
    {
        
        //$save_to_db = $this->repository->PostTransactionStruck($data);
    }

    public function UpdateTransactionStruckService($data)
    {
        
    }

    public function GetTransactionStrucByCodeTrans($code_trans)
    {
        //validasi code.

        $data_trans_struck = $this->repository->GetTransactionStruckByCodeTrans($code_trans);
        $data_trans_detail = $this->repo_trans_details->GetTransactionByCodeTrans($code_trans->kode_transaction);
        if (count($data_trans_detail) < 1) {
            return response()->json([
                'status'=>'eror',
                'msg'=> 'transaction not found',
                'code_transaction'=>$code_trans->kode_transaction
            ],404);
        }
        if($data_trans_struck == null){
            return response()->json([
                'data_struck'=>0,
                'length_data'=> 0
            ],200);
        }else{
            return response()->json([
                'data_struck'=>1,
                'length_data'=> 1
            ],200);
        }
    }

}