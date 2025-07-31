<?php

namespace App\Http\Service\auth;

use App\Http\Resources\auth\LoginResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService{
     public function login( $request)
    {
        $validated = $request->validated();

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json('Invalid credentials', 401);
        }

        $user = User::where('email', $validated['email'])->first();

        $tokenName = 'API Token for ' . $user->email;

       $token = $user->createToken($tokenName)->plainTextToken;
        return response()->json([
            'user'=>new LoginResource($user),
            'token'=>$token
        ],200);
    }


    
    public function profile(){
        return response()->json([
            'profile'=>Auth::user()
        ]);
    }

public function logout($request)
{
 
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'تم تسجيل الخروج بنجاح',
    ], 200);
}

}