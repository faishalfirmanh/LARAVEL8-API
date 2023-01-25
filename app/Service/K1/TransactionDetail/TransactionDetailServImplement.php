<?php

namespace App\Service\K1\TransactionDetail;
use App\Http\Requests\K1_TransRequest;
use App\Repository\K1\TransactionDetail\TransactionDetailRepository;
use App\Repository\K1\GenerateNewTransaction\GenerateTransRepo;
use App\Repository\K1\ProductStock\ProductStockRepo;
use Illuminate\Support\Facades\Validator;
class TransactionDetailServImplement implements TransactionDetailServ{
    
    private $repository;
    private $repo_generate_new_trans;
    private $repo_product_stock;
    public function __construct(
        TransactionDetailRepository $repository,
        GenerateTransRepo $repo_generate_new_trans,
        ProductStockRepo $repo_product_stock)
    {
        $this->repository = $repository;
        $this->repo_generate_new_trans = $repo_generate_new_trans;
        $this->repo_product_stock = $repo_product_stock;
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
             $post_transaction = $this->repository->PostTransaction($request);
             if (getCodeGenerateTransaction($request->kode_transaction)->status == 0) {
                $this->repo_generate_new_trans->UpdateGenerateTransaction($request->kode_transaction,1);
             }
             $amoun_must_pay = $this->repository->AmountMusPayTransaction($request->kode_transaction);

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
                     'transaction'=>$post_transaction,
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