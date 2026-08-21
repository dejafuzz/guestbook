<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $content->groom_name ?? '' }} & {{ $content->bride_name ?? '' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { background: #0a0a0a; color: #e8e0d0; font-family: 'Montserrat', sans-serif; font-weight: 300; overflow-x: hidden; }
        .font-serif { font-family: 'Cormorant Garamond', serif; }

        /* Cover */
        #cover {
            position: fixed; inset: 0; z-index: 100;
            background: #0a0a0a;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: opacity 1.2s ease, visibility 1.2s ease;
        }
        #cover.hidden { opacity: 0; visibility: hidden; pointer-events: none; }

        /* Scroll reveal */
        .reveal {
            opacity: 0; transform: translateY(40px);
            transition: opacity 0.9s ease, transform 0.9s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.15s; }
        .reveal-delay-2 { transition-delay: 0.3s; }
        .reveal-delay-3 { transition-delay: 0.45s; }
        .reveal-delay-4 { transition-delay: 0.6s; }

        /* Divider */
        .gold-line {
            width: 60px; height: 0.5px;
            background: linear-gradient(90deg, transparent, #c9a96e, transparent);
            margin: 0 auto;
        }
        .gold-text { color: #c9a96e; }

        /* Music player */
        #music-btn {
            position: fixed; bottom: 24px; right: 24px; z-index: 200;
            width: 48px; height: 48px; border-radius: 50%;
            background: rgba(201,169,110,0.15);
            border: 1px solid rgba(201,169,110,0.4);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.3s;
            backdrop-filter: blur(10px);
        }
        #music-btn:hover { background: rgba(201,169,110,0.25); }
        #music-btn.playing .note-icon { animation: spin 4s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        /* Gallery */
        .gallery-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 4px; }
        .gallery-grid img { width: 100%; aspect-ratio: 1; object-fit: cover; transition: transform 0.5s; }
        .gallery-grid img:hover { transform: scale(1.03); }

        /* Countdown */
        .countdown-item { text-align: center; min-width: 60px; }

        /* QR section */
        .qr-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(201,169,110,0.2);
            border-radius: 24px;
        }

        /* Scroll indicator */
        .scroll-indicator {
            width: 24px; height: 40px;
            border: 1px solid rgba(201,169,110,0.5);
            border-radius: 12px;
            position: relative; margin: 0 auto;
        }
        .scroll-dot {
            width: 4px; height: 4px; border-radius: 50%;
            background: #c9a96e;
            position: absolute; left: 50%; top: 6px;
            transform: translateX(-50%);
            animation: scrollDown 2s infinite;
        }
        @keyframes scrollDown {
            0% { top: 6px; opacity: 1; }
            100% { top: 26px; opacity: 0; }
        }
    </style>
</head>
<body>

{{-- MUSIK --}}
@if($content?->music_file)
<audio id="bg-music" loop>
    <source src="{{ asset('storage/' . $content->music_file) }}" type="audio/mpeg">
</audio>
<button id="music-btn" title="Musik">
    <svg class="note-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#c9a96e" stroke-width="1.5">
        <path d="M9 18V5l12-2v13"/>
        <circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
    </svg>
</button>
@endif

{{-- COVER --}}
<div id="cover">
    <div style="text-align:center; padding: 0 2rem;">
        <p class="font-serif gold-text reveal" style="font-size:13px; letter-spacing: 0.3em; text-transform: uppercase; margin-bottom: 2rem;">
            The Wedding Of
        </p>
        <h1 class="font-serif" style="font-size: clamp(2.8rem, 10vw, 4.5rem); font-weight: 300; line-height: 1.1; color: #f0e8d8; margin-bottom: 0.5rem;">
            {{ $content->groom_name ?? 'Mempelai Pria' }}
        </h1>
        <p class="font-serif gold-text" style="font-size: 2rem; font-style: italic; margin-bottom: 0.5rem;">&</p>
        <h1 class="font-serif" style="font-size: clamp(2.8rem, 10vw, 4.5rem); font-weight: 300; line-height: 1.1; color: #f0e8d8; margin-bottom: 2rem;">
            {{ $content->bride_name ?? 'Mempelai Wanita' }}
        </h1>
        <div class="gold-line" style="margin-bottom: 2rem;"></div>
        <p style="font-size: 11px; letter-spacing: 0.25em; color: #8a7a6a; text-transform: uppercase; margin-bottom: 0.5rem;">
            {{ $event->tanggal->format('d F Y') }}
        </p>
        @if($event->lokasi)
        <p style="font-size: 11px; letter-spacing: 0.2em; color: #8a7a6a; text-transform: uppercase; margin-bottom: 3rem;">
            {{ $event->lokasi }}
        </p>
        @endif

        {{-- Kepada tamu --}}
        <div style="margin-bottom: 2.5rem; padding: 1rem 1.5rem; border: 1px solid rgba(201,169,110,0.15); border-radius: 12px;">
            <p style="font-size: 10px; letter-spacing: 0.2em; color: #8a7a6a; text-transform: uppercase; margin-bottom: 0.4rem;">Kepada Yth.</p>
            <p class="font-serif" style="font-size: 1.3rem; color: #f0e8d8;">{{ $guest->nama_utama }}</p>
            <p style="font-size: 11px; color: #8a7a6a; margin-top: 0.3rem;">{{ $guest->jumlah_tamu }} tamu undangan</p>
        </div>

        <button id="open-btn" style="
            background: transparent;
            border: 1px solid rgba(201,169,110,0.5);
            color: #c9a96e;
            font-family: 'Montserrat', sans-serif;
            font-size: 11px; font-weight: 400;
            letter-spacing: 0.3em; text-transform: uppercase;
            padding: 14px 36px; border-radius: 40px;
            cursor: pointer; transition: all 0.4s;
            margin-bottom: 3rem;
        ">
            Buka Undangan
        </button>

        <div class="scroll-indicator">
            <div class="scroll-dot"></div>
        </div>
    </div>
</div>

{{-- KONTEN UTAMA --}}
<div id="main-content" style="opacity: 0; transition: opacity 1s ease;">

    {{-- HERO --}}
    <section style="min-height: 100vh; position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden;">
        @if($content?->hero_photo)
        <div style="position: absolute; inset: 0;">
            <img src="{{ asset('storage/' . $content->hero_photo) }}" style="width:100%; height:100%; object-fit:cover; opacity:0.4;">
            <div style="position:absolute; inset:0; background: linear-gradient(to bottom, #0a0a0a 0%, transparent 30%, transparent 70%, #0a0a0a 100%);"></div>
        </div>
        @endif
        <div style="position: relative; text-align: center; padding: 6rem 2rem;">
            <p class="font-serif gold-text reveal" style="font-size: 13px; letter-spacing: 0.3em; text-transform: uppercase; margin-bottom: 1.5rem;">The Wedding Of</p>
            <h2 class="font-serif reveal reveal-delay-1" style="font-size: clamp(3rem, 12vw, 5rem); font-weight: 300; color: #f0e8d8; line-height: 1.1;">
                {{ $content->groom_name ?? '' }}
            </h2>
            <p class="font-serif gold-text reveal reveal-delay-2" style="font-size: 2.5rem; font-style: italic;">&</p>
            <h2 class="font-serif reveal reveal-delay-3" style="font-size: clamp(3rem, 12vw, 5rem); font-weight: 300; color: #f0e8d8; line-height: 1.1; margin-bottom: 2rem;">
                {{ $content->bride_name ?? '' }}
            </h2>
            <div class="gold-line reveal reveal-delay-4" style="margin-bottom: 1.5rem;"></div>
            <p class="reveal reveal-delay-4" style="font-size: 11px; letter-spacing: 0.25em; color: #8a7a6a; text-transform: uppercase;">
                {{ $event->tanggal->format('d F Y') }}
                @if($event->lokasi) &nbsp;·&nbsp; {{ $event->lokasi }} @endif
            </p>
        </div>
    </section>

    {{-- OPENING QUOTE --}}
    @if($content?->opening_quote)
    <section style="padding: 5rem 2rem; text-align: center; max-width: 480px; margin: 0 auto;">
        <div class="gold-line reveal" style="margin-bottom: 2rem;"></div>
        <p class="font-serif reveal reveal-delay-1" style="font-size: 1.15rem; font-style: italic; line-height: 1.9; color: #c8bfb0;">
            "{{ $content->opening_quote }}"
        </p>
        <div class="gold-line reveal reveal-delay-2" style="margin-top: 2rem;"></div>
    </section>
    @endif

    {{-- PENGANTIN --}}
    <section style="padding: 5rem 2rem;">
        <div style="max-width: 480px; margin: 0 auto; text-align: center;">
            <p class="gold-text reveal" style="font-size: 10px; letter-spacing: 0.35em; text-transform: uppercase; margin-bottom: 3rem;">Mempelai</p>

            <div style="display: flex; flex-direction: column; gap: 3rem;">
                {{-- Pria --}}
                <div class="reveal">
                    @if($content?->groom_photo)
                    <div style="width: 140px; height: 140px; border-radius: 50%; overflow: hidden; margin: 0 auto 1.2rem; border: 1px solid rgba(201,169,110,0.3);">
                        <img src="{{ asset('storage/' . $content->groom_photo) }}" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    @endif
                    <h3 class="font-serif" style="font-size: 1.8rem; font-weight: 300; color: #f0e8d8; margin-bottom: 0.3rem;">{{ $content->groom_name }}</h3>
                    <div class="gold-line" style="width: 40px; margin: 0.8rem auto;"></div>
                </div>

                <p class="font-serif gold-text reveal" style="font-size: 2rem; font-style: italic;">&</p>

                {{-- Wanita --}}
                <div class="reveal">
                    @if($content?->bride_photo)
                    <div style="width: 140px; height: 140px; border-radius: 50%; overflow: hidden; margin: 0 auto 1.2rem; border: 1px solid rgba(201,169,110,0.3);">
                        <img src="{{ asset('storage/' . $content->bride_photo) }}" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    @endif
                    <h3 class="font-serif" style="font-size: 1.8rem; font-weight: 300; color: #f0e8d8; margin-bottom: 0.3rem;">{{ $content->bride_name }}</h3>
                    <div class="gold-line" style="width: 40px; margin: 0.8rem auto;"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- COUNTDOWN --}}
    <section style="padding: 5rem 2rem; text-align: center;">
        <div style="max-width: 480px; margin: 0 auto;">
            <p class="gold-text reveal" style="font-size: 10px; letter-spacing: 0.35em; text-transform: uppercase; margin-bottom: 3rem;">Menuju Hari Bahagia</p>
            <div class="reveal" style="display: flex; justify-content: center; gap: 1.5rem;" id="countdown-wrap">
                @foreach(['days' => 'Hari', 'hours' => 'Jam', 'minutes' => 'Menit', 'seconds' => 'Detik'] as $key => $label)
                <div class="countdown-item">
                    <p class="font-serif" style="font-size: 2.8rem; font-weight: 300; color: #c9a96e; line-height: 1;" id="{{ $key }}">--</p>
                    <p style="font-size: 9px; letter-spacing: 0.2em; color: #8a7a6a; text-transform: uppercase; margin-top: 0.5rem;">{{ $label }}</p>
                </div>
                @if($key !== 'seconds')
                <p class="font-serif" style="font-size: 2rem; color: rgba(201,169,110,0.3); align-self: flex-start; margin-top: 0.3rem;">·</p>
                @endif
                @endforeach
            </div>
        </div>
    </section>

    {{-- INFO ACARA --}}
    @if($content?->akad_datetime || $content?->reception_datetime)
    <section style="padding: 5rem 2rem;">
        <div style="max-width: 480px; margin: 0 auto; text-align: center;">
            <p class="gold-text reveal" style="font-size: 10px; letter-spacing: 0.35em; text-transform: uppercase; margin-bottom: 3rem;">Informasi Acara</p>

            @if($content->akad_datetime)
            <div class="reveal" style="margin-bottom: 2.5rem; padding: 2rem; border: 1px solid rgba(201,169,110,0.15); border-radius: 16px;">
                <p class="gold-text" style="font-size: 10px; letter-spacing: 0.3em; text-transform: uppercase; margin-bottom: 1rem;">Akad Nikah</p>
                <p class="font-serif" style="font-size: 1.4rem; color: #f0e8d8; margin-bottom: 0.5rem;">{{ $content->akad_location }}</p>
                <p style="font-size: 12px; color: #8a7a6a; margin-bottom: 0.3rem;">{{ $content->akad_datetime->format('l, d F Y') }}</p>
                <p style="font-size: 12px; color: #8a7a6a; margin-bottom: 1rem;">{{ $content->akad_datetime->format('H:i') }} WIB</p>
                @if($content->akad_address)
                <p style="font-size: 11px; color: #6a5a4a; line-height: 1.6; margin-bottom: 1rem;">{{ $content->akad_address }}</p>
                @endif
                @if($content->akad_maps_url)
                <a href="{{ $content->akad_maps_url }}" target="_blank" style="display: inline-block; font-size: 10px; letter-spacing: 0.2em; text-transform: uppercase; color: #c9a96e; border: 1px solid rgba(201,169,110,0.4); padding: 8px 20px; border-radius: 20px; text-decoration: none;">
                    Lihat Peta
                </a>
                @endif
            </div>
            @endif

            @if($content->reception_datetime)
            <div class="reveal" style="padding: 2rem; border: 1px solid rgba(201,169,110,0.15); border-radius: 16px;">
                <p class="gold-text" style="font-size: 10px; letter-spacing: 0.3em; text-transform: uppercase; margin-bottom: 1rem;">Resepsi</p>
                <p class="font-serif" style="font-size: 1.4rem; color: #f0e8d8; margin-bottom: 0.5rem;">{{ $content->reception_location }}</p>
                <p style="font-size: 12px; color: #8a7a6a; margin-bottom: 0.3rem;">{{ $content->reception_datetime->format('l, d F Y') }}</p>
                <p style="font-size: 12px; color: #8a7a6a; margin-bottom: 1rem;">{{ $content->reception_datetime->format('H:i') }} WIB</p>
                @if($content->reception_address)
                <p style="font-size: 11px; color: #6a5a4a; line-height: 1.6; margin-bottom: 1rem;">{{ $content->reception_address }}</p>
                @endif
                @if($content->reception_maps_url)
                <a href="{{ $content->reception_maps_url }}" target="_blank" style="display: inline-block; font-size: 10px; letter-spacing: 0.2em; text-transform: uppercase; color: #c9a96e; border: 1px solid rgba(201,169,110,0.4); padding: 8px 20px; border-radius: 20px; text-decoration: none;">
                    Lihat Peta
                </a>
                @endif
            </div>
            @endif
        </div>
    </section>
    @endif

    {{-- LOVE STORY --}}
    @if($content?->love_story)
    <section style="padding: 5rem 2rem;">
        <div style="max-width: 480px; margin: 0 auto; text-align: center;">
            <p class="gold-text reveal" style="font-size: 10px; letter-spacing: 0.35em; text-transform: uppercase; margin-bottom: 3rem;">Our Story</p>

            @if($content->first_met_date || $content->engagement_date)
            <div class="reveal" style="display: flex; justify-content: center; gap: 2rem; margin-bottom: 3rem;">
                @if($content->first_met_date)
                <div style="text-align: center;">
                    <p class="font-serif gold-text" style="font-size: 1.8rem; font-weight: 300;">{{ $content->first_met_date->format('Y') }}</p>
                    <p style="font-size: 9px; letter-spacing: 0.2em; color: #6a5a4a; text-transform: uppercase; margin-top: 0.3rem;">Bertemu</p>
                </div>
                <div style="align-self: center; width: 30px; height: 0.5px; background: rgba(201,169,110,0.3);"></div>
                @endif
                @if($content->engagement_date)
                <div style="text-align: center;">
                    <p class="font-serif gold-text" style="font-size: 1.8rem; font-weight: 300;">{{ $content->engagement_date->format('Y') }}</p>
                    <p style="font-size: 9px; letter-spacing: 0.2em; color: #6a5a4a; text-transform: uppercase; margin-top: 0.3rem;">Lamaran</p>
                </div>
                <div style="align-self: center; width: 30px; height: 0.5px; background: rgba(201,169,110,0.3);"></div>
                @endif
                <div style="text-align: center;">
                    <p class="font-serif gold-text" style="font-size: 1.8rem; font-weight: 300;">{{ $event->tanggal->format('Y') }}</p>
                    <p style="font-size: 9px; letter-spacing: 0.2em; color: #6a5a4a; text-transform: uppercase; margin-top: 0.3rem;">Menikah</p>
                </div>
            </div>
            @endif

            <p class="font-serif reveal reveal-delay-1" style="font-size: 1.05rem; font-style: italic; line-height: 2; color: #a89880;">
                {{ $content->love_story }}
            </p>
        </div>
    </section>
    @endif

    {{-- GALERI --}}
    @if($galleries->isNotEmpty())
    <section style="padding: 5rem 0;">
        <div style="text-align: center; padding: 0 2rem; margin-bottom: 2.5rem;">
            <p class="gold-text reveal" style="font-size: 10px; letter-spacing: 0.35em; text-transform: uppercase;">Gallery</p>
        </div>
        <div class="gallery-grid reveal" style="max-width: 480px; margin: 0 auto; padding: 0 4px;">
            @foreach($galleries as $photo)
            <div style="overflow: hidden;">
                <img src="{{ asset('storage/' . $photo->photo) }}" alt="Gallery">
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- QR CODE --}}
    <section style="padding: 5rem 2rem;" id="qr-section">
        <div style="max-width: 380px; margin: 0 auto;">
            <div class="qr-card reveal" style="padding: 2.5rem; text-align: center;">
                <p class="gold-text" style="font-size: 10px; letter-spacing: 0.35em; text-transform: uppercase; margin-bottom: 0.5rem;">Tiket Kehadiran</p>
                <div class="gold-line" style="margin-bottom: 2rem;"></div>

                <p class="font-serif" style="font-size: 11px; color: #6a5a4a; letter-spacing: 0.1em; margin-bottom: 0.4rem;">Kepada Yth.</p>
                <p class="font-serif" style="font-size: 1.6rem; color: #f0e8d8; margin-bottom: 0.3rem;">{{ $guest->nama_utama }}</p>
                <p style="font-size: 11px; color: #6a5a4a; margin-bottom: 2rem;">{{ $guest->jumlah_tamu }} tamu</p>

                <div style="display: inline-block; padding: 16px; background: white; border-radius: 16px; margin-bottom: 1.5rem;">
                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(180)->format('svg')->generate($guest->qr_code) !!}
                </div>

                <p style="font-size: 10px; color: #4a3a2a; letter-spacing: 0.15em; margin-bottom: 1.5rem;">
                    #{{ $guest->nomor_undangan ?? substr($guest->qr_code, 0, 8) }}
                </p>

                @if($guest->status !== 'terdaftar')
                <div style="background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); border-radius: 12px; padding: 10px 20px; display: inline-block;">
                    <p style="color: #6ee7b7; font-size: 12px;">✓ Sudah check-in</p>
                </div>
                @else
                <p style="font-size: 10px; color: #6a5a4a; letter-spacing: 0.1em;">Tunjukkan QR ini kepada petugas saat tiba</p>
                @endif

                <div class="gold-line" style="margin-top: 2rem;"></div>
            </div>
        </div>
    </section>

    {{-- CLOSING --}}
    @if($content?->closing_quote)
    <section style="padding: 5rem 2rem; text-align: center;">
        <div style="max-width: 420px; margin: 0 auto;">
            <div class="gold-line reveal" style="margin-bottom: 2.5rem;"></div>
            <p class="font-serif reveal reveal-delay-1" style="font-size: 1.1rem; font-style: italic; line-height: 1.9; color: #a89880; margin-bottom: 2rem;">
                "{{ $content->closing_quote }}"
            </p>
            <p class="font-serif reveal reveal-delay-2" style="font-size: 1.6rem; font-weight: 300; color: #f0e8d8;">
                {{ $content->groom_name }} & {{ $content->bride_name }}
            </p>
            <p class="reveal reveal-delay-3" style="font-size: 10px; color: #6a5a4a; letter-spacing: 0.2em; text-transform: uppercase; margin-top: 0.5rem;">beserta keluarga</p>
            <div class="gold-line reveal reveal-delay-4" style="margin-top: 2.5rem;"></div>
        </div>
    </section>
    @endif

    <footer style="padding: 2rem; text-align: center;">
        <p style="font-size: 10px; color: #3a2a1a; letter-spacing: 0.2em; text-transform: uppercase;">Powered by GuestBook Digital</p>
    </footer>

