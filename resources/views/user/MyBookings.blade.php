@php
    use Illuminate\Support\Facades\DB;

    $defaultImage = 'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png';
@endphp

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - EduForest</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
            background: #f7f7f7;
        }

        .tab-active {
            background: white;
            color: #2d6a4f;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
        }
    </style>
</head>

<body class="min-h-screen antialiased">

    @include('profile.partials.topbar')

    <main class="mx-auto max-w-3xl px-5 py-8">

        <div class="mb-8">
            <h1 class="text-2xl font-extrabold text-[#2d6a4f]">My Bookings</h1>
            <p class="mt-1 text-sm font-medium text-gray-500">View and manage your booking history.</p>
        </div>

        <div class="mb-8 flex rounded-full bg-gray-200 p-1">
            <button id="upcomingBtn" type="button" class="tab-active w-1/2 rounded-full py-3 font-bold transition">
                Upcoming
            </button>

            <button id="historyBtn" type="button" class="w-1/2 rounded-full py-3 font-bold text-gray-400 transition">
                History
            </button>
        </div>

        <div id="upcomingSection" class="space-y-5">
            @forelse($bookings as $booking)
                @php
                    $package = DB::table('packages')->where('id', $booking->package_id)->first();

                    $packageName = $package->package_name ?? $package->name ?? 'Package';
                    $packageImage = $package->image_url ?? $defaultImage;

                    $checkIn = $booking->check_in_date;
                    $checkOut = $booking->check_out_date;

                    if ($checkIn && $checkOut) {
                        $dateText = \Carbon\Carbon::parse($checkIn)->format('d') . ' - ' . \Carbon\Carbon::parse($checkOut)->format('d F Y');
                    } else {
                        $dateText = '-';
                    }

                    $guest = $booking->total_pax ?? 0;
                    $total = $booking->total_amount ?? 0;
                    $status = $booking->status ?? 'pending';
                @endphp

                <div class="grid gap-4 rounded-[28px] border border-[#e2ece9] bg-[#edf4f1] p-4 shadow-sm sm:grid-cols-[140px_1fr]">
                    <div class="h-36 overflow-hidden rounded-2xl bg-white shadow-sm sm:h-full">
                        <img src="{{ $packageImage }}" class="h-full w-full object-cover" alt="{{ $packageName }}">
                    </div>

                    <div>
                        <div class="mb-4 flex items-start justify-between gap-3">
                            <h2 class="text-lg font-extrabold uppercase tracking-tight text-[#1e4634]">
                                {{ $packageName }}
                            </h2>

                            <span class="rounded-full bg-white px-3 py-1 text-[11px] font-bold uppercase text-[#2d6a4f]">
                                {{ $status }}
                            </span>
                        </div>

                        <div class="space-y-3 border-t border-[#d7e5df] pt-3">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M4.5 6.75h15A1.5 1.5 0 0 1 21 8.25v10.5A1.5 1.5 0 0 1 19.5 20.25h-15A1.5 1.5 0 0 1 3 18.75V8.25A1.5 1.5 0 0 1 4.5 6.75Z" />
                                    </svg>
                                    <span>Dates</span>
                                </div>

                                <span class="text-right font-semibold text-[#1e4634]">{{ $dateText }}</span>
                            </div>

                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                                    </svg>
                                    <span>Guest</span>
                                </div>

                                <span class="font-semibold text-[#1e4634]">{{ $guest }} pax</span>
                            </div>

                            <div class="flex items-end justify-between gap-4 pt-1">
                                <span class="font-semibold text-gray-600">Total Price</span>

                                <span class="text-2xl font-extrabold text-[#2d6a4f]">
                                    RM {{ number_format($total, 0) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-[#e2ece9] bg-[#edf4f1] p-12 text-center shadow-sm">
                    <h2 class="text-2xl font-bold text-[#2d6a4f]">No Booking Yet</h2>

                    <p class="mt-3 text-gray-500">You haven't made any booking.</p>

                    <a href="{{ route('booking.categories') }}"
                        class="mt-6 inline-block rounded-xl bg-[#2d6a4f] px-6 py-3 font-bold text-white transition hover:bg-[#1e4634]">
                        Book Now
                    </a>
                </div>
            @endforelse
        </div>

        <div id="historySection" class="hidden">
            <div class="rounded-[28px] border border-[#e2ece9] bg-[#edf4f1] p-12 text-center shadow-sm">
                <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-full bg-white text-[#2d6a4f]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" class="h-7 w-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />
                    </svg>
                </div>

                <h2 class="text-2xl font-extrabold text-[#2d6a4f]">No Booking History</h2>

                <p class="mt-3 leading-relaxed text-gray-500">
                    Your completed bookings will appear here after your activities have finished.
                </p>
            </div>
        </div>

    </main>

    <script>
        const upcomingBtn = document.getElementById('upcomingBtn');
        const historyBtn = document.getElementById('historyBtn');
        const upcoming = document.getElementById('upcomingSection');
        const history = document.getElementById('historySection');

        upcomingBtn?.addEventListener('click', function () {
            upcoming.classList.remove('hidden');
            history.classList.add('hidden');

            upcomingBtn.classList.add('tab-active');
            upcomingBtn.classList.remove('text-gray-400');

            historyBtn.classList.remove('tab-active');
            historyBtn.classList.add('text-gray-400');
        });

        historyBtn?.addEventListener('click', function () {
            history.classList.remove('hidden');
            upcoming.classList.add('hidden');

            historyBtn.classList.add('tab-active');
            historyBtn.classList.remove('text-gray-400');

            upcomingBtn.classList.remove('tab-active');
            upcomingBtn.classList.add('text-gray-400');
        });
    </script>

</body>
</html>