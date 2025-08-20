<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login()
    {
        return view('login'); 
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $credentials['email'] = strtolower($credentials['email']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard'); // hoặc route('dashboard')
        }

        return back()->withErrors([
        'email' => 'Email hoặc mật khẩu không đúng.',
    ])->onlyInput('email');
    }
}
