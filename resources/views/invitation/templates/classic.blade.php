<!DOCTYPE html>
<html lang="id">
<head>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=Montserrat:wght@300;400;500&display=swap');

    :root {
        --gold: #D4AF37;
        --gold-soft: #E8D28A;
        --dark: #0F0F0F;
        --dark-soft: #1B1B1B;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        background: #0f0f0f;
        overflow-x: hidden;
    }

    .font-serif-elegant {
        font-family: 'Cormorant Garamond', serif;
    }

    .font-sans-light {
        font-family: 'Montserrat', sans-serif;
    }

    .gold-text {
        color: var(--gold);
    }

    .gold-border {
        border-color: rgba(212,175,55,.4);
    }

    .gold-gradient {
        background: linear-gradient(
            135deg,
            #D4AF37,
            #F4E29A,
            #D4AF37
        );
    }

    .glass {
        background: rgba(255,255,255,.05);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,.08);
    }

    .hero-overlay {
        background:
            linear-gradient(
                to bottom,
                rgba(0,0,0,.5),
                rgba(0,0,0,.7),
                rgba(0,0,0,.9)
            );
    }

    .fade-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all .8s ease;
    }

    .fade-up.show {
        opacity: 1;
        transform: translateY(0);
    }

    .petal {
        position: fixed;
        top: -50px;
        z-index: 100;
        pointer-events: none;
        animation: falling linear infinite;
        opacity: .5;
    }

    @keyframes falling {
        from {
            transform:
                translateY(-50px)
                rotate(0deg);
        }

        to {
            transform:
                translateY(110vh)
                rotate(360deg);
        }
    }

    .gold-btn {
        background: linear-gradient(
            135deg,
            #D4AF37,
            #F4E29A
        );

        color: #111;
        font-weight: 500;
    }

    .gold-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(212,175,55,.3);
    }

    .ornament {
        opacity: .12;
        filter: blur(.5px);
    }

    .hero-title {
        text-shadow:
            0 0 20px rgba(212,175,55,.25);
    }

    .luxury-divider {
        width: 120px;
        height: 1px;
        margin: auto;
        background: linear-gradient(
            to right,
            transparent,
            var(--gold),
            transparent
        );
    }
