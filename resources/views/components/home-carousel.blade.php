<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<section class="relative w-full overflow-hidden px-4 py-4 sm:px-6 lg:px-10">
    <div class="swiper myHomeSwiper mx-auto h-[min(70vh,640px)] min-h-[420px] w-full max-w-7xl overflow-hidden rounded-2xl shadow-xl">
        <div class="swiper-wrapper">
            
            <!-- Slide 1 -->
            <div class="swiper-slide relative flex h-full w-full items-center justify-center overflow-hidden">
                <img src="{{ asset('carousel3.png') }}" alt="Pemeriksaan Mata Profesional" class="absolute inset-0 h-full w-full object-cover" loading="eager">
                <div class="absolute inset-0 bg-slate-900/40"></div>
                <div class="relative z-10 text-center text-white px-4">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-lg">Pemeriksaan Mata Profesional</h1>
                    <p class="text-lg md:text-xl max-w-2xl mx-auto mb-8 drop-shadow-md">Dapatkan resep tepat dan layanan optik lengkap untuk penglihatan yang lebih nyaman.</p>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide relative flex h-full w-full items-center justify-center overflow-hidden">
                <img src="{{ asset('carousel1.png') }}" alt="Frame Stylish" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                <div class="absolute inset-0 bg-slate-900/40"></div>
                <div class="relative z-10 text-center text-white px-4">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-lg">Frame Stylish</h1>
                    <p class="text-lg md:text-xl max-w-2xl mx-auto mb-8 drop-shadow-md">Pilih dari koleksi frame modern dan klasik yang sesuai gaya Anda.</p>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="swiper-slide relative flex h-full w-full items-center justify-center overflow-hidden">
                <img src="{{ asset('carousel2.png') }}" alt="Lensa Berkualitas" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                <div class="absolute inset-0 bg-slate-900/40"></div>
                <div class="relative z-10 text-center text-white px-4">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-lg">Lensa Berkualitas</h1>
                    <p class="text-lg md:text-xl max-w-2xl mx-auto mb-8 drop-shadow-md">Lensa anti-silau dan pelindung UV untuk kenyamanan penglihatan seharian.</p>
                </div>
            </div>

            <!-- Slide 4 -->
            <div class="swiper-slide relative flex h-full w-full items-center justify-center overflow-hidden">
                <img src="{{ asset('carousel4.png') }}" alt="Servis Kacamata & Perawatan" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                <div class="absolute inset-0 bg-slate-900/40"></div>
                <div class="relative z-10 text-center text-white px-4">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-lg">Servis Kacamata & Perawatan</h1>
                    <p class="text-lg md:text-xl max-w-2xl mx-auto mb-8 drop-shadow-md">Perawatan lensa dan servis frame yang membuat kacamata Anda selalu prima.</p>
                </div>
            </div>

        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const carousel = document.querySelector('.myHomeSwiper');

        if (!carousel || typeof Swiper === 'undefined') {
            return;
        }

        new Swiper(carousel, {
            direction: 'horizontal',
            loop: true,
            speed: 700,
            grabCursor: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            pagination: {
                el: carousel.querySelector('.swiper-pagination'),
                clickable: true,
            },
            navigation: {
                nextEl: carousel.querySelector('.swiper-button-next'),
                prevEl: carousel.querySelector('.swiper-button-prev'),
            },
        });
    });
</script>