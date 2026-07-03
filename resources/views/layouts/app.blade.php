<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EduForest') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-stone-50">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">

        <aside
            class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col justify-between overflow-y-auto bg-[#1e4634] p-6 text-white shadow-xl transition-transform duration-300 lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div>
                <div class="flex items-center gap-3 border-b border-white/10 pb-6">
                    <img
                        src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png"
                        alt="EduForest Logo"
                        class="h-11 w-11 rounded-full border border-white/20 bg-white object-contain p-1"
                    >

                    <div>
                        <h3 class="text-sm font-bold tracking-wide text-white">Edu-Forest UPSI</h3>
                        <p class="text-[11px] font-medium text-white/60">User Portal</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 py-6">
                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=ffffff&color=2d5a43"
                        class="h-10 w-10 rounded-full border border-white/20 object-cover"
                        alt="Avatar"
                    >

                    <div class="min-w-0">
                        <h4 class="truncate text-xs font-bold text-white">
                            {{ Auth::user()->name ?? 'Guest User' }}
                        </h4>
                        <p class="mt-0.5 truncate text-[10px] text-white/60">
                            {{ Auth::user()->email ?? 'guest@eduforest' }}
                        </p>
                    </div>
                </div>

                <nav class="space-y-1 text-xs font-semibold">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center rounded-xl px-3 py-3 text-white/80 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-white/15 text-white' : '' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('activities.list') }}"
                        class="flex items-center rounded-xl px-3 py-3 text-white/80 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('activities.*') ? 'bg-white/15 text-white' : '' }}">
                        Activities
                    </a>

                    <a href="{{ route('booking.categories') }}"
                        class="flex items-center rounded-xl px-3 py-3 text-white/80 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('booking.*') || request()->routeIs('packages.*') ? 'bg-white/15 text-white' : '' }}">
                        Packages
                    </a>

                    <a href="{{ route('home') }}"
                        class="flex items-center rounded-xl px-3 py-3 text-white/80 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('home') ? 'bg-white/15 text-white' : '' }}">
                        Booking Calendar
                    </a>

                    <a href="{{ route('my-bookings') }}"
                        class="flex items-center rounded-xl px-3 py-3 text-white/80 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('my-bookings') ? 'bg-white/15 text-white' : '' }}">
                        My Bookings
                    </a>

                    <a href="{{ route('profile.show') }}"
                        class="flex items-center rounded-xl px-3 py-3 text-white/80 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('profile.*') ? 'bg-white/15 text-white' : '' }}">
                        Profile
                    </a>
                </nav>
            </div>

            @auth
                <form method="POST" action="{{ route('logout') }}" class="border-t border-white/10 pt-4">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-xl bg-white px-4 py-3 text-xs font-bold text-[#1e4634] transition hover:bg-green-50">
                        Logout
                    </button>
                </form>
            @endauth
        </aside>

        <button
            type="button"
            x-show="sidebarOpen"
            x-cloak
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/40 lg:hidden"
            aria-label="Close menu"
        ></button>

        <div class="flex min-w-0 flex-1 flex-col lg:pl-64">
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between bg-[#046307] px-5 shadow-sm lg:px-8">
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        @click="sidebarOpen = !sidebarOpen"
                        class="rounded-lg p-2 text-white transition hover:bg-white/10 lg:hidden"
                        aria-label="Toggle menu"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>

                    <h2 class="text-sm font-bold tracking-wide text-white sm:text-base">
                        EduForest Portal
                    </h2>
                </div>

                <a href="{{ route('profile.show') }}"
                    class="truncate rounded-full border border-white/10 bg-white/15 px-4 py-2 text-xs font-semibold text-white transition hover:bg-white/20">
                    {{ Auth::user()->name ?? 'User' }}
                </a>
            </header>

            @isset($header)
                <div class="border-b border-stone-200 bg-white px-5 py-4 lg:px-8">
                    {{ $header }}
                </div>
            @endisset

            <main class="flex-1 p-5 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>