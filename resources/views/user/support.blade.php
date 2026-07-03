<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help and Support</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Montserrat', sans-serif;
        }
        
        .faq-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.25s ease-out;
        }
        .faq-item.active .faq-content {
            max-height: 300px;
            padding-top: 12px;
            padding-bottom: 16px;
        }
        
        .faq-item.active .faq-title {
            color: #2D5A27;
        }
        .faq-item.active .faq-icon {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-white antialiased">

    @include('profile.partials.topbar')

    <div class="max-w-xl w-full mx-auto px-6 pt-10 text-center">
        <h1 class="text-xl font-semibold tracking-wide text-stone-800">Help and Support</h1>
    </div>

    
    <main class="max-w-xl w-full mx-auto px-6 py-10">
        
        
        <div class="relative mb-8">
            <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-stone-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.603 10.603Z" />
                </svg>
            </span>
            <input type="text" id="faqSearch" placeholder="Search..." class="w-full bg-white border border-stone-200 rounded-2xl py-3.5 pl-12 pr-4 text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:border-stone-400 transition shadow-xs">
        </div>

        
        <div class="divide-y divide-stone-100">

            
            <div class="faq-item py-4">
                <button type="button" onclick="toggleFaq(this)" class="w-full flex items-center justify-between text-left cursor-pointer group">
                    <span class="faq-title font-bold text-stone-900 text-[15px] tracking-wide transition-colors duration-200">How do I book an activity or campsite?</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="faq-icon w-4 h-4 text-stone-800 transition-transform duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="faq-content text-sm text-stone-500 leading-relaxed">
                    To book an activity or campsite, you must sign up and create an account first. Once logged in, select your preferred package and proceed with the booking system.
                </div>
            </div>

            
            <div class="faq-item py-4">
                <button type="button" onclick="toggleFaq(this)" class="w-full flex items-center justify-between text-left cursor-pointer group">
                    <span class="faq-title font-bold text-stone-900 text-[15px] tracking-wide transition-colors duration-200">Can I get a refund if I cancel?</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="faq-icon w-4 h-4 text-stone-800 transition-transform duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="faq-content text-sm text-stone-500 leading-relaxed">
                    No, cancellations made after a booking is confirmed are non-refundable.
                </div>
            </div>

            
            <div class="faq-item py-4">
                <button type="button" onclick="toggleFaq(this)" class="w-full flex items-center justify-between text-left cursor-pointer group">
                    <span class="faq-title font-bold text-stone-900 text-[15px] tracking-wide transition-colors duration-200">My payment went through but my booking is still "Pending"?</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="faq-icon w-4 h-4 text-stone-800 transition-transform duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="faq-content text-sm text-stone-500 leading-relaxed">
                    Please wait 5–10 minutes and refresh 'My Bookings'. If it doesn't update, send your receipt via the "Contact Us" button.
                </div>
            </div>

            
            <div class="faq-item py-4">
                <button type="button" onclick="toggleFaq(this)" class="w-full flex items-center justify-between text-left cursor-pointer group">
                    <span class="faq-title font-bold text-stone-900 text-[15px] tracking-wide transition-colors duration-200">Are outside food and drinks allowed?</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="faq-icon w-4 h-4 text-stone-800 transition-transform duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="faq-content text-sm text-stone-500 leading-relaxed">
                    Yes, outside food and drinks are allowed exclusively for camping activities. Please make sure to maintain the cleanliness of the campsite.
                </div>
            </div>

        </div>
    </main>

    
    <script>
        function toggleFaq(button) {
            const currentItem = button.parentElement;
            
            document.querySelectorAll('.faq-item').forEach(item => {
                if (item !== currentItem) {
                    item.classList.remove('active');
                }
            });

            currentItem.classList.toggle('active');
        }

        document.getElementById('faqSearch').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('.faq-item').forEach(item => {
                const text = item.querySelector('.faq-title').textContent.toLowerCase();
                if (text.includes(filter)) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            });
        });
    </script>

</body>
</html>