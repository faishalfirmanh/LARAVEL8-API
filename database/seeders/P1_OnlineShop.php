<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\P1\OnlineShop;

class P1_OnlineShop extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $onlin = new OnlineShop();
        $onlin->name = "Bukalapak";
        $onlin->isActive = '1';
        $onlin->save();

        $onlin_2 = new OnlineShop();
        $onlin_2->name = "Tokopedia";
        $onlin_2->isActive = '1';
        $onlin_2->save();

        $onlin_3 = new OnlineShop();
        $onlin_3->name = "Shopee";
        $onlin_3->isActive = '1';
        $onlin_3->save();
    }
}
