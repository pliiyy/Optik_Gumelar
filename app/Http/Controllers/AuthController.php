<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class AuthController extends Controller
{
    // Proses login
    public function showLogin(Request $request) {
        if (Auth::check()) {
        return redirect()->intended('/dashboard');
    }
        return view('login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function redirectToGoogle()
    {
        if (! $this->googleIsConfigured()) {
            return redirect()->route('login')->withErrors([
                'google' => 'Login Google belum dikonfigurasi. Hubungi administrator.',
            ]);
        }

        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        if (! $this->googleIsConfigured()) {
            return redirect()->route('login')->withErrors([
                'google' => 'Login Google belum dikonfigurasi. Hubungi administrator.',
            ]);
        }

        if ($request->query('error')) {
            return redirect()->route('login')->withErrors([
                'google' => 'Login Google dibatalkan atau tidak dapat diselesaikan. Silakan coba lagi.',
            ]);
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (InvalidStateException $exception) {
            report($exception);

            return redirect()->route('login')->withErrors([
                'google' => 'Sesi login Google tidak valid. Silakan coba lagi.',
            ]);
        }

        $googleData = $googleUser->user;
        $email = $googleUser->getEmail();

        if (! $email || ! filter_var($email, FILTER_VALIDATE_EMAIL) || ! ($googleData['verified_email'] ?? false)) {
            return redirect()->route('login')->withErrors([
                'google' => 'Google tidak memberikan alamat email terverifikasi. Silakan gunakan metode login lain.',
            ]);
        }

        $user = User::where('google_id', $googleUser->getId())->first();

        if (! $user) {
            $user = User::where('email', $email)->first();
        }

        if ($user) {
            if ($user->google_id && $user->google_id !== $googleUser->getId()) {
                return redirect()->route('login')->withErrors([
                    'google' => 'Email ini sudah terhubung dengan akun Google lain.',
                ]);
            }

            $user->forceFill([
                'google_id' => $googleUser->getId(),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();
        } else {
            $user = User::create([
                'name' => $googleUser->getName() ?: $email,
                'email' => $email,
                'google_id' => $googleUser->getId(),
                'email_verified_at' => now(),
                'password' => Str::random(64),
                'role' => 'PELANGGAN',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'PELANGGAN',
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    // Proses logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    private function googleIsConfigured(): bool
    {
        return filled(config('services.google.client_id'))
            && filled(config('services.google.client_secret'))
            && filled(config('services.google.redirect'));
    }
}