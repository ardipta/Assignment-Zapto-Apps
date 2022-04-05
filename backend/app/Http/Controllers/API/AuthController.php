<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $tokenValidity = 24 * 60;
        $this->guard()->factory()->setTTL($tokenValidity);
        if(!$token=$this->guard()->attempt($validator->validated())){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $user=User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->input('password'))]
        ));
        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'user'=> $user
        ]);
    }
    public function logout(): JsonResponse
    {
        $this->guard()->logout();
        return response()->json(['message' => 'User Logout Successful']);
    }
    public function profile(): JsonResponse
    {
        return response()->json($this->guard()->user());
    }
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'status' => true,
            'token' => $token,
            'token_type' => 'bearer',
            'token_validity' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    protected function guard(){
        return Auth::guard();
    }
}
