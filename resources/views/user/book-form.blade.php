@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    $userProfile  = DB::table('profiles')->where('id', Auth::id())->first();
    $userEmail    = Auth::user()->email ?? '';
    $userName     = $userProfile->full_name   ?? '';
    $userPhone    = $userProfile->phone_number ?? '';

    $packageId    = request()->query('package_id', '');
    $packageName  = strtoupper(request()->query('package_name', 'PACKAGE B'));
    $packageDays  = intval(request()->query('package_days', 2));
    $packageLabel = request()->query('package_label', '2 Days 1 Night');
    $categoryInput= request()->query('category', 'upsi');

    
    $categoryTitles = [
        'upsi'          => 'UPSI Student / Staff',
        'gov'           => 'Government Agency',
        'public'        => 'Public Participant',
        'international' => 'International Participant',
    ];
    $categoryTitle = $categoryTitles[$categoryInput] ?? 'UPSI Student / Staff';
@endphp
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Detail</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');
        body { font-family: 'Montserrat', sans-serif; }
        .shadow-custom { box-shadow: 0 10px 25px -5px rgba(0,0,0,0.06), 0 8px 16px -6px rgba(0,0,0,0.03); }
        input[type="date"]::-webkit-calendar-picker-indicator { opacity: 0.6; cursor: pointer; }
    </style>
