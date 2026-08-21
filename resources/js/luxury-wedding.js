/*
|--------------------------------------------------------------------------
| Luxury Wedding Theme
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', () => {

    initOpeningScreen();
    initCountdown();
    initLightbox();
    initScrollReveal();
    initFloatingPetals();
    initParallaxHero();
    initMobileNavigation();

});

/* ==========================================================
   OPENING SCREEN + MUSIC
========================================================== */

function initOpeningScreen() {

    const openBtn = document.getElementById('openInvitation');
    const opening = document.getElementById('opening-screen');
    const music = document.getElementById('bgMusic');

    if (!openBtn || !opening) return;

    openBtn.addEventListener('click', () => {

        opening.style.opacity = '0';
        opening.style.visibility = 'hidden';

        document.body.style.overflow = 'auto';

        if (music) {

            music.volume = 0.4;

            music.play().catch(() => {
                console.log('Autoplay blocked');
            });
        }

    });

}

/* ==========================================================
   COUNTDOWN
========================================================== */

function initCountdown() {

    const countdownSection = document.getElementById('countdown');

    if (!countdownSection) return;

    const targetDate = new Date(
        countdownSection.dataset.date ||
        window.eventDate ||
        new Date()
    );

    function updateCountdown() {

        const now = new Date();

        const diff = targetDate - now;

        if (diff <= 0) {

            const container =
                document.querySelector('.countdown-grid');

            if (container) {

                container.innerHTML = `
                    <div style="
                        grid-column:1/-1;
                        text-align:center;
                        font-size:32px;
                    ">
                        🎉 Hari Bahagia Telah Tiba 🎉
                    </div>
                `;
            }

            return;
        }

        const days =
            Math.floor(diff / (1000 * 60 * 60 * 24));

        const hours =
            Math.floor((diff % (1000 * 60 * 60 * 24)) /
                (1000 * 60 * 60));

        const minutes =
            Math.floor((diff % (1000 * 60 * 60)) /
                (1000 * 60));

        const seconds =
            Math.floor((diff % (1000 * 60)) /
                1000);

        updateValue('days', days);
        updateValue('hours', hours);
        updateValue('minutes', minutes);
        updateValue('seconds', seconds);

    }

    function updateValue(id, value) {

        const el = document.getElementById(id);

        if (!el) return;

        el.textContent =
            String(value).padStart(2, '0');
    }

    updateCountdown();

    setInterval(updateCountdown, 1000);
}

/* ==========================================================
   LIGHTBOX GALLERY
========================================================== */

function initLightbox() {

    const lightbox =
        document.getElementById('lightbox');

    const lightboxImage =
        document.getElementById('lightboxImage');

    const closeBtn =
        document.getElementById('closeLightbox');

    if (!lightbox) return;

    document
        .querySelectorAll('.gallery-image')
        .forEach(image => {

            image.addEventListener('click', () => {

                lightbox.classList.add('active');

                lightboxImage.src = image.src;

                document.body.style.overflow = 'hidden';

            });

        });

    if (closeBtn) {
        closeBtn.addEventListener('click', closeLightbox);
    }

    lightbox.addEventListener('click', (e) => {

        if (e.target === lightbox) {

            closeLightbox();
        }

    });

    function closeLightbox() {

        lightbox.classList.remove('active');

        document.body.style.overflow = 'auto';
    }
}

/* ==========================================================
   SCROLL REVEAL
========================================================== */

function initScrollReveal() {

    const elements = document.querySelectorAll(
        'section, .event-card, .couple-card, .gallery-item'
    );

    elements.forEach(el => {

        el.classList.add('fade-up');

    });

    const observer = new IntersectionObserver(

        entries => {

            entries.forEach(entry => {

                if (entry.isIntersecting) {

                    entry.target.classList.add('show');

                }

            });

        },

        {
            threshold: 0.15
        }

    );

    elements.forEach(el => observer.observe(el));

}

/* ==========================================================
   FLOATING PETALS
========================================================== */

function initFloatingPetals() {

    const PETAL_COUNT = 18;

    for (let i = 0; i < PETAL_COUNT; i++) {

        createPetal();
    }

    function createPetal() {

        const petal =
            document.createElement('div');

        petal.classList.add('petal');

        petal.innerHTML = '❀';

        petal.style.left =
            Math.random() * 100 + 'vw';

        petal.style.fontSize =
            (10 + Math.random() * 18) + 'px';

        petal.style.animationDuration =
            (8 + Math.random() * 12) + 's';

        petal.style.animationDelay =
            (Math.random() * 8) + 's';

        document.body.appendChild(petal);
    }

}

/* ==========================================================
   PARALLAX HERO
========================================================== */

function initParallaxHero() {

    const heroImage =
        document.querySelector('.hero-background img');

    if (!heroImage) return;

    window.addEventListener('scroll', () => {

        const offset =
            window.scrollY * 0.3;

        heroImage.style.transform =
            `scale(1.1) translateY(${offset}px)`;

    });

}

/* ==========================================================
   MOBILE NAVIGATION ACTIVE
========================================================== */

function initMobileNavigation() {

    const sections =
        document.querySelectorAll('section');

    const navLinks =
        document.querySelectorAll('#mobile-nav a');

    window.addEventListener('scroll', () => {

        let current = '';

        sections.forEach(section => {

            const top =
                section.offsetTop - 200;

            const height =
                section.offsetHeight;

            if (
                pageYOffset >= top &&
                pageYOffset < top + height
            ) {

                current = section.id;
            }

        });

        navLinks.forEach(link => {

            link.style.opacity = '.5';

            const href =
                link.getAttribute('href');

            if (href === `#${current}`) {

                link.style.opacity = '1';

            }

        });

    });

}

/* ==========================================================
   OPTIONAL MUSIC TOGGLE
========================================================== */

window.toggleMusic = function() {

    const music =
        document.getElementById('bgMusic');

    if (!music) return;

    if (music.paused) {

        music.play();

    } else {

        music.pause();

    }

}