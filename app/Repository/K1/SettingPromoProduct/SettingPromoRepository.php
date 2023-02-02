<?php
namespace App\Repository\K1\SettingPromoProduct;

interface SettingPromoRepository{
    public function GetSettingById($id);
    public function UpdateSettingPromoById($data);
}