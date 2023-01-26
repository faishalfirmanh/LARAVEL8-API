<?php

namespace App\Repository\K1\VoucherForTransaction;

interface VoucherRepository{
    public function CreateNewVoucherTransaction($data);
    public function UpdateVoucherTransaction($kode,$data);
}