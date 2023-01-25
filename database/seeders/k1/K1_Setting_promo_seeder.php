<?php

namespace Database\Seeders\k1;

use Illuminate\Database\Seeder;
use App\Models\k1\K1_Setting_promo_transaction;
class K1_Setting_promo_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new K1_Setting_promo_transaction();
        $setting->price_min = 150000;
        $setting->expired_voucher = 30;
        $setting->is_active = 1;
        $setting->save();
    }
}
