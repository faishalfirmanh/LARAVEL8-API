<?php
namespace App\Service\K1\Product;
use App\Repository\K1\Product\ProductRepo;
use App\Repository\K1\ProductCategory\ProductCategoryRepo;
use App\Repository\K1\ProductStock\ProductStockRepo;
use App\Repository\K1\ProductSuppRelations\ProductSupRepo;
use App\Rules\K1\Rules_cek_category_product_id;
use App\Rules\K1\Rules_cek_productId;
use App\Rules\K1\Rules_cek_same_name_product;
use App\Rules\K1\Rules_cek_supplier_id;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class ProductServiceImplement implements ProductService{

    protected $repository_product;
    protected $repository_product_stock;
    protected $repository_prod_supplier;
    protected $repository_prod_category;
    public function __construct(
        ProductRepo $repository_product,
        ProductStockRepo $repository_product_stock,
        ProductSupRepo $repository_prod_supplier,
        ProductCategoryRepo $repository_prod_category){

        $this->repository_product = $repository_product;
        $this->repository_product_stock = $repository_product_stock;
        $this->repository_prod_supplier = $repository_prod_supplier;
        $this->repository_prod_category = $repository_prod_category;
    }

    public function getAllProductServiceAndSearch($search)
    {  
        if (empty($search->keyword)) {
            $data = $this->repository_product->getAllProduct();
        }else{
           $data =  $this->repository_product->getProductSearch($search->keyword);
        }
       
        $array_product = array();
        $i = 0;
        foreach ($data as $key) {
            unset($key->created_at);
            unset($key->updated_at);
            $array_product[$i]["id_product"] = $key->id;
            $array_product[$i]["name_product"] = $key->name_product;
            $array_product[$i]["total_stock"] =  $key->stockProduct->stock;
            $array_product[$i]["price_buy"] = number_format($key->stockProduct->harga_jual);
            $array_product[$i]["price_sell"] = number_format($key->stockProduct->harga_beli);
            $array_product[$i]["category"] = $key->categoryProduct[0]->name_category;
            $array_product[$i]["name_supplier"] = $key->supplierProduct[0]->name;
            $i++;
        }
        return response()->json([
            'status'=>count($array_product) > 0 ? 'ok' : 'empty',
            'data'=>count($array_product) > 0 ? $array_product : 'empty'
        ],count($array_product) > 0 ? 200 : 403);
    }

    public function getProductServicePaginate($page)
    {
        $page_input = $page->page == null ? 1 : $page->page;
        $limit = 10;
        $all_data = $this->repository_product->getAllProduct();
        $data_paginate = $this->repository_product->getProductPaginate($limit);
        $total_page = ceil((count($all_data) / $limit));
        $i = 0;
        $array_product = array();
        foreach ($data_paginate as $key) {
            unset($key->created_at);
            unset($key->updated_at);
            $array_product[$i]["id_product"] = $key->id;
            $array_product[$i]["name_product"] = $key->name_product;
            $array_product[$i]["total_stock"] =  $key->stockProduct->stock;
            $array_product[$i]["price_buy"] = number_format($key->stockProduct->harga_jual);
            $array_product[$i]["price_sell"] = number_format($key->stockProduct->harga_beli);
            $array_product[$i]["category"] = $key->categoryProduct[0]->name_category;
            $array_product[$i]["name_supplier"] = $key->supplierProduct[0]->name;
            $i++;
        }
        $next_url = $page_input < $total_page ? url()->current().'?page='.intval($page_input+1) : null;
        $prev_url = $page_input > 1  ? url()->current().'?page='.intval($page_input-1) : null;
        return response()->json([
            'status'=>count($array_product) > 0 ? 'ok' : 'empty',
            'data'=>count($array_product) > 0 ? $array_product : 'empty',
            'data_pagination'=>[
                'current_data_show'=>count($data_paginate),
                'total_data'=>count($all_data),
                'perpage_or_limit'=>intval($limit),
                'current_page'=>intval($page_input),
                'total_page'=>$total_page,
                'next_url'=> $next_url,
                'prev_url'=>$prev_url
            ]
        ],count($array_product) > 0 ? 200 : 404);

    }

    public function getProducByIdService($id)
    {
        $validator = Validator::make($id->all(),[
            'id_product' => ['required','numeric', new Rules_cek_productId],
        ]);

        if ($validator->fails()) {
           return $validator->errors();
        }else{
            $data = $this->repository_product->getProductById($id->id_product);
            return response()->json([
                'product'=>$data,
                'data'=>[
                    'detail_product'=>$data->stockProduct,
                    'data_supplier'=>$data->supplierProduct[0],
                    'category'=>$data->categoryProduct[0]
                ]
            ]);
        }
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
            /**-- validasi set minimum price sell */
            $net_profit_by_setting = (cekSettingVoucer()->percent_set_minimum_sell / 100) * $data->harga_beli;
            $profit_minimum = intval($net_profit_by_setting + $data->harga_beli);
            if (cekSettingVoucer()->percent_set_minimum_sell != NULL || cekSettingVoucer()->percent_set_minimum_sell > 0) {
                if ($data->harga_jual < $profit_minimum) {
                    return response()->json([
                        'status'=> 'failed add new product',
                        'msg'=> 'harga jual bermasalah',
                        'harga_yang_diset'=> number_format($data->harga_jual),
                        'harga_jual_minimum'=>number_format($profit_minimum)
                    ],400);
                }
            }
            /**-- validasi set minimum price sell */
            /**--save to db */
            $idProd_save = $this->repository_product->postProduct($data);
            $data->idProd = $idProd_save;
            $save_prod_stock = $this->repository_product_stock->postProductStockRepo($data);
            $save_prod_supplier = $this->repository_prod_supplier->postProductSuppRelations($data);
            $save_prod_category = $this->repository_prod_category->PostProductCategory($data);
            /**--save to db */
            /**--response status kurang menampilkan data yang baru ditambahkan*/
             return response()->json([
                'status'=> 'ok',
                'idProd'=>$idProd_save
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