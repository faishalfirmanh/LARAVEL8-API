<?php
namespace App\Repository\K1\User;
use App\Models\k1\K1_User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserRepositoryImplement implements UserRepository{

    private $model;

    public function __construct(K1_User $model)
    {
        $this->model = $model;
    }

    public function UserRegister($data)
    {
        $user = $this->model;
        $user->name = $data->name;
        $user->username = $data->name;
        $user->email = $data->email;
        $user->id_role = $data->id_role;
        $user->password = Hash::make($data->password);
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function UserLogin($data)
    {
       
        
    }

    public function getUserByEmail($email)
    {
        return $this->model->where('email',$email)->first();
    }
}