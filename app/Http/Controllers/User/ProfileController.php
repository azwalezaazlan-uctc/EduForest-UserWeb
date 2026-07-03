<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name'     => 'required|string|max:255',
            'phone_number'  => 'nullable|string|max:20',
            'user_category' => 'nullable|string|max:255',
            'origin'        => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profile = DB::table('profiles')->where('id', Auth::id())->first();
        $imageUrl = $profile->profile_image_url ?? null;

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');

            $fileContent = file_get_contents($file->getRealPath());
            $mimeType = $file->getClientMimeType();
            $fileName = 'user_' . Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();

            $supabaseUrl = env('SUPABASE_URL');
            $supabaseKey = env('SUPABASE_KEY');

            if ($supabaseUrl && $supabaseKey) {
                $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $supabaseKey,
                'apikey'        => $supabaseKey,
                'Content-Type'  => $mimeType,
                'x-upsert'      => 'true',
            ])->withBody($fileContent, $mimeType)
            ->post($supabaseUrl . '/storage/v1/object/profile-images/' . $fileName);

if ($response->successful()) {
    $imageUrl = $supabaseUrl . '/storage/v1/object/public/profile-images/' . $fileName;
} else {
    return back()->withErrors([
        'profile_image' => 'Gambar gagal upload ke Supabase. Pastikan bucket profile-images wujud dan public.'
    ])->withInput();
}

                if ($response->successful()) {
                    $imageUrl = $supabaseUrl . '/storage/v1/object/public/profile-images/' . $fileName;
                }
            }
        }

        DB::table('profiles')->updateOrInsert(
            ['id' => Auth::id()],
            [
                'full_name'         => $request->full_name,
                'phone_number'      => $request->phone_number,
                'user_category'     => $request->user_category,
                'origin'            => $request->origin,
                'profile_image_url' => $imageUrl,
                'updated_at'        => now(),
            ]
        );

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required'],
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}