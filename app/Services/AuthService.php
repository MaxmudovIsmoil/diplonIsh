<?php

namespace App\Services;

use App\Dto\AuthDto;
use App\Exceptions\UnauthorizedException;
use App\Models\User;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    use FileTrait;

    public function login(AuthDto $dto): bool
    {
        $credentials = [
            'username' => strtolower($dto->username),
            'password' => $dto->password
        ];

        if (! Auth::attempt($credentials)) {
            throw new UnauthorizedException(message: trans('admin.Login or password error'), code: 401);
        }

        return true;
    }


    public function logout()
    {
        Auth::logout();
    }

    public function registration(array $data): bool
    {
        $user = User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'rule' => 1,
            'username' => $data['username'],
            'password' => $data['password']
        ]);

        Auth::login($user);

        return true;
    }

    public function profile(array $data)
    {
        $userId = Auth::id();
        $user = User::findOrfail($userId);
        if (isset($data['photo'])) {
            $this->fileDelete('photo/'.$user->photo);
            $user->fill(['photo' => $this->fileUpload($data['photo'])]);
        }
        if (isset($data['password'])) {
            $user->fill(['password' => Hash::make($data['password'])]);
        }
        $user->fill([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'username' => $data['username']
        ]);
        $user->save();
        return $userId;
    }
}
