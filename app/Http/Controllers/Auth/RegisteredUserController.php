<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 🔽 Ghi dữ liệu vào file index.json
        $this->saveUserToIndex($user);

        event(new Registered($user));

        return redirect()->intended(route('users.index', absolute: false));
    }

    /**
     * Save user info to index.json file.
     */
    protected function saveUserToIndex(User $user): void
    {
        $path = storage_path('app/index.json');

        // Lấy dữ liệu đã tồn tại (nếu có)
        $existing = file_exists($path) ? json_decode(file_get_contents($path), true) : [];

        // Thêm người dùng mới
        $existing[] = [
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => now()->toDateTimeString(),
        ];

        // Ghi lại vào file index.json
        file_put_contents($path, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
