<?php

namespace App\Repository\K1\VoucherForTransaction;
use App\Models\k1\K1_Voucher_for_transaction;

class VoucherRepositoryImplement implements VoucherRepository{

    private $model;
    public function __construct(K1_Voucher_for_transaction $model)
    {
        $this->model = $model;
    }

    public function CreateNewVoucherTransaction($data)
    {
        $new = $this->model;
        $new->code_transaction = $data->kode_transaction;
        $new->kode_voucher = $data->code_voucher;
        $new->expired_voucher = $data->expired;
        $new->save();
        return $new->fresh();
    }

    public function UpdateVoucherTransaction($kode, $data)
    {
        $update = $this->model->where('kode_voucher',$kode)->first();
        $update->is_used = $data->is_used;
        $update->save();
        return $update->fresh();
    }
}