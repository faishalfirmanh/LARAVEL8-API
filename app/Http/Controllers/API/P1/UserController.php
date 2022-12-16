<?php

namespace App\Http\Controllers\API\P1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\P1\UserApi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\API\P1\BaseController as BaseController;

//jwt
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class UserController extends BaseController
{
    //

    public function Login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function Register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',

        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
        return $this->sendResponse($success, 'User register successfully.');
    }

    public function logoutApi(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

		//Request is validated, do logout        
        try {
            JWTAuth::invalidate($request->token);
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function LoginApi(Request $request)
    {
        $email = $request->email;
        $pass = $request->password;
        $search_data = UserApi::query()->where('email',$email)->first();
        $credentials = $request->only('email', 'password');
        $validator = Validator::make($credentials, [
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        if ($search_data != null) {
            if (password_verify($pass, $search_data->password)) {
                //token laravel sanctum 
                //$user = Auth::UserApi(); 
                //$token = $search_data->createToken('myApp')->plainTextToken;
                // $user->createToken('MyApp')->plainTextToken; 

               //jwt
               $myTTL = 360; //minutes expired jwt
               JWTAuth::factory()->setTTL($myTTL);
               try {
                    if (! $token = JWTAuth::attempt($credentials)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Login credentials are invalid.',
                        ], 400);
                    }
                } catch (JWTException $e) {
                return $credentials;
                    return response()->json([
                            'success' => false,
                            'message' => 'Could not create token.',
                        ], 500);
                }
               //jwt
                
                return response()->json([
                    'message' => 'success login',
                    'email'=>$search_data->email,
                    'jwt_token'=>$token,
                    'token_type' => 'Bearer',
                    'id_user'=> $search_data->id,
                ],200);    
            }else{
                return response()->json([
                    'message' => 'failed login'
                ],401);   
            }
        }else{
            return response()->json([
                'message' => 'failed login email not found'
            ],401);   
        }

        // die();
        // return response()->json([
        //     'success' => false,
        //     'message' => 'Email atau Password Anda salah',
        //     'data'=>$search_data,
        //     'hash'=>Hash::make($pass),
        // ], 401);    
    }
}
