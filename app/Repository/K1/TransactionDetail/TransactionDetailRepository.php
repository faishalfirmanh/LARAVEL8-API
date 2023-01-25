<?php

namespace App\Repository\K1\TransactionDetail;

interface TransactionDetailRepository{
    public function PostTransaction($data);

    public function GetTransactionByCodeTrans($code_trans);
    public function DeleteTransaction($id,$code_trans);
    public function AmountMusPayTransaction($code_trans);

}