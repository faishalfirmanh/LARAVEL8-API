<?php

namespace App\Service\K1\SettingPromoService;

use App\Repository\K1\SettingPromoProduct\SettingPromoRepository;

class SettingServiceImplement implements SettingService{

    protected $repository_setting;
    public function __construct(SettingPromoRepository $repository_setting)
    {
        $this->repository_setting = $repository_setting;
    }

    public function GetSettingServiceById($id)
    {
        $data = $this->repository_setting->GetSettingById($id->id_setting);
        if ($data != null) {
            return response()->json([
                'status'=>'ok',
                'data'=>[
                    'status_promo'=>$data->is_active,
                    'price'=>'Rp '.number_format($data->price_min),
                    'expired_voucher_in_day'=> $data->expired_voucher . ' hari',
                    'percent_min'=>$data->percent_set_minimum_sell . ' %',
                    'promo_percent'=>$data->promo_percent .' %',
                ]
            ],200);
        }else{
            return response()->json([
                'status'=>'error',
                'data'=>$data,
                'msg'=>'data not found'
            ],404);
        }
       
    }

    public function UpdateSettingService($data)//masih belum ada validasi
    {
        $update = $this->repository_setting->UpdateSettingPromoById($data);
        return response()->json([
            'status'=>'ok',
            'msg'=>'update successfully',
            'data'=>[
                'price'=>number_format($update->price_min),
                'expired_voucher_in_day'=> $update->expired_voucher . ' hari',
                'percent_min'=>$update->percent_set_minimum_sell . ' %',
                'promo_percent'=>$update->promo_percent .' %',
            ]
        ],200);
    }
}