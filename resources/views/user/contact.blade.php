<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - EduForest UCTC</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body class="bg-stone-100 min-h-screen flex flex-col antialiased">

    @include('profile.partials.topbar')

    <div class="max-w-xl w-full mx-auto px-6 pt-10 text-center">
        <h1 class="text-xl font-bold uppercase tracking-wider text-stone-800">Contact Us</h1>
    </div>

    
    <main class="flex-grow max-w-xl w-full mx-auto px-6 py-12">
        
        
        <div class="text-center mb-10 text-stone-800">
            <h2 class="font-extrabold text-sm tracking-wide">
                Pusat Transformasi Komuniti Universiti (UCTC)
            </h2>
            <div class="text-xs text-stone-600 mt-2 space-y-0.5">
                <p>05-4506979</p>
                <p>uctc@upsi.edu.my</p>
            </div>
        </div>

        
        <div class="space-y-6">

            
            <div class="bg-white border border-stone-300 rounded-2xl p-6 shadow-xs">
                <div class="border-b border-stone-400 pb-2 mb-3">
                    <h3 class="font-bold text-stone-900 text-lg tracking-wide uppercase">
                        DR. AQIL WONG
                    </h3>
                </div>
                <div class="text-right space-y-0.5 text-xs text-stone-600">
                    <p>Deputy Director</p>
                    <p>+6012-5151268</p>
                    <p>cheetah@fsmt.upsi.edu.my</p>
                    <p class="text-stone-500 pt-1">Pusat Transformasi dan Komuniti UCTC, UPSI</p>
                </div>
            </div>

            
            <div class="bg-white border border-stone-300 rounded-2xl p-6 shadow-xs">
                <div class="border-b border-stone-400 pb-2 mb-3">
                    <h3 class="font-bold text-stone-900 text-lg tracking-wide uppercase">
                        ENCIK MOHD ZAIHAM IZWAN
                    </h3>
                </div>
                <div class="text-right space-y-0.5 text-xs text-stone-600">
                    <p>Senior Assistant Registrar N44</p>
                    <p>+605-4505202</p>
                    <p>zaiham_izwan@upsi.edu.my</p>
                    <p class="text-stone-500 pt-1">Pusat Transformasi dan Komuniti UCTC, UPSI</p>
                </div>
            </div>

            
            <div class="bg-white border border-stone-300 rounded-2xl p-6 shadow-xs">
                <div class="border-b border-stone-400 pb-2 mb-3">
                    <h3 class="font-bold text-stone-900 text-lg tracking-wide uppercase">
                        ENCIK AMIN
                    </h3>
                </div>
                <div class="text-right space-y-0.5 text-xs text-stone-600">
                    <p>General Officer</p>
                    <p>+6012-3456789</p>
                    <p>amin.upsi@gmail.com</p>
                    <p class="text-stone-500 pt-1">Pusat Transformasi dan Komuniti UCTC, UPSI</p>
                </div>
            </div>

        </div>
    </main>

    
    <footer class="bg-stone-200 text-center py-4 text-[11px] text-stone-400 border-t border-stone-300 mt-auto">
        &copy; {{ date('Y') }} EduForest UCTC UPSI.
    </footer>

</body>
</html>