</head>
<body class="antialiased min-h-screen pb-16" style="background:linear-gradient(rgba(244,247,245,0.85),rgba(244,247,245,0.85)),url('https://images.unsplash.com/photo-1448375240586-882707db888b?q=80&w=1200&auto=format&fit=crop');background-size:cover;background-attachment:fixed;background-position:center;">

    @include('profile.partials.topbar')

    <div class="max-w-xl mx-auto px-4 pt-6 flex items-center justify-between">
        <h1 class="text-lg font-bold tracking-wide text-stone-800">Booking Detail</h1>
        <div class="bg-[#046307]/10 text-[#046307] text-[11px] font-semibold px-3 py-1.5 rounded-full border border-[#046307]/20 hidden sm:block">
            {{ $categoryTitle }}
        </div>
    </div>

    <main class="max-w-xl mx-auto px-4 mt-6">
        <div class="bg-white rounded-[2rem] p-6 shadow-custom border border-white/60">

            <div class="mb-5 text-center">
                <h2 class="text-lg font-extrabold text-[#1e3522]">Booking Detail</h2>
                <p class="text-xs text-gray-400 mt-1">Please complete your booking details.</p>
            </div>

            <form action="{{ route('booking.confirmation') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                
                <input type="hidden" name="package_id"    value="{{ $packageId }}">
                <input type="hidden" name="package_name"  value="{{ $packageName }}">
                <input type="hidden" name="package_days"  value="{{ $packageDays }}">
                <input type="hidden" name="category"      value="{{ $categoryInput }}">

                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Package Duration</label>
                    <div class="inline-flex items-center bg-[#e8f4ee] border border-[#a3c5af] rounded-full px-5 py-2">
                        <span class="text-sm font-extrabold text-[#1e3522]">{{ $packageLabel }}</span>
                    </div>
                </div>

                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Date</label>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-xl bg-gray-50 border border-gray-200 p-3">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">📅 Check – In</p>
                            <input type="date" id="check_in_date" name="booking_date" required
                                class="w-full bg-transparent border-none p-0 text-sm font-bold text-[#1e3522] focus:outline-none focus:ring-0">
                        </div>
                        <div class="rounded-xl bg-gray-50 border border-gray-200 p-3">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">📅 Check – Out</p>
                            <input type="date" id="check_out_date" name="checkout_date" readonly
                                class="w-full bg-transparent border-none p-0 text-sm font-bold text-[#1e3522] focus:outline-none focus:ring-0 cursor-not-allowed opacity-70">
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1.5 ml-1">Check-out dikira secara automatik berdasarkan tempoh pakej.</p>
                </div>

                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Pax</label>
                    <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-xl px-4 py-3">
                        <span class="text-sm text-gray-500 font-medium">Number of Participants</span>
                        <div class="flex items-center gap-4">
                            <button type="button" onclick="decrementPax()" class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center font-bold text-gray-700 transition-all">–</button>
                            <input type="number" id="total_pax_input" name="total_pax" value="1" min="1" readonly
                                class="w-8 text-center font-bold text-lg bg-transparent border-none focus:outline-none text-[#1e3522]">
                            <button type="button" onclick="incrementPax()" class="w-8 h-8 rounded-full bg-[#2d5a43] hover:bg-[#1e3522] flex items-center justify-center font-bold text-white transition-all">+</button>
                        </div>
                    </div>
                </div>

                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Selected Category</label>
                    <div class="rounded-xl bg-gray-50 border border-gray-200 px-4 py-3">
                        <span class="text-sm font-bold text-[#1e3522] uppercase tracking-wide">{{ strtoupper($categoryInput) }}</span>
                    </div>
                </div>

                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Organization / Group Name</label>
                    <input type="text" name="organization_name" placeholder="e.g., SMK Sri Maharaja, Persatuan Belia"
                        class="w-full rounded-xl bg-gray-50 border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:border-[#2d5a43] focus:bg-white transition-all placeholder-gray-300">
                </div>

                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Contact Person</label>
                    <input type="text" name="client_name" value="{{ $userName }}" placeholder="Name" required
                        class="w-full rounded-xl bg-gray-50 border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:border-[#2d5a43] focus:bg-white transition-all placeholder-gray-300">
                </div>

                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Phone Number</label>
                    <input type="tel" name="client_number" value="{{ $userPhone }}" placeholder="Phone Number" required
                        class="w-full rounded-xl bg-gray-50 border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:border-[#2d5a43] focus:bg-white transition-all placeholder-gray-300">
                </div>

                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Email Address</label>
                    <input type="email" name="client_email" value="{{ $userEmail }}" readonly
                        class="w-full rounded-xl bg-gray-50 border border-gray-200 px-4 py-3 text-sm text-gray-500 focus:outline-none cursor-not-allowed">
                    <p class="text-[10px] text-gray-400 mt-1 ml-1">Taken from your account profile.</p>
                </div>

                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Notes / Special Request</label>
                    <textarea name="special_requests" rows="3" placeholder="Notes/Special Request"
                        class="w-full rounded-xl bg-gray-50 border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:border-[#2d5a43] focus:bg-white transition-all placeholder-gray-300 resize-none"></textarea>
                </div>

                {{--


<div>
    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Participant Name List</label>
    <p class="text-[10px] text-gray-400 mb-2 ml-0.5" id="pdf_hint">Required for bookings with 10 pax and above.</p>

    <label for="participant_list_pdf" class="block w-full cursor-pointer">
        <div id="pdf_drop_zone" class="rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 hover:bg-[#f0f7f3] hover:border-[#2d5a43]/40 transition-all px-4 py-6 flex flex-col items-center gap-2 text-center">

            ...

        </div>

        <input type="file" id="participant_list_pdf" name="participant_list_pdf"
        accept="application/pdf" class="hidden"
        onchange="handlePdfSelect(this)">
    </label>
</div>

--}}

                
                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-[#2d5a43] hover:bg-[#1e3522] text-white font-bold py-4 px-6 rounded-xl shadow-md active:scale-[0.99] transition-all tracking-wide text-sm cursor-pointer">
                        Next
                    </button>
                </div>

            </form>
        </div>
    </main>

    <script>
        const PACKAGE_DAYS = {{ $packageDays }};

        // ── PAX counter ──
        function incrementPax() {
            const inp = document.getElementById('total_pax_input');
            inp.value = parseInt(inp.value) + 1;
            checkPaxForPdf();
        }
        function decrementPax() {
            const inp = document.getElementById('total_pax_input');
            if (parseInt(inp.value) > 1) { inp.value = parseInt(inp.value) - 1; }
            checkPaxForPdf();
        }
        
        function checkPaxForPdf() {
            const pax = parseInt(document.getElementById('total_pax_input').value);
            const hint = document.getElementById('pdf_hint');
            const pdfInput = document.getElementById('participant_list_pdf');
            if (pax >= 10) {
                hint.textContent = '⚠️ Senarai nama peserta diperlukan untuk 10 pax dan ke atas.';
                hint.className = 'text-[10px] text-orange-500 mb-2 ml-0.5 font-semibold';
                pdfInput.required = true;
            } else {
                hint.textContent = 'Required for bookings with 10 pax and above.';
                hint.className = 'text-[10px] text-gray-400 mb-2 ml-0.5';
                pdfInput.required = false;
            }
        }

        
        document.addEventListener('DOMContentLoaded', function () {
            const checkIn  = document.getElementById('check_in_date');
            const checkOut = document.getElementById('check_out_date');

            const today = new Date().toISOString().split('T')[0];
            checkIn.min = today;

            checkIn.addEventListener('change', function () {
                if (!checkIn.value) { checkOut.value = ''; return; }
                const d = new Date(checkIn.value);
                d.setDate(d.getDate() + (PACKAGE_DAYS - 1));
                checkOut.value = d.toISOString().split('T')[0];
            });
        });

        
        function handlePdfSelect(input) {
            const label = document.getElementById('pdf_label');
            const zone  = document.getElementById('pdf_drop_zone');
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (file.size > 5 * 1024 * 1024) {
                    alert('Fail terlalu besar. Saiz maksimum ialah 5 MB.');
                    input.value = '';
                    label.textContent = 'Upload Participant Name List';
                    zone.classList.remove('border-[#2d5a43]','bg-[#f0f7f3]');
                    return;
                }
                label.textContent = '✅ ' + file.name;
                zone.classList.add('border-[#2d5a43]','bg-[#f0f7f3]');
            }
        }
    </script>
</body>
</html>