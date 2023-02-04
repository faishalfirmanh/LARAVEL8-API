<?php

namespace App\Http\Controllers\API\K1;

use App\Http\Controllers\Controller;
use App\Models\k1\K1_Product;
use Illuminate\Support\Facades\Validator;
use App\Models\k1\K1_Product_supplier;
use App\Models\P1\Product;
use Illuminate\Http\Request;
use App\Service\K1\Product\ProductService;

class ProductControllerK1 extends Controller
{
    //
    private $service_product;
    public function __construct(ProductService $service_product)
    {
        $this->service_product = $service_product;
    }
    public function getAllProduct_con(Request $request){
       return $this->service_product->getAllProductServiceAndSearch($request);
    }

    public function GetAllProductPaginate_con(Request $request)
    {
        return $this->service_product->getProductServicePaginate($request);
    }

    /**-- for ajax when onchange value */
    public function GetRecomentInputPriceSell_con(Request $request){
        $percent_setting = cekSettingVoucer()->percent_set_minimum_sell;
        $validator = Validator::make($request->all(),[
            'harga_beli'=> 'required|numeric',
        ]);
        $recoment = (($percent_setting /100) * $request->harga_beli)+$request->harga_beli;
        if ($validator->fails()) {
            return $validator->errors();
        }
        return response()->json([
            'percent'=>$percent_setting,
            'price_sell_minimum'=>number_format($recoment)
        ],200);
    }
    
    public function getProductById_con(Request $request){
        return $this->service_product->getProducByIdService($request);
    }

    public function postProduct_con(Request $request){
        return $this->service_product->postProductService($request);
    }

    public function updateProduct_con(Request $request){
        $id = $request->id_product;
        return $this->service_product->updateProductService($id, $request);
    }

    public function deleteProduct_con(Request $request){
        return $this->service_product->deleteProductService($request);
    }
}
