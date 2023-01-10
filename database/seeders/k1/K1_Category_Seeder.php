<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\k1\K1_Category;
class K1_Category_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $category = new K1_Category();
        $category->name_category = 'Pestisida';
        $category->save();

        $category_2 = new K1_Category();
        $category_2->name_category = 'Pupuk';
        $category_2->save();

        $category_3 = new K1_Category();
        $category_3->name_category = 'Alat';
        $category_3->save();
    }
}
