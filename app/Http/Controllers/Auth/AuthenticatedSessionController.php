<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_KEY');

        $response = Http::withHeaders([
            'apikey' => $supabaseKey,
            'Authorization' => 'Bearer ' . $supabaseKey,
            'Content-Type' => 'application/json',
        ])->post($supabaseUrl . '/auth/v1/token?grant_type=password', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->failed()) {
            return back()->withErrors([
                'email' => 'The login information entered is incorrect or does not match.',
            ]);
        }

        $responseData = $response->json();
        $supabaseId = $responseData['user']['id'] ?? null;

        if (!$supabaseId) {
            return back()->withErrors([
                'email' => 'Failed to extract user data from Supabase.',
            ]);
        }

        $user = User::find($supabaseId);

        if (!$user) {
            $user = User::create([
                'id' => $supabaseId,
                'full_name' => $responseData['user']['user_metadata']['full_name'] ?? 'User',
                'email' => $request->email,
            ]);
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function destroy(Request $request): RedirectResponse
{
    Auth::guard('web')->logout();

    $request->session()->forget([
        'admin_logged_in',
        'admin_id',
        'admin_email',
        'admin_name',
        'user_logged_in',
        'user_id',
        'user_email',
        'user_name',
    ]);

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect()->route('login');
}
}