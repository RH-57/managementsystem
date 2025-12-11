<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $maxAttempts = 5; // Maximum number of attempts
    protected $decayMinutes = 1; // Time in minutes

    public function showLoginForm() {
        // Jika sudah login, redirect ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboards.index');
        }

        return view('admin.login');
    }

    public function login(Request $request) {
        // Cek rate limiting
        if ($this->tooManyAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Reset attempt login yang berhasil
            $this->clearAttempts($request);

            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboards');
        }

        // Tambah attempt yang gagal
        $this->incrementAttempts($request);

        return back()->withErrors([
            'email' => 'Email atau Password salah !',
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/manage-cms')->with('success', 'Logout Successfully');
    }

    /**
     * Method untuk rate limiting yang lebih sederhana
     */
    protected function tooManyAttempts(Request $request)
    {
        return app(RateLimiter::class)->tooManyAttempts(
            $this->throttleKey($request),
            $this->maxAttempts
        );
    }

    protected function incrementAttempts(Request $request)
    {
        app(RateLimiter::class)->hit(
            $this->throttleKey($request),
            $this->decayMinutes * 60
        );
    }

    protected function clearAttempts(Request $request)
    {
        app(RateLimiter::class)->clear($this->throttleKey($request));
    }

    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = app(RateLimiter::class)->availableIn(
            $this->throttleKey($request)
        );

        return back()->withErrors([
            'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
        ])->onlyInput('email');
    }
}
