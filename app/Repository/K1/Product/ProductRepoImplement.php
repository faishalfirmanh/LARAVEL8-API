<?php
namespace App\Repository\K1\Product;
use App\Models\k1\K1_Product;
use App\Models\k1\K1_Product_category;
use App\Models\k1\K1_Product_stock;
use App\Models\k1\K1_Product_supplier;

use App\Service\K1\Supplier\SupplierService;

class ProductRepoImplement implements ProductRepo{

    private $model;

    private $service_prod_stock;
    private $service_prod_category;
    private $service_prod_supplier;

    private $model_product_stock;
    private $model_product_supplier;
    private $model_product_category;

    public function __construct(
                K1_Product $model, 
                K1_Product_stock $model_product_stock,
                K1_Product_supplier $model_product_supplier,
                K1_Product_category $model_product_category
                )
    {
        $this->model = $model;
        $this->model_product_stock = $model_product_stock;
        $this->model_product_supplier = $model_product_supplier;
        $this->model_product_category = $model_product_category;
    }
    public function getAllProduct()
    {
        return $this->model->all();
    }
    public function getProductById($id)
    {
        return K1_Product::query()->where('id',$id)->first();
    }

    public function postProduct($data)
    {
        $prod = $this->model;
        $prod->name_product = $data->name_product;
        $prod->expired_date = $data->expired_date;
        $prod->save();

        $prodId = $prod->id;
        $prod_stock = $this->model_product_stock;
        $prod_stock->id_product = $prodId;
        $prod_stock->stock = $data->stock;
        $prod_stock->harga_jual = $data->harga_jual;
        $prod_stock->harga_beli = $data->harga_beli;
        $save_product_stock = $prod_stock->save();

        $supplier = $this->model_product_supplier;
        $supplier->id_product = $prodId;
        $supplier->id_supplier = $data->id_supplier;
        $supplier->save();

        $product_category = $this->model_product_category;
        $product_category->id_product = $prodId;
        $product_category->id_category = $data->id_category;
        $product_category->save();
        return $prod->fresh();
    }

    public function updateProduct($id, $data)
    {
        
    }

    public function deleteProduct($id)
    {
        
    }
}