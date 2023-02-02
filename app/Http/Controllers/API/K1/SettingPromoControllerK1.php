<?php

namespace App\Http\Controllers\API\K1;

use App\Http\Controllers\Controller;
use App\Http\Requests\K1_SettingVoucherRequest;
use Illuminate\Http\Request;
use App\Service\K1\SettingPromoService\SettingService;
class SettingPromoControllerK1 extends Controller
{
    //

    private $setting_service;
    public function __construct(SettingService $setting_service)
    {
        $this->setting_service = $setting_service;
    }
    public function GetSettingPromoCon(Request $request)
    {
        $data = $this->setting_service->GetSettingServiceById($request);
        return $data;
    }

    public function UpdateSettingPromoCon(K1_SettingVoucherRequest $request)
    {
        $data = $this->setting_service->UpdateSettingService($request);
        return $data;
    }
}
