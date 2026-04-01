<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $user = User::create($request->only(['userid', 'name', 'email', 'password']));

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('books.index')->with('success', '会員登録が完了しました。');
    }
}
