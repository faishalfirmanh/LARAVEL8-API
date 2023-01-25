<?php

namespace Database\Seeders\k1;

use Illuminate\Database\Seeder;
use App\Models\k1\K1_User;
use Illuminate\Support\Facades\Hash;
class K1_User_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user1 = new K1_User();
        $user1->name = env('user_admin_name');
        $user1->username = explode(" ",env('user_admin_name'))[0].'_'.getLastIdUser_k1();
        $user1->email = env('user_admin_email');
        $user1->id_role = env('user_id_role');
        $user1->password = Hash::make(env('user_admin_password'));
        $user1->save();
    }
}
