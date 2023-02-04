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

    public function getProductSearch($keyword)
    {
        $all_data = $this->model
        ->join('k1_product_category','k1_product_category.id_product','=','k1_product.id')
        ->join('k1_category','k1_category.id','=','k1_product_category.id_category')
        ->join('k1_product_supplier','k1_product_supplier.id_product','=','k1_product.id')
        ->join('k1_supplier','k1_supplier.id','=','k1_product_supplier.id_supplier')
        ->join('k1_product_stock','k1_product_stock.id_product','=','k1_product.id')
        /**->where(function($query)use ($keyword) {
            $query->where('k1_product.name_product','like','%'.$keyword.'%')
            ->orWhere('k1_category.name_category','like','%'.$keyword.'%')
            ->orWhere('k1_supplier.name','like','%'.$keyword.'%');
        })*/ 
        /** --semua dari name_supplier,name_product,category, tapi semuag tabel harus terisi */
        ->where('k1_product.name_product','like','%'.$keyword.'%') /** name product saja */
        ->get();
        return $all_data;
    }

    public function getProductById($id)
    {
        return K1_Product::query()->where('id',$id)->select('id','name_product','expired_date')->first();
    }

    public function postProduct($data)
    {
        $prod = $this->model;
        $prod->name_product = $data->name_product;
        $prod->expired_date = $data->expired_date;
        $prod->kode_product = $data->code_product;
        $prod->save();
        return $prod->id;
        /**------awal di jadikan 1 */
        // $prod_stock = $this->model_product_stock;
        // $prod_stock->id_product = $prodId;
        // $prod_stock->stock = $data->stock;
        // $prod_stock->harga_jual = $data->harga_jual;
        // $prod_stock->harga_beli = $data->harga_beli;
        // $save_product_stock = $prod_stock->save();

        // $supplier = $this->model_product_supplier;
        // $supplier->id_product = $prodId;
        // $supplier->id_supplier = $data->id_supplier;
        // $supplier->save();

        // $product_category = $this->model_product_category;
        // $product_category->id_product = $prodId;
        // $product_category->id_category = $data->id_category;
        // $product_category->save();
       
    }

    public function updateProduct($id, $data)
    {
        $prod = $this->model->where('id',$id)->first();
        $prod->name_product = cekInputNameProd($prod, $data->name_product);
        if (!empty( $data->name_product))
            $prod->kode_product = $data->code_product;
        $prod->expired_date = cekExpiredProd($prod, $data->expired_date);
        $prod->save();

        $relation_cateogry = $this->model_product_category->where('id_product',$id)->first();
        $relation_cateogry->id_category = cekInputCategoryProd($relation_cateogry,$data->id_category);
        $relation_cateogry->save();

        $relation_supp = $this->model_product_supplier->where('id_product',$id)->first();
        $relation_supp->id_supplier = cekInputSupplierProd($relation_supp, $data->id_supplier);
        $relation_supp->save();

        $relation_stock = $this->model_product_stock->where('id_product',$id)->first();
        $relation_stock->stock = cekInputStockProd($relation_stock, $data->stock);
        $relation_stock->harga_beli = cekInputHargaBeli($relation_stock, $data->harga_beli);
        $relation_stock->harga_jual = cekInputHargaJual($relation_stock, $data->harga_jual);
        $relation_stock->save();
        return true;
    }

    public function deleteProduct($id)
    {
        $prod = $this->model->find($id);
        $prod->delete();
        $category = $this->model_product_category->where('id_product',$id)->first();
        $category->delete();
        $supp = $this->model_product_supplier->where('id_product',$id)->first();
        $supp->delete();
        $stock = $this->model_product_stock->where('id_product',$id)->first();
        $stock->delete();
        return true;
    }
}