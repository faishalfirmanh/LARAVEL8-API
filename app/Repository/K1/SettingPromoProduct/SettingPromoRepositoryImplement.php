<?php


namespace App\Repository\K1\SettingPromoProduct;
use App\Models\k1\K1_Setting_promo_transaction;


class SettingPromoRepositoryImplement implements SettingPromoRepository{

    private $model;

    public function __construct(K1_Setting_promo_transaction $model)
    {
        $this->model = $model;
    }
    
    public function GetSettingById($id)
    {
        $find_data = $this->model->where('id',$id)->first();
        return $find_data;
    }

    public function UpdateSettingPromoById($data)
    {
        $find_data = $this->model->where('id',$data->id_setting)->first();
        $find_data->price_min = $data->price_min;
        $find_data->expired_voucher  = $data->expired_voucher_date;
        $find_data->is_active = $data->is_active;
        $find_data->percent_set_minimum_sell  = $data->percent_set_minimum_sell;
        $find_data->promo_percent = $data->promo_percent;
        $find_data->save();
        return $find_data->fresh();
    }

}