</div>

<script>
    // Cover → buka undangan
    const openBtn = document.getElementById('open-btn');
    const cover = document.getElementById('cover');
    const mainContent = document.getElementById('main-content');

    openBtn.addEventListener('click', () => {
        cover.classList.add('hidden');
        mainContent.style.opacity = '1';
        document.body.style.overflow = 'auto';

        @if($content?->music_file)
        const music = document.getElementById('bg-music');
        if (music) { music.volume = 0.5; music.play().catch(() => {}); }
        @endif

        setTimeout(() => { window.scrollTo({ top: 0, behavior: 'smooth' }); }, 200);
    });

    // Prevent scroll saat cover aktif
    document.body.style.overflow = 'hidden';

    // Scroll reveal
    const revealEls = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });

    revealEls.forEach(el => observer.observe(el));

    // Countdown
    const eventDate = new Date("{{ $event->tanggal->format('Y-m-d') }}T00:00:00");
    function updateCountdown() {
        const now = new Date();
        const diff = eventDate - now;
        if (diff <= 0) {
            document.getElementById('countdown-wrap').innerHTML =
                '<p class="font-serif gold-text" style="font-size:1.5rem; font-style:italic;">Hari Bahagia Telah Tiba ✨</p>';
            return;
        }
        document.getElementById('days').textContent    = String(Math.floor(diff / 86400000)).padStart(2,'0');
        document.getElementById('hours').textContent   = String(Math.floor((diff % 86400000) / 3600000)).padStart(2,'0');
        document.getElementById('minutes').textContent = String(Math.floor((diff % 3600000) / 60000)).padStart(2,'0');
        document.getElementById('seconds').textContent = String(Math.floor((diff % 60000) / 1000)).padStart(2,'0');
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);

    // Music toggle
    @if($content?->music_file)
    const musicBtn = document.getElementById('music-btn');
    const bgMusic = document.getElementById('bg-music');
    let isPlaying = false;

    musicBtn.addEventListener('click', () => {
        if (isPlaying) {
            bgMusic.pause();
            musicBtn.classList.remove('playing');
        } else {
            bgMusic.play();
            musicBtn.classList.add('playing');
        }
        isPlaying = !isPlaying;
    });
    @endif
</script>

</body>
</html>