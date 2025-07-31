<?php

namespace App\Http\Controllers\Schools\v1\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Service\auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    private $auth;
    public function __construct(AuthService $service)
    {

        return $this->auth = $service;
    }

    // login in the dash as school 
    public function login(LoginRequest $request)
    {
        return $this->auth->login($request);
    }

    
    public function profile()
    {
       return $this->auth->profile();
    }


    // logout from dash
    public function logout(Request $request)
    {
        return $this->auth->logout($request);
    }
}
