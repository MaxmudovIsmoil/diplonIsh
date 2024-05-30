<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function lang(string $lang)
    {
        $userId = Auth::id();
        Session::put('lang', $lang);
        App::setLocale($lang);
        User::findOrfail($userId)->update(['locale' => $lang]);

        return redirect()->back();
    }
}
