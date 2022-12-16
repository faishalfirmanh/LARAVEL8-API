<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\P1\Category;
class P1_Category_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $category = new Category();
        $category->name = 'Bibit Buah-buahan';
        $category->isActive = '1';
        $category->save();

        $category_2 = new Category();
        $category_2->name = 'Bibit Sayur-Sayuran';
        $category_2->isActive = '1';
        $category_2->save();

        $category_3 = new Category();
        $category_3->name = 'Bibit Palawija';
        $category_3->isActive = '1';
        $category_3->save();
    }
}
