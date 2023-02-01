<?php

namespace App\Service\K1\TransactionStruck;

use App\Repository\K1\TransactionDetail\TransactionDetailRepository;
use App\Repository\K1\TransactionStruck\TransactionStruckRepository;
use App\Repository\K1\VoucherForTransaction\VoucherRepository;

class TransStruckServiceImplement implements TransStruckService{

    private $repository;
    private $repo_trans_details;
    private $repo_voucher;
    public function __construct(
        TransactionStruckRepository $repository,
        TransactionDetailRepository $repo_trans_details,
        VoucherRepository $repo_voucher )
    {
        $this->repository = $repository;
        $this->repo_trans_details = $repo_trans_details;
        $this->repo_voucher = $repo_voucher;
    }

    public function PostTransactionStruckService($data) //trans 1
    {
        $total_harga = $this->repo_trans_details->AmountMusPayTransaction($data->kode_transaction);
        if (empty($data->money_from_user)) {
            $data->money_from_user = 0;
        }
        $data->amount = $total_harga;
        $save_to_db = $this->repository->PostTransactionStruck($data);
        return response()->json([
            'status'=> 'ok',
            'data'=>$save_to_db
        ],200);
        
    }

    public function GetProductTransStruckByCode($code_trans){
        $dataForeach = $this->repository->GetTransactionStruckByCodeTrans($code_trans);
        $var_struck = array();
        foreach ($dataForeach->getStruck as $key => $value) {
            $name_prod = $value->temporaryStruck->name_product;
            $harga_prod = $value->hargaSatuProduct->harga_jual;
            $jumlah_beli = $value->total_product;
            array_push($var_struck,$value);
         }
       return $var_struck;
    }

    public function UpdateTransactionStruckService($data)//trans 2
    {
        $data_trans_struck = $this->repository->GetTransactionStruckByCodeTrans($data);
        $total_harga = number_format($data_trans_struck->total_harga);
        if ($data_trans_struck->total_harga > $data->money_from_user) {
            $kurang = intval($data_trans_struck->total_harga)-intval($data->money_from_user);
            return response()->json([
                'status'=> 'error',
                'msg'=> 'less money '.number_format($kurang)
            ],400);
        }
        //first update
        //if ($data_trans_struck->total_bayar == 0) {
            //validation promo start get voucher or use voucher
             $setting_promo = cekSettingVoucer();
             $var_voucher = []; //voucher[0]
             $msg_voucher = [];
             if ($setting_promo->is_active == '1' && $data_trans_struck->total_harga > $setting_promo->price_min) {
                    $str_random = generateRandomStringForVoucher(10);
                    $vocher_date = voucher_from_date();
                    $expired_date = date("Y-m-d", strtotime(date("Y-m-d h:i:sa") . ' +'.$setting_promo->expired_voucher.' day'));
                    if (cekVoucherCode($str_random) == null) {
                        $voucher = 'V1_'.$str_random;
                    }else{
                        $voucher = 'V2_'.$vocher_date;
                    }
                    $request_for_voucher = $data;
                    $request_for_voucher->kode_transaction;
                    $request_for_voucher->code_voucher = $voucher;
                    $request_for_voucher->expired = $expired_date;
                    //insert voucher to db 
                    if ($data->voucher == null) {
                        if (cekCodeTransInVocuher($data->kode_transaction) == null) {// one transaction just get 1 vocuher
                            $success_create_voucher = $this->repo_voucher->CreateNewVoucherTransaction($request_for_voucher);
                            array_push($var_voucher,$success_create_voucher->kode_voucher);
                            array_push($msg_voucher,'You get voucher');
                        }else{
                            array_push($msg_voucher,'Error, code transaction already get voucher');
                        }
                    }else{
                    //update voucher to db when use voucher
                       $date_expired_voucher = cekVoucherCode($data->voucher)->expired_voucher;
                       $is_used_voucher = cekVoucherCode($data->voucher)->is_used;
                       if ($date_expired_voucher > date('Y-m-d')) {
                          if ($is_used_voucher == 1) {
                            array_push($msg_voucher,'Error, Voucher is used');
                          }else{
                            $data->is_used = 1;
                            $this->repo_voucher->UpdateVoucherTransaction($data->voucher,$data);
                            array_push($msg_voucher,'Success, Voucher can be use');
                          }
                       }else{
                            array_push($msg_voucher,'Error, voucher expired');
                       }
                    }
             }
            //validation promo end
            
            $data->kembalian = intval($data->money_from_user) - intval($data_trans_struck->total_harga);
            $data->status =1;
            $update_struck = $this->repository->UpdateTransactionStruck($data);

            return response()->json([
                'status'=>'ok',
                'msg'=>'success',
                'list_product'=>$this->GetProductTransStruckByCode($data),
                'data_trans'=>[
                    'id_trans'=>$update_struck->id,
                    'kode_trans'=>$data->kode_transaction,
                    'total_harga'=> number_format($update_struck->total_harga),
                    'bayar'=>number_format($update_struck->total_bayar),
                    'kembalian'=>number_format($update_struck->kembalian),
                    'status'=>$update_struck->status,
                ],
                'voucher'=>[
                    'code_get_vocuher'=>count($var_voucher) > 0 ? $var_voucher[0] : null,
                    'msg_voucer'=>count($msg_voucher) > 0 ? $msg_voucher[0] : null,
                ]
            ],200);
        //}
       
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
                'status'=>'ok',
                'data_struck'=>0,
                'length_data'=> 0
            ],200);
        }else{
            $var_struck = array();
            $amound_must_pay = $this->repo_trans_details->AmountMusPayTransaction($code_trans->kode_transaction);
            foreach ($data_trans_struck->getStruck as $key => $value) {
                $name_prod = $value->temporaryStruck->name_product;
                $harga_prod = $value->hargaSatuProduct->harga_jual;
                $jumlah_beli = $value->total_product;
                array_push($var_struck,$value);
             }
            return response()->json([
                'status'=>'ok',
                'length_data'=> count($var_struck),
                'data'=>$var_struck,
                'total_bayar'=>$amound_must_pay
            ],200);
            
        }
    }

}