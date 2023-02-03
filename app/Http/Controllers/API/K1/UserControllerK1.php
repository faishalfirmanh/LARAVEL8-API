<?php

namespace App\Http\Controllers\API\K1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\K1\K1_User;
use App\Service\K1\User\UserService;

class UserControllerK1 extends Controller
{
    //
    private $service_user;
    public function __construct(UserService $service_user)
    {
        $this->service_user = $service_user;
    }

    public function getUserByIdCon(Request $request)
    {
        
    }

    public function RegisterUserCon(Request $request)
    {
        return $this->service_user->UserRegisterService($request);
    }

    public function LoginUserCon(Request $request)
    {
        return $this->service_user->UserLoginService($request);
    }

    public function LogoutUserCon(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}
