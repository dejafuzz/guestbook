<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $content->groom_name ?? '' }}
        &
        {{ $content->bride_name ?? '' }}
    </title>

    @vite([
        'resources/css/luxury-wedding.css',
        'resources/js/luxury-wedding.js'
    ])

</head>

<body>

    {{-- OPENING SCREEN --}}
    <div id="opening-screen">

        <div class="opening-content">

            <span class="opening-label">
                The Wedding Of
            </span>

            <div class="divider"></div>

            <h1 class="opening-groom">
                {{ $content->groom_name }}
            </h1>

            <span class="opening-ampersand">
                &
            </span>

            <h1 class="opening-bride">
                {{ $content->bride_name }}
            </h1>

            <div class="guest-box">

                <p>Kepada Yth.</p>

                <h3>
                    {{ $guest->nama_utama }}
                </h3>

            </div>

            <button id="openInvitation">
                Buka Undangan
            </button>

        </div>

    </div>

    {{-- BACKGROUND MUSIC --}}
    <audio id="bgMusic" loop>

        <source
            src="{{ asset('music/wedding.mp3') }}"
            type="audio/mpeg">

    </audio>

        <section id="hero">

        <div class="hero-background">

            @if($content?->hero_photo)

                <img
                    src="{{ asset('storage/' . $content->hero_photo) }}"
                    alt="Hero">

            @endif

            <div class="hero-overlay"></div>

        </div>

        <div class="hero-content">

            <p class="hero-label">
                Wedding Invitation
            </p>

            <div class="divider"></div>

            <h1 class="hero-name">
                {{ $content->groom_name }}
            </h1>

            <span class="hero-ampersand">
                &
            </span>

            <h1 class="hero-name">
                {{ $content->bride_name }}
            </h1>

            <div class="divider"></div>

            <p class="hero-date">

                {{ $event->tanggal->translatedFormat('d F Y') }}

            </p>

            @if($event->lokasi)

                <p class="hero-location">

                    {{ $event->lokasi }}

                </p>

            @endif

        </div>

        <div class="scroll-indicator">

            <svg
                width="28"
                height="28"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M19 9l-7 7-7-7" />

            </svg>

        </div>

    </section>

    {{-- count down section --}}

    <section 
        id="countdown"
        data-date="{{ $event->tanggal->format('Y-m-d') }} 00:00:00">

        <div class="section-header">

            <span>
                Counting Down
            </span>

            <h2>
                Hari Bahagia
            </h2>

        </div>

        <div class="countdown-grid">

            <div class="countdown-card">

                <h3 id="days">
                    00
                </h3>

                <p>Hari</p>

            </div>

            <div class="countdown-card">

                <h3 id="hours">
                    00
                </h3>

                <p>Jam</p>

            </div>

            <div class="countdown-card">

                <h3 id="minutes">
                    00
                </h3>

                <p>Menit</p>

            </div>

            <div class="countdown-card">

                <h3 id="seconds">
                    00
                </h3>

                <p>Detik</p>

            </div>

        </div>

    </section>


    {{-- couple section --}}

    <section id="couple">

        <div class="section-header">

            <span>
                Bride & Groom
            </span>

            <h2>
                Mempelai
            </h2>

        </div>

        <div class="couple-grid">

            <div class="couple-card">

                @if($content?->groom_photo)

                    <div class="couple-image">

                        <img
                            src="{{ asset('storage/' . $content->groom_photo) }}"
                            alt="Groom">

                    </div>

                @endif

                <h3>

                    {{ $content->groom_name }}

                </h3>

            </div>

            <div class="couple-symbol">

                &

            </div>

            <div class="couple-card">

                @if($content?->bride_photo)

                    <div class="couple-image">

                        <img
                            src="{{ asset('storage/' . $content->bride_photo) }}"
                            alt="Bride">

                    </div>

                @endif

                <h3>

                    {{ $content->bride_name }}

                </h3>

            </div>

        </div>

    </section>


    {{-- event information section --}}

    <section id="event-info">

        <div class="section-header">

            <span>
                Wedding Event
            </span>

            <h2>
                Informasi Acara
            </h2>

        </div>

        <div class="event-grid">

        @if($content?->akad_datetime)

        <div class="event-card">

            <div class="event-icon">
                💍
            </div>

            <h3>
                Akad Nikah
            </h3>

            <p>

                {{ $content->akad_location }}

            </p>

            <small>

                {{ $content->akad_datetime->translatedFormat('d F Y H:i') }}

            </small>

            @if($content->akad_maps_url)

                <a
                    href="{{ $content->akad_maps_url }}"
                    target="_blank">

                    Lihat Lokasi

                </a>

            @endif
        </div>
        @endif

        @if($content?->reception_datetime)
        <div class="event-card">

            <div class="event-icon">
                🥂
            </div>

            <h3>
                Resepsi
            </h3>

            <p>

                {{ $content->reception_location }}

            </p>

            <small>

                {{ $content->reception_datetime->translatedFormat('d F Y H:i') }}

            </small>

            @if($content->reception_maps_url)

                <a
                    href="{{ $content->reception_maps_url }}"
                    target="_blank">

                    Lihat Lokasi

                </a>

            @endif
        </div>
        @endif

        </div>

    </section>

    {{-- love story timeline section --}}
    @if($content?->love_story)

    <section id="story">

        <div class="section-header">

            <span>
                Our Journey
            </span>

            <h2>
                Cerita Kami
            </h2>

        </div>

        <div class="timeline">

            @if($content->first_met_date)

            <div class="timeline-item">

                <div class="timeline-dot"></div>

                <div class="timeline-content">

                    <span class="timeline-year">

                        {{ $content->first_met_date->format('Y') }}

                    </span>

                    <h3>
                        Pertama Bertemu
                    </h3>

                    <p>
                        Awal perjalanan kami dimulai.
                    </p>

                </div>

            </div>

            @endif

            @if($content->engagement_date)

            <div class="timeline-item">

                <div class="timeline-dot"></div>

                <div class="timeline-content">

                    <span class="timeline-year">

                        {{ $content->engagement_date->format('Y') }}

                    </span>

                    <h3>
                        Lamaran
                    </h3>

                    <p>
                        Momen ketika kami memutuskan melangkah ke tahap yang lebih serius.
                    </p>

                </div>

            </div>

            @endif

            <div class="timeline-item">

                <div class="timeline-dot"></div>

                <div class="timeline-content">

                    <span class="timeline-year">

                        {{ $event->tanggal->format('Y') }}

                    </span>

                    <h3>
                        Pernikahan
                    </h3>

                    <p>
                        Awal dari perjalanan hidup baru kami bersama.
                    </p>

                </div>

            </div>

        </div>

        <div class="love-story-text">

            <p>

                {{ $content->love_story }}

            </p>

        </div>

    </section>

    @endif

    {{-- gallery section --}}
    @if($galleries->isNotEmpty())

    <section id="gallery">

        <div class="section-header">

            <span>
                Gallery
            </span>

            <h2>
                Momen Bahagia
            </h2>

        </div>

        <div class="gallery-grid">

            @foreach($galleries as $photo)

            <div
                class="gallery-item">

                <img
                    src="{{ asset('storage/' . $photo->photo) }}"
                    alt="Gallery"
                    class="gallery-image">

            </div>

            @endforeach

        </div>

    </section>

    @endif


    {{-- qr section --}}
    <section id="qr-section">

        <div class="vip-card">

            <div class="vip-header">

                <span>
                    VIP INVITATION
                </span>

            </div>

            <div class="vip-content">

                <p class="vip-label">
                    Diundang Kepada
                </p>

                <h2>

                    {{ $guest->nama_utama }}

                </h2>

                <p class="guest-count">

                    {{ $guest->jumlah_tamu }}
                    Tamu

                </p>

                <div class="vip-qr">

                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->format('svg')->generate($guest->qr_code) !!}

                </div>

                <p class="invitation-code">

                    #{{ $guest->nomor_undangan ?? substr($guest->qr_code,0,8) }}

                </p>

                @if($guest->status !== 'terdaftar')

                    <div class="checkin-success">

                        ✓ Sudah Check-In

                    </div>

                @else

                    <p class="checkin-info">

                        Tunjukkan QR ini saat hadir

                    </p>

                @endif

            </div>

        </div>

    </section>


    {{-- weeding wishes section --}}
    <section id="wishes">

        <div class="section-header">

            <span>
                Wishes
            </span>

            <h2>
                Ucapan & Doa
            </h2>

        </div>

        <div class="wishes-placeholder">

            <p>
                Semoga menjadi keluarga yang sakinah,
                mawaddah dan warahmah.
            </p>

        </div>

    </section>


    {{-- closing quote section --}}
    @if($content?->closing_quote)

    <section id="closing">

        <div class="closing-content">

            <p>

                "{{ $content->closing_quote }}"

            </p>

            <h3>

                {{ $content->groom_name }}
                &
                {{ $content->bride_name }}

            </h3>

        </div>

    </section>

    @endif


    {{-- mobile floating --}}
    <div id="mobile-nav">

        <a href="#hero">
            🏠
        </a>

        <a href="#countdown">
            ⏳
        </a>

        <a href="#story">
            ❤️
        </a>

        <a href="#gallery">
            📸
        </a>

        <a href="#qr-section">
            🎫
        </a>

    </div>

        <div id="lightbox">

        <span id="closeLightbox">
            ✕
        </span>

        <img id="lightboxImage">

    </div>

    {{-- footer --}}
    <footer>

        <div class="footer-content">

            <h3>

                {{ $content->groom_name }}
                &
                {{ $content->bride_name }}

            </h3>

            <p>

                Terima kasih atas doa dan kehadirannya.

            </p>

            <small>

                Powered by GuestBook Digital

            </small>

        </div>

    </footer>


    <div id="music-button" onclick="toggleMusic()">
        🎵
    </div>

</body>

</html>