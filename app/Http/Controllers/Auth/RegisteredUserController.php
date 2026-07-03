<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_KEY');

        $response = Http::withHeaders([
            'apikey' => $supabaseKey,
            'Authorization' => 'Bearer ' . $supabaseKey,
            'Content-Type' => 'application/json',
        ])->post($supabaseUrl . '/auth/v1/signup', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->failed()) {
            return back()->withErrors([
                'email' => 'Pendaftaran Supabase Auth Gagal: ' . ($response->json()['msg'] ?? $response->body())
            ]);
        }

        $responseData = $response->json();

        $supabaseId = $responseData['id'] ?? ($responseData['user']['id'] ?? null);

        if (!$supabaseId) {
            return back()->withErrors([
                'email' => 'Sila semak peti masuk emel anda untuk mengesahkan akaun sebelum log masuk.'
            ]);
        }

        $user = User::create([
            'id' => $supabaseId,
            'full_name' => $request->name,
            'email' => $request->email,
            'created_at' => now(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('profile.complete');
    }
}