<?php

namespace App\Http\Controllers;

use App\Dto\AuthDto;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\UserProfileRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function __construct(
        public AuthService $service
    ) {}


    /**
     * @param LoginRequest $request
     * @throws UnauthorizedException
     */
    public function login(LoginRequest $request)
    {
        try {
            $this->service->login(new AuthDto(
                username: $request->username,
                password: $request->password
            ));

            if(Auth::user()->rule == 1) {
                return redirect()->intended('/admin/user');
            }

            return redirect()->intended('home');
        }
        catch (UnauthorizedException $e) {
            return Redirect::back()->withErrors(['message' => $e->getMessage(), 'code' => $e->getCode()]);
        }
    }

    public function logout()
    {
        $this->service->logout();

        return redirect()->route('login');
    }


    public function registration(RegistrationRequest $request)
    {
        try {
            $this->service->registration($request->validated());

            return redirect()->intended('home');
        }
        catch (\Exception $e) {
            return Redirect::back()->withErrors(['message' => $e->getMessage(), 'code' => $e->getCode()]);
        }
    }


    public function profile(UserProfileRequest $request): JsonResponse
    {
        try {
            $result = $this->service->profile($request->validated());
            return response()->success($result);
        }
        catch(\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }
}
