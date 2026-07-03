<x-guest-layout>
    <div class="flex items-center justify-center px-4 py-6">

        <div class="w-full max-w-md"
            style="
                background-color:white;
                border-radius:2rem;
                box-shadow:0 10px 25px -5px rgba(0,0,0,.1);
                padding:1rem 3rem;
            ">
            <div class="flex justify-center mb-2" style="display: flex; justify-content: center; margin-bottom: 1rem;">
                <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png" 
                    alt="Edu-Forest Logo" style="height: 10rem; width: auto; object-fit: contain;">
            </div>

            <div class="mb-6"
                    style="margin-bottom:1.5rem; text-align:center;">
                <h2 id="loginTitle" style="font-size: 1.5rem; font-weight: 700; color: #111827;">
                    Welcome Back!
                </h2>

                <p id="loginSubtitle" style="font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem;">
                    Log in to continue your nature adventure.
                </p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            @if ($errors->any())
                <div style="color: #ef4444; font-size: 0.875rem; text-align: center; margin-bottom: 1rem;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form id="loginForm" method="POST" action="{{ route('login') }}" autocomplete="off" class="space-y-4 text-left" style="text-align: left;">
                @csrf

                <input type="hidden" id="loginType" name="login_type" value="client">

                <div style="margin-bottom: 1rem;">
                    <label for="email" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.25rem;">
                        Email Address
                    </label>

                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email address" autocomplete="username"
                        style="display: block; width: 100%; padding: 0.75rem 1rem; border-radius: 1rem; background-color: #f9fafb; border: 1px solid #e5e7eb; font-size: 0.875rem; box-sizing: border-box;" />

                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div style="margin-bottom: 1rem;">
                    <label for="password" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.25rem;">
                        Password
                    </label>

                    <input id="password" type="password" name="password" required placeholder="Enter your password" autocomplete="current-password"
                        style="display: block; width: 100%; padding: 0.75rem 1rem; border-radius: 1rem; background-color: #f9fafb; border: 1px solid #e5e7eb; font-size: 0.875rem; box-sizing: border-box;" />

                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                    <label for="remember_me" style="display: inline-flex; align-items: center;">
                        <input id="remember_me" type="checkbox" name="remember" style="width: 1rem; height: 1rem; border-radius: 0.25rem;">
                        <span style="margin-left: 0.5rem; font-size: 0.875rem; color: #4b5563;">Remember Me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size: 0.875rem; font-weight: 500; color: #ef4444; text-decoration: none;">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <!-- ROLE SELECT -->
                <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0.75rem; margin-bottom: 1.25rem;">
                    <button type="button" id="clientBtn" onclick="selectClient()"
                        style="width: 100%; padding: 0.875rem 0.5rem; border-radius: 1rem; border: 2px solid #2d5a3b; background-color: #2d5a3b; color: white; font-weight: 700; cursor: pointer;">
                        Client
                    </button>

                    <button type="button" id="adminBtn" onclick="selectAdmin()"
                        style="width: 100%; padding: 0.875rem 0.5rem; border-radius: 1rem; border: 2px solid #e5e7eb; background-color: #f3f4f6; color: #6b7280; font-weight: 700; cursor: pointer;">
                        Admin
                    </button>
                </div>

                <div style="padding-top: 0.25rem;">
                    <button id="submitBtn" type="submit" 
                            style="display: block; width: 100%; background-color: #2d5a3b; color: white; font-weight: 700; padding: 0.875rem 1rem; border-radius: 1rem; border: none; font-size: 0.875rem; cursor: pointer; text-align: center; box-shadow: 0 4px 6px -1px rgba(45, 90, 59, 0.3);">
                        Log In
                    </button>
                </div>
            </form>

            <div id="registerText" style="text-align: center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #f3f4f6;">
                <p style="font-size: 0.875rem; color: #4b5563;">
                    Don't have an account? 
                    <a href="{{ route('register') }}" style="font-weight: 700; color: #2d5a3b; text-decoration: none;">
                        Sign Up Now
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function selectClient() {
            const form = document.getElementById('loginForm');
            const title = document.getElementById('loginTitle');
            const subtitle = document.getElementById('loginSubtitle');
            const submitBtn = document.getElementById('submitBtn');
            const clientBtn = document.getElementById('clientBtn');
            const adminBtn = document.getElementById('adminBtn');
            const loginType = document.getElementById('loginType');
            const registerText = document.getElementById('registerText');

            form.action = "{{ route('login') }}";
            loginType.value = "client";

            title.innerText = "Welcome Back!";
            subtitle.innerText = "Log in to continue your nature adventure.";
            submitBtn.innerText = "Log In";
            registerText.style.display = "block";

            clientBtn.style.backgroundColor = "#2d5a3b";
            clientBtn.style.color = "white";
            clientBtn.style.borderColor = "#2d5a3b";

            adminBtn.style.backgroundColor = "#f3f4f6";
            adminBtn.style.color = "#6b7280";
            adminBtn.style.borderColor = "#e5e7eb";
        }

        function selectAdmin() {
            const form = document.getElementById('loginForm');
            const title = document.getElementById('loginTitle');
            const subtitle = document.getElementById('loginSubtitle');
            const submitBtn = document.getElementById('submitBtn');
            const clientBtn = document.getElementById('clientBtn');
            const adminBtn = document.getElementById('adminBtn');
            const loginType = document.getElementById('loginType');
            const registerText = document.getElementById('registerText');

            form.action = "{{ route('admin.login.submit') }}";
            loginType.value = "admin";

            title.innerText = "Admin Login";
            subtitle.innerText = "Sign in to access the EduForest Admin Dashboard.";
            submitBtn.innerText = "Log In as Admin";
            registerText.style.display = "none";

            adminBtn.style.backgroundColor = "#2d5a3b";
            adminBtn.style.color = "white";
            adminBtn.style.borderColor = "#2d5a3b";

            clientBtn.style.backgroundColor = "#f3f4f6";
            clientBtn.style.color = "#6b7280";
            clientBtn.style.borderColor = "#e5e7eb";
        }
    </script>
</x-guest-layout>