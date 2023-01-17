<?php
namespace App\Service\K1\Product;
use App\Repository\K1\Product\ProductRepo;
use App\Rules\K1\Rules_cek_category_product_id;
use App\Rules\K1\Rules_cek_productId;
use App\Rules\K1\Rules_cek_same_name_product;
use App\Rules\K1\Rules_cek_supplier_id;
use Illuminate\Support\Facades\Validator;

class ProductServiceImplement implements ProductService{

    protected $repository_product;
    
    public function __construct(ProductRepo $repository_product)
    {
        $this->repository_product = $repository_product;
    }

    public function getAllProductService()
    {
        
    }

    public function getProducByIdService($id)
    {
        
    }

    public function postProductService($data)
    {
        $validator = Validator::make($data->all(),[
            'name_product'=> ['required','string', new Rules_cek_same_name_product],
            'expired_date'=> 'date',
            'id_supplier'=> ['required', 'numeric', new Rules_cek_supplier_id],
            'id_category'=> ['required', 'numeric', new Rules_cek_category_product_id],
            'stock'=>['required', 'numeric'],
            'harga_beli'=>['required', 'numeric'],
            'harga_jual'=>['required', 'numeric'],
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }else{
             if (intval($data->harga_beli)> intval($data->harga_jual)) {
                return response()->json([
                    'status'=> 'failed add new product',
                    'msg'=> ' purchase price more than selling price'
                ],400);
             }
             $data->code_product = getLastIdProd().explode(" ",$data->name_product)[0].str_replace('-','',date('Y-m-d')).$data->id_supplier;
             $save = $this->repository_product->postProduct($data);
             return response()->json([
                'status'=> 'ok',
                'data'=> $save
             ],200);
        }
    }

    public function updateProductService($id, $data)
    {
        $validator = Validator::make($data->all(),[
            'id_product' => ['required','numeric', new Rules_cek_productId],
            'name_product'=> ['string'],
            'expired_date'=> 'date',
            'id_supplier'=> [ 'numeric', new Rules_cek_supplier_id],
            'id_category'=> [ 'numeric', new Rules_cek_category_product_id],
            'stock'=>['numeric'],
            'harga_beli'=>[ 'numeric'],
            'harga_jual'=>[ 'numeric'],
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }else{
            if (intval($data->harga_beli) > intval($data->harga_jual)) {
                return response()->json([
                    'status'=> 'failed update product',
                    'msg'=> ' purchase price more than selling price'
                ],400);
            }else{
                $produc_myself = getProductById($id);
                $proudct_name_other = getProductByName($data->name_product);
                $data->code_product = getLastIdProd().explode(" ",$data->name_product)[0].str_replace('-','',date('Y-m-d')).$data->id_supplier;
                if (!empty($data->name_product)) {
                    if ($proudct_name_other != null) {
                        if ($produc_myself->name_product != $proudct_name_other->name_product) {
                            return response()->json([
                                'status'=>'failed update product',
                                'data'=>'name product sudah digunakan',
                            ],404);
                        }else{
                            $update = $this->repository_product->updateProduct($id,$data);
                            return response()->json([
                                'status'=>'update_success',
                                'data'=>$update
                            ],200);
                        }
                    }else{
                        $update = $this->repository_product->updateProduct($id,$data);
                        return response()->json([
                            'status'=>'update_success',
                            'data'=>$update
                        ],200);
                    }
                }else{
                    $update = $this->repository_product->updateProduct($id,$data);
                    return response()->json([
                        'status'=>'update_success',
                        'data'=>$update
                    ],200);
                }
            }
           
        }
    }

    public function deleteProductService($id)
    {
        $validator = Validator::make($id->all(),[
            'id_product' => ['required','numeric', new Rules_cek_productId]
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }else{
            $deleted = $this->repository_product->deleteProduct($id->id_product);
            if ($deleted) {
                return response()->json([
                    'status'=>'deleted_success',
                    'data'=>'deleted'
                ],200);
            }else{
                return response()->json([
                    'status'=>'deleted_failed',
                    'data'=>'query delete product failed'
                ],500);
            }
        }
    }

}