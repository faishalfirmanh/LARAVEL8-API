<?php

namespace App\Service\K1\SettingPromoService;

interface SettingService{
    public function GetSettingServiceById($id);
    public function UpdateSettingService($data);
}