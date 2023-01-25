<?php

namespace App\Repository\K1\ProductStock;
use App\Models\k1\K1_Product_stock;
use App\Repository\K1\ProductStock\ProductStockRepo;
class ProductStockRepoImplement implements ProductStockRepo{
    
    private $model;
    public function __construct(K1_Product_stock $model)
    {
        $this->model = $model;
    }

    public function getAllProductStockRepo()
    {
        
    }

    public function getProductStockByIdRepo($idProduct)
    {
        return $this->model->where('id_product',$idProduct)->first();
    }

    public function postProductStockRepo($data)
    {
        $new_stock_prod = $this->model;
        $new_stock_prod->id_product = $data->idProd;
        $new_stock_prod->stock = $data->stock;
        $new_stock_prod->harga_beli = $data->harga_beli;
        $new_stock_prod->harga_jual = $data->harga_jual;
        return $new_stock_prod->save();
    }

    public function updateProductStockRepo($idProduct, $data)
    {
        $find = $this->model->query()->where('id_product',$idProduct)->first();
        $find->stock = $data;
        $find->save();
        return $find->fresh();
    }

    public function deleteProductStockRepo($idProduct)
    {
        
    }

}