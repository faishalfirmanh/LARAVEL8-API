<?php

namespace App\Repository\K1\TransactionStruck;

interface TransactionStruckRepository{
    public function PostTransactionStruck($data);
    public function UpdateTransactionStruck($data);
    public function GetTransactionStruckByCodeTrans($code_transaction);
}

