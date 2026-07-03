<x-guest-layout>
    <div class="flex flex-col items-center justify-center px-4">
        <div class="w-full max-w-md bg-white border border-gray-100 text-center"
            style="background-color: white; border-radius: 2rem; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); width: 100%; max-width: 28rem; margin: auto; padding: 1rem 3rem;">

            <div style="display: flex; justify-content: center; margin-bottom: 0rem;">
                <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png"
                    alt="Edu-Forest Logo"
                    style="height: 10rem; width: auto; object-fit: contain;">
            </div>

            <div style="margin-bottom: 1.1rem;">
                <h2 style="font-size: 1.5rem; font-weight: 700; color: #111827;">
                    Join Us Today!
                </h2>
                <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem;">
                    Create your Edu-Forest client account.
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" autocomplete="off" style="text-align: left;">
                @csrf

                <div style="margin-bottom: 0.85rem;">
                    <label for="name" style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:0.25rem;">
                        Full Name
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Your Full Name" autocomplete="name"
                        style="display:block; width:100%; padding:0.7rem 1rem; border-radius:1rem; background-color:#f9fafb; border:1px solid #e5e7eb; font-size:0.875rem; box-sizing:border-box;" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div style="margin-bottom: 0.85rem;">
                    <label for="email" style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:0.25rem;">
                        Email Address
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="Enter your email address" autocomplete="username"
                        style="display:block; width:100%; padding:0.7rem 1rem; border-radius:1rem; background-color:#f9fafb; border:1px solid #e5e7eb; font-size:0.875rem; box-sizing:border-box;" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div style="margin-bottom: 0.85rem;">
                    <label for="password" style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:0.25rem;">
                        Password
                    </label>
                    <input id="password" type="password" name="password" required placeholder="Enter your password" autocomplete="new-password"
                        style="display:block; width:100%; padding:0.7rem 1rem; border-radius:1rem; background-color:#f9fafb; border:1px solid #e5e7eb; font-size:0.875rem; box-sizing:border-box;" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div style="margin-bottom: 1.1rem;">
                    <label for="password_confirmation" style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:0.25rem;">
                        Confirm Password
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Confirm your password" autocomplete="new-password"
                        style="display:block; width:100%; padding:0.7rem 1rem; border-radius:1rem; background-color:#f9fafb; border:1px solid #e5e7eb; font-size:0.875rem; box-sizing:border-box;" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <button type="submit"
                        style="display:block; width:100%; background-color:#2d5a3b; color:white; font-weight:700; padding:0.85rem 1rem; border-radius:1rem; border:none; font-size:0.875rem; cursor:pointer; text-align:center; box-shadow:0 4px 6px -1px rgba(45,90,59,0.3);">
                    Sign Up
                </button>
            </form>

            <div style="text-align:center; margin-top:1.2rem; padding-top:0.9rem; border-top:1px solid #f3f4f6;">
                <p style="font-size:0.875rem; color:#4b5563;">
                    Already have an account?
                    <a href="{{ route('login') }}" style="font-weight:700; color:#2d5a3b; text-decoration:none;">
                        Sign In
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>