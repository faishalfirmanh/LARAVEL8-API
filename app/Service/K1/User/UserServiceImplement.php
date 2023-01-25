<?php

namespace App\Service\K1\User;

use App\Models\K1\K1_User;
use App\Repository\K1\User\UserRepository;
use App\Rules\K1\Rules_cek_email_user;
use App\Rules\K1\Rules_cek_role_user;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserServiceImplement implements UserService{

    protected $UserRepositry;
    public function __construct(UserRepository $UserRepositry)
    {
        $this->UserRepositry = $UserRepositry;
    }

    public function UserRegisterService($data)
    {
        $validator = Validator::make($data->all(),[
            'name'=> 'string',//
            'email'=> 'required|unique:k1_user',
            'id_role'=> ['required','numeric',new Rules_cek_role_user], //
            'password'=> 'required|min:8',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }else{
           return $this->UserRepositry->UserRegister($data);
        }
    }

    public function UserLoginService($data)
    {
        $validator = Validator::make($data->all(),[
            'email'=> ['required', new Rules_cek_email_user],
            'password'=> 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }else{
            $cek_email = $this->UserRepositry->getUserByEmail($data->email);
            if (password_verify($data->password, $cek_email->password)) {
                $token = $cek_email->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'message' => 'Login success',
                    'token'=> $token,
                    'token_type' => 'Bearer',
                    'email_user'=>$data->email,
                    'id_user'=>$cek_email->id,
                    'role_user'=> $cek_email->getRoleUser
                ],200);
            }else{
                return response()->json([
                    'message' => 'Login failed',
                    'msg' => 'password is incorrect'
                ],401);
            }
        }
    }


}