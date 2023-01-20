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
        $user1->name = 'admin';
        $user1->username = 'admin123';
        $user1->email = 'admin123@mail.com';
        $user1->id_role = 1;
        $user1->password = Hash::make('admin123');
        $user1->save();
    }
}
