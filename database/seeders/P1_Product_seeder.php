<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\P1\Product;
class P1_Product_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $prod = new Product;
        $prod->name_product = 'Sepatu bola';
        $prod->picture = 'tes.jpg';
        $prod->price = 190000;
        $prod->save();

        $prod = new Product;
        $prod->name_product = 'Jersey Manchester United';
        $prod->picture = 'mu.jpg';
        $prod->price = 250000;
        $prod->save();

        $prod = new Product;
        $prod->name_product = 'Kipas angin';
        $prod->picture = 'tes.jpg';
        $prod->price = 500000;
        $prod->save();

    }
}
