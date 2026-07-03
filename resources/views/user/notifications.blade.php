<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body class="bg-white antialiased">

    @include('profile.partials.topbar')

    <div class="max-w-xl w-full mx-auto px-6 pt-10 text-center">
        <h1 class="text-xl font-semibold tracking-wide text-stone-800">Notifications</h1>
    </div>

    <main class="max-w-xl w-full mx-auto px-6 py-10">
        
        <div class="space-y-2">
            
            @if($notifications->isEmpty())
                <div class="text-center py-16 border border-stone-200 border-dashed rounded-2xl">
                    <p class="text-stone-400 text-sm">No notifications available yet.</p>
                </div>
            @else
                
                @foreach($notifications as $notification)
                    <div class="flex items-start space-x-4 p-5 bg-white border border-stone-200 rounded-2xl shadow-xs hover:border-stone-300 transition">
                        
                        <div class="w-12 h-12 rounded-full bg-stone-50 border border-stone-200 text-stone-600 flex-shrink-0 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                        </div>
                        
                        <div class="flex-grow">
                            
                            <h3 class="font-bold text-stone-900 text-sm tracking-wide">
                                {{ $notification->title }}
                            </h3>
                            
                            
                            <p class="text-xs text-stone-600 mt-1.5 leading-relaxed">
                                {{ $notification->message }}
                            </p>
                            
                            
                            <span class="text-[10px] text-stone-400 block mt-3">
                                {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </main>

</body>
</html>