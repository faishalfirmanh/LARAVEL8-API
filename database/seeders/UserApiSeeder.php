<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\P1\UserApi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = new UserApi;
        $user->name = "isal";
        $user->email = 'isal@mail.com';
        $user->password =  password_hash('cobak123', PASSWORD_DEFAULT); //Hash::make('cobak123');
        $user->token_login =  Hash::make('cobak123');
        $user->islogin = 0;
        $user->last_login = NULL;
        $user->updated_at = NULL;
        $user->save();

        $user2 = new User;
        $user2->name = "isal";
        $user2->email = 'isal@gmail.com';
        $user2->password =  password_hash('cobak123', PASSWORD_DEFAULT); //Hash::make('cobak123');
        $user2->email_verified_at = date('Y-m-d h:i:sa');
        $user2->save();


    }
}