</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $content->groom_name ?? '' }} & {{ $content->bride_name ?? '' }} - {{ $event->nama_event }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Montserrat:wght@300;400;500&display=swap');
        .font-serif-elegant { font-family: 'Cormorant Garamond', serif; }
        .font-sans-light { font-family: 'Montserrat', sans-serif; }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="font-sans-light bg-stone-50 text-stone-800">

    <div
        id="opening-screen"
        class="fixed inset-0 z-[9999] bg-black flex items-center justify-center px-6">

        <div class="text-center max-w-md">

            <p class="uppercase tracking-[0.4em] text-xs text-stone-500 mb-6">
                Wedding Invitation
            </p>

            <div class="luxury-divider mb-6"></div>

            <h1
                class="font-serif-elegant text-5xl text-white mb-3"
            >
                {{ $content->groom_name }}
            </h1>

            <p class="gold-text text-2xl mb-3">&</p>

            <h1
                class="font-serif-elegant text-5xl text-white mb-8"
            >
                {{ $content->bride_name }}
            </h1>

            <p class="text-stone-400 text-sm mb-2">
                Kepada Yth.
            </p>

            <p
                class="font-serif-elegant text-2xl text-white mb-10"
            >
                {{ $guest->nama_utama }}
            </p>

            <button
                id="openInvitation"
                class="gold-btn px-8 py-3 rounded-full transition"
            >
                Buka Undangan
            </button>

        </div>

    </div>

    <audio id="bgMusic" loop>
        <source
            src="{{ asset('music/wedding.mp3') }}"
            type="audio/mpeg"
        >
    </audio>

    {{-- HERO --}}
    <section
        class="relative min-h-screen flex items-center justify-center overflow-hidden"
    >

        {{-- Background --}}
        <div class="absolute inset-0">

            @if($content?->hero_photo)

                <img
                    src="{{ asset('storage/' . $content->hero_photo) }}"
                    class="w-full h-full object-cover scale-110"
                >

            @endif

            <div class="absolute inset-0 hero-overlay"></div>

        </div>

        {{-- Ornament --}}
        <div
            class="absolute top-0 left-0 w-48 md:w-72 ornament"
        >
            🌿
        </div>

        <div
            class="absolute bottom-0 right-0 w-48 md:w-72 ornament"
        >
            🌿
        </div>

        <div
            class="relative z-10 text-center px-8 max-w-xl"
        >

            <p
                class="uppercase tracking-[0.5em] text-xs text-stone-400 mb-6"
            >
                The Wedding Of
            </p>

            <div class="luxury-divider mb-8"></div>

            <h1
                class="hero-title font-serif-elegant text-white text-6xl md:text-8xl leading-none"
            >
                {{ $content->groom_name }}
            </h1>

            <p
                class="gold-text text-4xl my-5"
            >
                &
            </p>

            <h1
                class="hero-title font-serif-elegant text-white text-6xl md:text-8xl leading-none"
            >
                {{ $content->bride_name }}
            </h1>

            <div class="luxury-divider my-8"></div>

            <p
                class="text-stone-300 tracking-widest uppercase text-xs"
            >
                {{ $event->tanggal->format('d F Y') }}
            </p>

            <p
                class="text-stone-500 text-sm mt-3"
            >
                {{ $event->lokasi }}
            </p>

        </div>

        <div
            class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce"
        >
            <svg
                class="w-6 h-6 text-yellow-500"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M19 9l-7 7-7-7"
                />
            </svg>
        </div>

    </section>

    {{-- COUNTDOWN --}}
    <section
        id="countdown"
        class="py-24 px-6 bg-[#111111]"
    >

        <div class="max-w-5xl mx-auto">

            <div class="text-center mb-12 fade-up">

                <p
                    class="uppercase tracking-[0.4em] text-xs text-stone-500 mb-4"
                >
                    Counting Down
                </p>

                <h2
                    class="font-serif-elegant text-white text-4xl"
                >
                    Hari Bahagia
                </h2>

                <div class="luxury-divider mt-6"></div>

            </div>

            <div
                class="grid grid-cols-2 md:grid-cols-4 gap-4"
            >

                <div class="glass rounded-3xl p-6 text-center">
                    <p id="days" class="text-5xl gold-text font-serif-elegant">00</p>
                    <p class="text-xs uppercase tracking-widest text-stone-500 mt-2">Hari</p>
                </div>

                <div class="glass rounded-3xl p-6 text-center">
                    <p id="hours" class="text-5xl gold-text font-serif-elegant">00</p>
                    <p class="text-xs uppercase tracking-widest text-stone-500 mt-2">Jam</p>
                </div>

                <div class="glass rounded-3xl p-6 text-center">
                    <p id="minutes" class="text-5xl gold-text font-serif-elegant">00</p>
                    <p class="text-xs uppercase tracking-widest text-stone-500 mt-2">Menit</p>
                </div>

                <div class="glass rounded-3xl p-6 text-center">
                    <p id="seconds" class="text-5xl gold-text font-serif-elegant">00</p>
                    <p class="text-xs uppercase tracking-widest text-stone-500 mt-2">Detik</p>
                </div>

            </div>

        </div>

    </section>

    {{-- PENGANTIN --}}
    @if($content?->groom_photo || $content?->bride_photo)
    <section
        class="bg-black py-24 px-6"
    >

        <div class="max-w-5xl mx-auto">

            <div class="text-center mb-14 fade-up">

                <p class="uppercase tracking-[0.4em] text-xs text-stone-500 mb-4">
                    Bride & Groom
                </p>

                <h2 class="font-serif-elegant text-white text-4xl">
                    Mempelai
                </h2>

                <div class="luxury-divider mt-6"></div>

            </div>

            <div
                class="grid md:grid-cols-3 items-center gap-10"
            >

                <div class="text-center fade-up">

                    <div
                        class="w-52 h-52 mx-auto rounded-full overflow-hidden border-4 border-yellow-700 shadow-2xl"
                    >
                        <img
                            src="{{ asset('storage/' . $content->groom_photo) }}"
                            class="w-full h-full object-cover"
                        >
                    </div>

                    <h3
                        class="text-white text-4xl font-serif-elegant mt-6"
                    >
                        {{ $content->groom_name }}
                    </h3>

                </div>

                <div
                    class="text-center text-7xl gold-text font-serif-elegant"
                >
                    &
                </div>

                <div class="text-center fade-up">

                    <div
                        class="w-52 h-52 mx-auto rounded-full overflow-hidden border-4 border-yellow-700 shadow-2xl"
                    >
                        <img
                            src="{{ asset('storage/' . $content->bride_photo) }}"
                            class="w-full h-full object-cover"
                        >
                    </div>

                    <h3
                        class="text-white text-4xl font-serif-elegant mt-6"
                    >
                        {{ $content->bride_name }}
                    </h3>

                </div>

            </div>

        </div>

    </section>
    @endif

    {{-- INFO ACARA --}}
    <section
    class="bg-[#111111] py-24 px-6"
>

    <div class="max-w-5xl mx-auto">

        <div class="text-center mb-14">

            <p class="uppercase tracking-[0.4em] text-xs text-stone-500 mb-4">
                Wedding Event
            </p>

            <h2 class="text-white text-4xl font-serif-elegant">
                Detail Acara
            </h2>

            <div class="luxury-divider mt-6"></div>

        </div>

        <div
            class="grid md:grid-cols-2 gap-8"
        >

    {{-- LOVE STORY --}}
    @if($content?->love_story)
    <section class="py-20 px-8 bg-stone-50 text-center">
        <p class="text-xs tracking-[0.3em] uppercase text-stone-400 mb-4">Cerita Kami</p>
        <div class="max-w-md mx-auto">
            @if($content->first_met_date || $content->engagement_date)
            <div class="flex justify-center gap-8 mb-10">
                @if($content->first_met_date)
                <div>
                    <p class="font-serif-elegant text-2xl text-stone-800">{{ $content->first_met_date->format('Y') }}</p>
                    <p class="text-xs text-stone-400 tracking-widest uppercase">Pertama Bertemu</p>
                </div>
                @endif
                @if($content->engagement_date)
                <div>
                    <p class="font-serif-elegant text-2xl text-stone-800">{{ $content->engagement_date->format('Y') }}</p>
                    <p class="text-xs text-stone-400 tracking-widest uppercase">Lamaran</p>
                </div>
                @endif
                <div>
                    <p class="font-serif-elegant text-2xl text-stone-800">{{ $event->tanggal->format('Y') }}</p>
                    <p class="text-xs text-stone-400 tracking-widest uppercase">Pernikahan</p>
                </div>
            </div>
            @endif
            <p class="font-serif-elegant italic text-stone-600 text-lg leading-relaxed">
                {{ $content->love_story }}
            </p>
        </div>
    </section>
    @endif

    {{-- GALERI --}}
    @if($galleries->isNotEmpty())
    <section class="py-20 bg-white">
        <p class="text-xs tracking-[0.3em] uppercase text-stone-400 text-center mb-10">Galeri</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-1 max-w-2xl mx-auto px-4">
            @foreach($galleries as $photo)
            <div class="aspect-square overflow-hidden">
                <img src="{{ asset('storage/' . $photo->photo) }}" class="w-full h-full object-cover hover:scale-105 transition duration-500" />
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- QR CODE TAMU --}}
    <section class="py-20 px-8 bg-stone-50 text-center" id="qr-section">
        <p class="text-xs tracking-[0.3em] uppercase text-stone-400 mb-2">Tiket Masuk</p>
        <p class="font-serif-elegant text-stone-500 italic mb-1">Kepada Yth.</p>
        <p class="font-serif-elegant text-3xl text-stone-800 mb-1">{{ $guest->nama_utama }}</p>
        <p class="text-sm text-stone-400 mb-8">{{ $guest->jumlah_tamu }} tamu</p>

        <div class="inline-block p-4 bg-white border border-stone-200 rounded-3xl shadow-sm mb-4">
            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->format('svg')->generate($guest->qr_code) !!}
        </div>

        <p class="text-xs text-stone-300 mb-2">#{{ $guest->nomor_undangan ?? substr($guest->qr_code, 0, 8) }}</p>

        @if($guest->status !== 'terdaftar')
            <div class="inline-block bg-green-50 border border-green-100 rounded-2xl px-6 py-3 mt-4">
                <p class="text-green-700 text-sm font-medium">✓ Sudah check-in</p>
            </div>
        @else
            <p class="text-xs text-stone-400 mt-2">Tunjukkan QR ini kepada petugas saat tiba</p>
        @endif
    </section>

    {{-- CLOSING --}}
    @if($content?->closing_quote)
    <section class="py-16 px-8 bg-stone-800 text-center">
        <p class="font-serif-elegant italic text-white/70 text-xl max-w-sm mx-auto leading-relaxed">
            "{{ $content->closing_quote }}"
        </p>
        <p class="text-white/30 text-xs mt-6 tracking-widest uppercase">
            {{ $content->groom_name }} & {{ $content->bride_name }}
        </p>
    </section>
    @endif

    <footer class="py-6 text-center bg-stone-900">
        <p class="text-stone-600 text-xs">Powered by GuestBook Digital</p>
    </footer>

    <script>
        // Countdown
        const eventDate = new Date("{{ $event->tanggal->format('Y-m-d') }}T00:00:00");
        function updateCountdown() {
            const now = new Date();
            const diff = eventDate - now;
            if (diff <= 0) {
                document.getElementById('countdown').innerHTML = '<p class="font-serif-elegant text-2xl text-stone-800 col-span-4">Hari Bahagia Telah Tiba 🎉</p>';
                return;
            }
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            document.getElementById('days').textContent = String(days).padStart(2, '0');
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
        }
        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>

    <div
        class="fixed bottom-5 left-1/2 -translate-x-1/2 z-50"
    >

        <div
            class="glass rounded-full px-5 py-3 flex gap-5 text-white text-sm"
        >

            <a href="#countdown">
                ⏳
            </a>

            <a href="#story">
                ❤️
            </a>

            <a href="#gallery">
                📷
            </a>

            <a href="#qr-section">
                🎫
            </a>

        </div>

    </div>

    <script>

        const openBtn =
            document.getElementById('openInvitation');

        const openingScreen =
            document.getElementById('opening-screen');

        const bgMusic =
            document.getElementById('bgMusic');

        openBtn.addEventListener('click', () => {

            bgMusic.play();

            openingScreen.style.opacity = '0';

            setTimeout(() => {
                openingScreen.remove();
            }, 800);

        });

        for(let i=0;i<20;i++){

            const petal =
                document.createElement('div');

            petal.innerHTML = '✨';

            petal.classList.add('petal');

            petal.style.left =
                Math.random() * 100 + 'vw';

            petal.style.fontSize =
                (12 + Math.random() * 16) + 'px';

            petal.style.animationDuration =
                (12 + Math.random() * 12) + 's';

            document.body.appendChild(petal);

        }

        const observer =
        new IntersectionObserver(entries => {

            entries.forEach(entry => {

                if(entry.isIntersecting){
                    entry.target.classList.add('show');
                }

            });

        },{
            threshold:.1
        });

        document
        .querySelectorAll('.fade-up')
        .forEach(el => observer.observe(el));

        </script>
</body>
</html>