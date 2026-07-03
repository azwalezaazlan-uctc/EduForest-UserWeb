<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EduForest UCTC</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;800&display=swap');
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body class="bg-[#eef8f1] m-0 p-0 antialiased min-h-screen overflow-x-hidden">
    @php
        $dashboardProfile = DB::table('profiles')->where('id', Auth::id())->first();
        $userFullName = $dashboardProfile->full_name ?? Auth::user()->name;
        $profilePic = $dashboardProfile->profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($userFullName) . '&background=046307&color=fff';
    @endphp

    @include('profile.partials.topbar')

    <div id="contentWrapper" class="min-h-screen flex flex-col w-full bg-[radial-gradient(circle_at_top_left,#d8f3dc_0,#eef8f1_34%,#f8fbf7_72%)]">

        <main class="flex-1">
            
            <div id="heroSlider"
                class="relative mx-auto mt-6 h-[520px] w-[calc(100%-48px)] max-w-7xl flex items-center justify-center overflow-hidden rounded-[36px] shadow-[0_30px_80px_rgba(25,78,52,0.26)] transition-all duration-700"
                style="
                    background-image:
                    linear-gradient(rgba(0,0,0,.40),rgba(0,0,0,.40)),
                    url('https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/ACTIVITIES/DASHBOARD%20BACKGROUND/6170282320066187830.jpg');
                    background-size:cover;
                    background-position:center;
                    background-repeat:no-repeat;
                ">

                <button onclick="previousSlide()"
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-[#046307] text-white text-2xl transition z-20">
                    &#10094;
                </button>

                <div class="relative z-10 text-center">
                    <h1 class="text-5xl font-extrabold text-white uppercase drop-shadow-lg">
                        EDU-FOREST UPSI
                    </h1>

                    <a href="#about-eduforest"
                        class="inline-block mt-8 bg-[#046307] hover:bg-[#03500a] px-10 py-4 text-white font-bold rounded-full shadow-lg transition">
                        SEE MORE
                    </a>
                </div>

                <button onclick="nextSlide()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-[#046307] text-white text-2xl transition z-20">
                    &#10095;
                </button>
            </div>

            
            <div id="about-eduforest" class="py-16 bg-transparent">
                <div class="max-w-4xl mx-auto px-6">
                    <div class="my-2 rounded-[32px] border border-white/70 bg-white/80 p-8 shadow-[0_24px_70px_rgba(62,111,82,0.14)] backdrop-blur-xl">
                        <h2 class="text-2xl font-extrabold text-gray-950 tracking-tight mb-4 uppercase">About Edu-Forest</h2>
                        <div class="w-12 h-1.5 bg-[#046307] mb-6 rounded-full"></div>

                        <div class="space-y-4 text-sm text-gray-700 leading-relaxed font-medium">
                            <p class="text-justify">
                                Universiti Pendidikan Sultan Idris (UPSI) Edu-Forest is a 10-hectare living laboratory and eco-adventure destination located within the lush Behrang Forest Reserve near Tanjung Malim, on the edge of the magnificent Titiwangsa Range. Developed and managed by UPSI, Edu-Forest combines environmental education, biodiversity conservation, ecotourism, and outdoor recreation in a natural rainforest setting, making it a unique destination for both learning and adventure. The station was granted a 30-year land use license by the Jabatan Perhutanan Negeri Perak beginning on 14 May 2019.
                            </p>

                            <div id="more-about-text" class="hidden space-y-4">
                                <p class="text-justify">
                                    The area offers immersive nature-based experiences while also featuring stunning natural attractions. Beyond nature exploration, Edu-Forest is also known for its adrenaline-filled activities such as water tubing, jungle trekking, water confident, and many more. As a living lab, the site supports hands-on research and field studies in areas including biology, geography, environmental science, sports science, and ecotourism, providing students and researchers with real-world learning opportunities.
                                </p>
                                <p class="text-justify font-normal text-gray-700">
                                    Combining education, conservation, research, and adventure tourism, UPSI Edu-Forest serves as a gateway for people to reconnect with nature while promoting environmental awareness and sustainable ecosystem protection.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button id="read-more-btn" onclick="toggleReadMore()" class="inline-block border-2 border-[#046307] text-[#046307] hover:bg-[#046307] hover:text-white text-xs font-bold tracking-widest uppercase px-6 py-2.5 rounded-full transition duration-300 cursor-pointer">
                            Read More
                        </button>
                    </div>
                </div>
            </div>

        
        </main>
    </div>

    <script>
        function toggleReadMore() {
            const content = document.getElementById('more-about-text');
            const btn = document.getElementById('read-more-btn');

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                btn.textContent = 'Read Less';
            } else {
                content.classList.add('hidden');
                btn.textContent = 'Read More';
            }
        }

        const heroImages = [
            "https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/ACTIVITIES/DASHBOARD%20BACKGROUND/6170282320066187830.jpg",
            "https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/ACTIVITIES/DASHBOARD%20BACKGROUND/photo_2026-07-02_11-31-42.jpg",
            "https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/ACTIVITIES/DASHBOARD%20BACKGROUND/photo_2026-07-02_11-31-37.jpg",
            "https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/ACTIVITIES/DASHBOARD%20BACKGROUND/photo_2026-07-02_11-31-15.jpg"
        ];

        let currentSlide = 0;
        const heroSlider = document.getElementById("heroSlider");

        function showSlide(index) {
            if (!heroSlider) return;
            heroSlider.style.backgroundImage =
                `linear-gradient(rgba(0,0,0,.40), rgba(0,0,0,.40)), url('${heroImages[index]}')`;
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % heroImages.length;
            showSlide(currentSlide);
        }

        function previousSlide() {
            currentSlide = (currentSlide - 1 + heroImages.length) % heroImages.length;
            showSlide(currentSlide);
        }

        document.addEventListener("DOMContentLoaded", function () {
            showSlide(currentSlide);
            setInterval(nextSlide, 4000);
        });
    </script>

</body>
</html>