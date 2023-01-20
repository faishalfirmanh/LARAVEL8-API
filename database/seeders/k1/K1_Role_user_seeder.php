<?php

namespace Database\Seeders\k1;

use Illuminate\Database\Seeder;
use App\Models\k1\K1_Role_user;

class K1_Role_user_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role1 = new K1_Role_user;
        $role1->name = 'Admin';
        $role1->save();

        $role2 = new K1_Role_user;
        $role2->name = 'Employee';
        $role2->save();
    }
}
