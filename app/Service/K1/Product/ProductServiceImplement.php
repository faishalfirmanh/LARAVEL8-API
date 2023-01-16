<?php
namespace App\Service\K1\Product;
use App\Repository\K1\Product\ProductRepo;
use App\Rules\K1\Rules_cek_category_product_id;
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
            'name_product'=> 'required|string',
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
             $save = $this->repository_product->postProduct($data);
             return response()->json([
                'status'=> 'ok',
                'data'=> $save
             ],200);
        }
    }

    public function updateProductService($id, $data)
    {
        
    }

    public function deleteProductService($id)
    {
        
    }

}