<?php

namespace Database\Seeders;

use App\Models\k1\K1_Supplier;
use Illuminate\Database\Seeder;

class K1_Supplier_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $sup_1 = new K1_Supplier();
        $sup_1->name = 'budi npk testing_1';
        $sup_1->phone_number = '08123456789';
        $sup_1->name_pt = 'PT Meroke Majemuk Fertilizer';
        $sup_1->save();

        $sup_2 = new K1_Supplier();
        $sup_2->name = 'kusnaini giling padi testing_1';
        $sup_2->phone_number = '0912212122';
        $sup_2->name_pt = 'PT. SURYA AGRO MANDIRI';
        $sup_2->save();

        $sup_3 = new K1_Supplier();
        $sup_3->name = 'supri petro testing_1';
        $sup_3->phone_number = '08234121342';
        $sup_3->name_pt = 'PT. Petrokimia Gersik';
        $sup_3->save();
    }
}
