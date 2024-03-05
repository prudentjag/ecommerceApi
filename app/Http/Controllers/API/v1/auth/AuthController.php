<?php

namespace App\Http\Controllers\API\v1\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Http\Requests\registration;
use Illuminate\Support\Facades\Hash;
use App\Http\Response;

class AuthController extends Controller
{
    public function register(registration $request){
        $data = $request->validated();
        $userData = array_merge($data, ['role' => $data['role'] ?? 'user']);

        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'phone'=> $userData['phone'],
            'password' => Hash::make($userData['password']),
        ]);

        $token = $user->createToken('my-token')->plainTextToken;
        return response()->json([
            'message' => 'User Created',
            'token' =>$token,
            'Type' => 'Bearer'
        ], Response::HTTP_CREATED);

    }

    public function login(LoginRequest $request){
        $loginUserData = $request->validated();
          $user = User::where('email', $loginUserData['email'])
                    ->orWhere('phone', $loginUserData['email'])
                    ->first();
        if(!$user || !Hash::check($loginUserData['password'],$user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        return response()->json([
            'token' => $token,
            'Type' => 'Bearer',
            'user'=>$user,
            'role' => $user->role
        ]);
    }

    public function logout(){
        if (auth()->user()) {
            auth()->user()->tokens()->delete();

            return response()->json([
                "message" => "Logged out"
            ]);
        } else {
            return response()->json([
                "message" => "No user is currently authenticated"
            ], 401);
        }
    }

    public function getUsers()
    {
        $users = User::all();
        return response()->json(['message' => $users],Response::HTTP_OK);
    }

        public function getUser(int $id)
    {
        $users = User::find($id);
        return response()->json(['message' => $users],Response::HTTP_OK);
    }

    public function deletUser($id)
    {
        $user = User::find($id);
        if($user->delete()){
            return response()->json(['message' => "User deleted successfully"], Response::HTTP_OK);
        }else{
            return response()->json(['error' => "Couldnt Delete User"], Response::HTTP_BAD_REQUEST);
        };
    }


}
