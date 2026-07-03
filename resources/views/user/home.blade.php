<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Booking - EduForest</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Montserrat', sans-serif; }
    </style>
</head>

<body class="bg-stone-50 m-0 p-0 antialiased min-h-screen overflow-x-hidden">

    @include('profile.partials.topbar')

    <main class="max-w-3xl w-full mx-auto px-6 py-16">

        <div class="text-center mb-10">
            <h1 class="text-2xl font-extrabold text-stone-900 tracking-tight">Start Your Booking</h1>
            <p class="text-stone-500 text-sm mt-2">Pick a date, then continue to select your package.</p>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-stone-200/60">
            <div class="flex justify-between items-center mb-6">
                <button onclick="changeMonth(-1)" class="p-2 hover:bg-stone-100 rounded-full cursor-pointer text-stone-600 font-bold">&lt;</button>
                <h2 id="calendar-month-year" class="text-lg font-bold text-stone-800 uppercase tracking-wide">June 2026</h2>
                <button onclick="changeMonth(1)" class="p-2 hover:bg-stone-100 rounded-full cursor-pointer text-stone-600 font-bold">&gt;</button>
            </div>

            <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-stone-400 uppercase tracking-wider mb-4">
                <div>Su</div><div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div>
            </div>

            <div id="calendar-days" class="grid grid-cols-7 gap-3 text-center"></div>

            <div class="flex items-center justify-center space-x-6 mt-6 pt-4 border-t border-stone-100 text-xs font-semibold text-stone-500">
                <div class="flex items-center space-x-2">
                    <span class="w-4 h-4 bg-[#10b981] block rounded-sm"></span>
                    <span>Fully Booked</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="w-4 h-4 bg-[#dc2626] block rounded-sm"></span>
                    <span>Public Holiday</span>
                </div>
            </div>
        </div>

        <a href="{{ route('booking.categories') }}"
           class="mt-8 w-full inline-flex items-center justify-center bg-[#046307] hover:bg-[#03500a] text-white font-bold py-4 px-6 rounded-full transition duration-200 shadow-sm text-center text-sm uppercase tracking-wide">
            Booking Now
        </a>

    </main>

    <script>
        const fullyBookedDates = {!! json_encode($fullyBookedDates ?? []) !!};
        const publicHolidayDates = {!! json_encode($publicHolidayDates ?? []) !!};

        let currentDate = new Date();

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            document.getElementById("calendar-month-year").innerText = `${monthNames[month]} ${year}`;

            const firstDayIndex = new Date(year, month, 1).getDay();
            const lastDay = new Date(year, month + 1, 0).getDate();

            const calendarDays = document.getElementById("calendar-days");
            calendarDays.innerHTML = "";

            for (let i = 0; i < firstDayIndex; i++) {
                calendarDays.appendChild(document.createElement("div"));
            }

            for (let day = 1; day <= lastDay; day++) {
                const dayDiv = document.createElement("div");
                dayDiv.innerText = day;
                dayDiv.className = "py-3 text-sm font-semibold text-stone-700 rounded-xl transition duration-200 ";

                const formattedMonth = String(month + 1).padStart(2, '0');
                const formattedDay = String(day).padStart(2, '0');
                const dateString = `${year}-${formattedMonth}-${formattedDay}`;

                if (publicHolidayDates.includes(dateString)) {
                    dayDiv.className += " bg-[#dc2626] text-white font-bold shadow-sm cursor-not-allowed";
                    dayDiv.title = "Public Holiday";
                } else if (fullyBookedDates.includes(dateString)) {
                    dayDiv.className += " bg-[#10b981] text-white font-bold shadow-sm cursor-not-allowed";
                    dayDiv.title = "Fully Booked";
                } else {
                    dayDiv.className += " bg-stone-50 hover:bg-stone-200 cursor-pointer";
                }

                calendarDays.appendChild(dayDiv);
            }
        }

        function changeMonth(direction) {
            currentDate.setMonth(currentDate.getMonth() + direction);
            renderCalendar();
        }

        document.addEventListener("DOMContentLoaded", renderCalendar);
    </script>

</body>
</html>