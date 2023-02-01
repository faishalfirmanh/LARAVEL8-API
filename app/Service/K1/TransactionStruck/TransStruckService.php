<?php

namespace App\Service\K1\TransactionStruck;

interface TransStruckService{

    public function PostTransactionStruckService($data);
    public function UpdateTransactionStruckService($data);
    public function GetTransactionStrucByCodeTrans($code_trans); //all data
    public function GetProductTransStruckByCode($code_trans); // just data product
}