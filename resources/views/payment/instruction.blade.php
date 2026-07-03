<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');
        body { font-family: 'Montserrat', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
@if (session('payment_success'))
    <div class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/35 px-5 backdrop-blur-sm">
        <div class="w-full max-w-xl rounded-[32px] border border-white/70 bg-white p-8 text-center font-['Montserrat'] shadow-[0_24px_70px_rgba(47,125,79,0.20)]">
            <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-[#eef8f1] text-[#2f7d4f] shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>

            <h2 class="mt-6 text-3xl font-extrabold text-[#163820]">
                Payment Successful!
            </h2>

            <p class="mt-3 text-base leading-7 text-slate-500">
                Your payment receipt has been successfully uploaded and is waiting for admin approval. Please Check My Bookings for confirmation
            </p>

            <div class="mt-7 rounded-3xl border border-amber-200 bg-amber-50 px-6 py-5 text-left">
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-slate-400">
                    Status
                </p>

                <div class="mt-3 inline-flex items-center gap-2 rounded-full border border-amber-300 bg-white px-4 py-2 text-sm font-extrabold text-amber-700">
                    <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                    Pending Admin Approval
                </div>

                <p class="mt-4 text-sm font-semibold leading-6 text-slate-500">
                    Invoice will be available after admin approval.
                </p>
            </div>

            <a href="{{ route('my-bookings') }}"
                class="mt-7 inline-flex w-full items-center justify-center rounded-2xl bg-[#2f7d4f] px-6 py-4 text-sm font-extrabold text-white shadow-[0_14px_30px_rgba(47,125,79,0.22)] transition hover:bg-[#25663f]">
                Back to My Bookings
            </a>
        </div>
    </div>
@endif
<body class="min-h-screen bg-[#eef8f1] antialiased overflow-x-hidden">

    @include('profile.partials.topbar')

        <main class="mx-auto max-w-3xl px-5 py-10 lg:px-8">
        <div class="bg-[#d2e7d6] rounded-2xl p-6 text-center">

            
            <div class="bg-[#d2e7d6] rounded-2xl p-6 text-center">
                <div class="text-[#2d5a43] flex items-center justify-center mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/>
                    </svg>
                </div>
                <p class="text-xs text-gray-600 font-medium tracking-wide">Total Payment</p>
                <h2 class="text-3xl font-extrabold text-[#1a4329] mt-1">
                    @if(strtolower($booking->selected_category ?? '') === 'international') USD @else RM @endif
                    {{ number_format($booking->total_amount ?? 0, 2) }}
                </h2>
                
                <p class="text-[11px] text-[#2d5a43] font-black uppercase tracking-wider mt-1">
                    {{ $packageName }} · {{ $booking->total_pax ?? 1 }} Pax
                </p>
            </div>

            
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-gray-800 tracking-wide border-b border-gray-200 pb-2">Bank Transfer Details</h3>
                <div class="space-y-3 text-xs text-gray-700">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-medium">Bank Name</span>
                        <span class="font-bold text-gray-900">Malayan Banking Berhad (Maybank)</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-medium">Account Name</span>
                        <span class="font-bold text-gray-900">UPSI Edu-Forest</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-medium">Account Number</span>
                        <span class="font-mono font-bold text-gray-900 tracking-wide">1234567890</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[#2d5a43] font-bold">Reference</span>
                        <span class="font-mono font-bold text-[#2d5a43] tracking-wide">{{ $booking->reference_number }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-medium">Amount</span>
                        <span class="font-bold text-gray-900">
                            @if(strtolower($booking->selected_category ?? '') === 'international') USD @else RM @endif
                            {{ number_format($booking->total_amount ?? 0, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Info box -->
            <div class="bg-[#e6f0fa] border border-[#cbdff7]/60 rounded-xl p-3 flex gap-2.5 text-[#1e4e8c] text-[11px] font-medium leading-relaxed">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 shrink-0 mt-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 1 1 1.056 1.056L10.5 14.25M12 7.5h.008v.008H12V7.5ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <p>Please include the reference number when making the payment. After paying, upload your receipt for admin approval.</p>
            </div>

            <div class="border-t border-dashed border-gray-200"></div>

            
            <form action="{{ route('payment.submit', $booking->reference_number) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Upload Payment Receipt (PDF, JPG, PNG)</label>
                    <label for="receiptInput" class="block cursor-pointer">
                        <div id="dropZone" class="relative border-2 border-dashed border-gray-200 hover:border-[#2d5a43] rounded-xl p-6 text-center transition-colors bg-gray-50/50">
                            <div class="space-y-1.5" id="uploadPlaceholder">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-gray-400 mx-auto">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"/>
                                </svg>
                                <p class="text-xs font-medium text-gray-500" id="file_name_display">Klik atau seret fail resit ke sini</p>
                                <p class="text-[10px] text-gray-400">Format: PDF, JPG, PNG (Maks 5MB)</p>
                            </div>
                        </div>
                        <input type="file" id="receiptInput" name="payment_receipt" accept="application/pdf,image/png,image/jpeg,image/jpg" required class="hidden">
                    </label>
                    @error('payment_receipt')
                        <p class="text-xs text-red-600 font-bold mt-1">⚠️ {{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full rounded-xl bg-[#2f7d4f] px-6 py-3.5 text-sm font-extrabold tracking-wide text-white shadow-sm transition hover:bg-[#256f43] active:scale-[0.99]">
                    Submit Receipt
                </button>
            </form>

        </div>
    </main>

    <script>
        document.getElementById('receiptInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const display = document.getElementById('file_name_display');
            const zone    = document.getElementById('dropZone');
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    alert('Fail terlalu besar (maks 5MB).');
                    this.value = '';
                    return;
                }
                display.textContent = '✅ ' + file.name;
                display.classList.add('text-[#2d5a43]', 'font-bold');
                zone.classList.add('border-[#2d5a43]', 'bg-[#f0f7f3]');
            }
        });
    </script>
</body>
</html>
