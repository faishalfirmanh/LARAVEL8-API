<?php

namespace App\Service\K1\TransactionDetail;

interface TransactionDetailServ{
    public function GenerateNewTransService($data);
    public function UpdateGenerateStatusService($kode_trans);
    
    /** */
    public function PostTransactionDetailService($request);
    public function DeleteTransactionDetailService($id);
}