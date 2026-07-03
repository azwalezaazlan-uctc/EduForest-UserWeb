<header class="sticky top-0 z-50 px-4 pt-4">
    <div class="mx-auto max-w-7xl overflow-hidden rounded-[22px] border border-white/70 bg-[#c9ead6]/90 shadow-[0_18px_45px_rgba(62,111,82,0.18)] backdrop-blur-xl">
        <div class="grid h-16 grid-cols-3 items-center px-5 lg:px-8">

            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <img
                    src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png"
                    class="h-20 w-auto object-contain"
                    alt="EduForest"
                >

                <span class="hidden text-sm font-extrabold tracking-[0.18em] text-slate-800 sm:inline">
                    EDUFOREST
                </span>
            </a>

            <nav class="hidden items-center justify-center gap-1 text-[11px] font-bold uppercase tracking-[0.16em] text-slate-700 lg:flex">
                <a href="{{ route('activities.list') }}"
                    class="rounded-full px-4 py-2 transition hover:bg-white/55 hover:text-slate-950 {{ request()->routeIs('activities.*') ? 'bg-white/70 text-slate-950 shadow-sm' : '' }}">
                    Activities
                </a>

<a href="{{ route('packages.index', ['category' => 'upsi']) }}"                    class="rounded-full px-4 py-2 transition hover:bg-white/55 hover:text-slate-950 {{ request()->routeIs('booking.*') || request()->routeIs('packages.*') ? 'bg-white/70 text-slate-950 shadow-sm' : '' }}">
                    Packages
                </a>

                <a href="{{ route('maps.index') }}"
                    class="rounded-full px-4 py-2 transition hover:bg-white/55 hover:text-slate-950 {{ request()->routeIs('maps.*') ? 'bg-white/70 text-slate-950 shadow-sm' : '' }}">
                    Map
                </a>

                <a href="{{ route('home') }}"
                    class="rounded-full px-4 py-2 transition hover:bg-white/55 hover:text-slate-950 {{ request()->routeIs('home') ? 'bg-white/70 text-slate-950 shadow-sm' : '' }}">
                    Booking
                </a>

                <a href="{{ route('my-bookings') }}"
                    class="rounded-full px-4 py-2 transition hover:bg-white/55 hover:text-slate-950 {{ request()->routeIs('my-bookings') ? 'bg-white/70 text-slate-950 shadow-sm' : '' }}">
                    My Bookings
                </a>
            </nav>

            <div class="hidden items-center justify-end gap-3 lg:flex">
                <a href="{{ route('profile.show') }}"
                    class="rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.16em] text-slate-700 transition hover:bg-white/55 hover:text-slate-950 {{ request()->routeIs('profile.*') ? 'bg-white/70 text-slate-950 shadow-sm' : '' }}">
                    Settings
                </a>

                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="rounded-full bg-white/85 px-6 py-2.5 text-[11px] font-extrabold uppercase tracking-[0.16em] text-slate-800 shadow-sm transition hover:bg-white hover:shadow-md">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-full bg-white/85 px-6 py-2.5 text-[11px] font-extrabold uppercase tracking-[0.16em] text-slate-800 shadow-sm transition hover:bg-white hover:shadow-md">
                        Login
                    </a>
                @endauth
            </div>

            <button
                id="mobileMenuBtn"
                type="button"
                class="col-start-3 justify-self-end rounded-full bg-white/55 p-2 text-slate-800 shadow-sm transition hover:bg-white lg:hidden"
                aria-label="Open menu"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="2.4" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>

        <div id="mobileMenu" class="hidden border-t border-white/50 bg-[#c9ead6]/95 px-4 py-4 lg:hidden">
            <div class="space-y-1 text-sm font-bold text-slate-800">
                <a href="{{ route('activities.list') }}" class="block rounded-2xl px-4 py-3 transition hover:bg-white/55">Activities</a>
<a href="{{ route('packages.index', ['category' => 'upsi']) }}" class="block rounded-2xl px-4 py-3 transition hover:bg-white/55">Packages</a>                <a href="{{ route('maps.index') }}" class="block rounded-2xl px-4 py-3 transition hover:bg-white/55">Map</a>
                <a href="{{ route('home') }}" class="block rounded-2xl px-4 py-3 transition hover:bg-white/55">Booking</a>
                <a href="{{ route('my-bookings') }}" class="block rounded-2xl px-4 py-3 transition hover:bg-white/55">My Bookings</a>
                <a href="{{ route('profile.show') }}" class="block rounded-2xl px-4 py-3 transition hover:bg-white/55">Settings</a>

                @auth
                    <form method="POST" action="{{ route('logout') }}" class="pt-2">
                        @csrf
                        <button type="submit" class="w-full rounded-2xl bg-white px-4 py-3 text-center font-extrabold text-slate-800">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block rounded-2xl bg-white px-4 py-3 text-center font-extrabold text-slate-800">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

<script>
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function () {
        document.getElementById('mobileMenu')?.classList.toggle('hidden');
    });
</script>