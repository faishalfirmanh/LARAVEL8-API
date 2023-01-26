<?php

namespace App\Service\K1\TransactionDetail;
use App\Http\Requests\K1_TransRequest;
use App\Repository\K1\TransactionDetail\TransactionDetailRepository;
use App\Repository\K1\GenerateNewTransaction\GenerateTransRepo;
use App\Repository\K1\ProductStock\ProductStockRepo;
use App\Repository\K1\VoucherForTransaction\VoucherRepository;
use Illuminate\Support\Facades\Validator;
class TransactionDetailServImplement implements TransactionDetailServ{
    
    private $repository;
    private $repo_generate_new_trans;
    private $repo_product_stock;
    private $repo_voucher;
    public function __construct(
        TransactionDetailRepository $repository,
        GenerateTransRepo $repo_generate_new_trans,
        ProductStockRepo $repo_product_stock,
        VoucherRepository $repo_voucher)
    {
        $this->repository = $repository;
        $this->repo_generate_new_trans = $repo_generate_new_trans;
        $this->repo_product_stock = $repo_product_stock;
        $this->repo_voucher = $repo_voucher;
    }

    public function GenerateNewTransService($data)
    {
        $reponse = $this->repo_generate_new_trans->GenerateNewTransaction($data);
        return response()->json([
            'status'=> 'ok',
            'kode_transaction'=> $reponse->kode_transaction
        ],200);
    }

    public function UpdateGenerateStatusService($kode_trans)
    {
        
    }

    public function PostTransactionDetailService($request)
    {
        $total_product_buy = intval($request->total_product);
        $stock_berfore = getProductStockAndPrice($request->id_product)->stock;
       
        if ($total_product_buy > $stock_berfore) {
            return response()->json([
                'status'=> 'failed transaction',
                'msg'=> 'the number of purchases is more than stock',
                'max_purchases'=> $stock_berfore
            ],400);
        }else{
            $price_prod_one = getProductStockAndPrice($request->id_product)->harga_jual;
            $request->price_each_item = intval($price_prod_one) * intval($total_product_buy);//ok
            $stock_after_buy = $stock_berfore-$total_product_buy;
            //db
             $update_stock = $this->repo_product_stock->updateProductStockRepo($request->id_product,$stock_after_buy);
             if (cekTransactionSameProdId($request->id_product,$request->kode_transaction) == null) {
                $transaction_one_product = $this->repository->PostTransaction($request);
             }else{
                $trans = cekTransactionSameProdId($request->id_product,$request->kode_transaction);
                $trans->idTransactionDetail = $trans->id;
                $trans->total_product = $trans->total_product+$total_product_buy;
                $trans->harga_total_tiap_product = $trans->harga_total_tiap_product+intval($request->price_each_item);
                $transaction_one_product = $this->repository->UpdateTransaction($trans);
             }
           
             if (getCodeGenerateTransaction($request->kode_transaction)->status == 0) {
                $this->repo_generate_new_trans->UpdateGenerateTransaction($request->kode_transaction,1);
             }
             $amoun_must_pay = $this->repository->AmountMusPayTransaction($request->kode_transaction);
            //validation promo start
             $setting_promo = cekSettingVoucer();
             $var_voucher = []; //voucher[0]
             if ($setting_promo->is_active == '1' && $amoun_must_pay > $setting_promo->price_min) {
                    $str_random = generateRandomStringForVoucher(10);
                    $vocher_date = voucher_from_date();
                    $expired_date = date("Y-m-d", strtotime(date("Y-m-d h:i:sa") . ' +'.$setting_promo->expired_voucher.' day'));
                    if (cekVoucherCode($str_random) == null) {
                        $voucher = $str_random;
                    }else{
                        $voucher = 'V'.$vocher_date;
                    }
                    $request_for_voucher = $request;
                    $request_for_voucher->code_voucher = $voucher;
                    $request_for_voucher->expired = $expired_date;
                    //insert voucher
                    $success_create_voucher = $this->repo_voucher->CreateNewVoucherTransaction($request_for_voucher);
                    array_push($var_voucher,$success_create_voucher->kode_voucher);
             }
             //validation promo end
            $data_transaction_details = $this->repository->GetTransactionByCodeTrans($request->kode_transaction);
            $temporary_struck = array();
            foreach ($data_transaction_details as $key) {
               $key->name_prod = $key->temporaryStruck->name_product;
               $key->harga_1_product = $key->hargaSatuProduct->harga_jual;
               array_push($temporary_struck,$key);
            }
            return response()->json([
                'status'=> 'success',
                'msg'=> 'transaction success',
                'transaction'=>[
                     'transaction'=>$transaction_one_product,
                     'current_stock'=>$update_stock->stock,
                ],
                'temporary_struck'=>[
                    'product_buy'=>$temporary_struck,
                    'total_bayar'=>$amoun_must_pay
                ]
            ],200);
        }
    }
    public function DeleteTransactionDetailService($id)
    {
        
    }
}