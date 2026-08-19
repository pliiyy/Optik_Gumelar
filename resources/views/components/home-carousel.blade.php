<section class="relative h-[500px] md:h-[600px] w-full overflow-hidden">
    <div class="swiper myHomeSwiper h-full w-full">
        <div class="swiper-wrapper">
            
            <!-- Slide 1 -->
            <div class="swiper-slide relative h-full w-full flex items-center justify-center overflow-hidden">
                <img src="{{ asset('images/carousel3.png') }}" alt="Pemeriksaan Mata Profesional" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-slate-900/40"></div>
                <div class="relative z-10 text-center text-white px-4">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-lg">Pemeriksaan Mata Profesional</h1>
                    <p class="text-lg md:text-xl max-w-2xl mx-auto mb-8 drop-shadow-md">Dapatkan resep tepat dan layanan optik lengkap untuk penglihatan yang lebih nyaman.</p>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide relative h-full w-full flex items-center justify-center overflow-hidden">
                <img src="{{ asset('images/carousel1.png') }}" alt="Frame Stylish" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-slate-900/40"></div>
                <div class="relative z-10 text-center text-white px-4">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-lg">Frame Stylish</h1>
                    <p class="text-lg md:text-xl max-w-2xl mx-auto mb-8 drop-shadow-md">Pilih dari koleksi frame modern dan klasik yang sesuai gaya Anda.</p>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="swiper-slide relative h-full w-full flex items-center justify-center overflow-hidden">
                <img src="{{ asset('images/carousel2.png') }}" alt="Lensa Berkualitas" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-slate-900/40"></div>
                <div class="relative z-10 text-center text-white px-4">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-lg">Lensa Berkualitas</h1>
                    <p class="text-lg md:text-xl max-w-2xl mx-auto mb-8 drop-shadow-md">Lensa anti-silau dan pelindung UV untuk kenyamanan penglihatan seharian.</p>
                </div>
            </div>

            <!-- Slide 4 -->
            <div class="swiper-slide relative h-full w-full flex items-center justify-center overflow-hidden">
                <img src="{{ asset('images/carousel4.png') }}" alt="Servis Kacamata & Perawatan" class="absolute inset-0 w-full h-full object-cover">
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

<!-- Script inisialisasi Swiper -->
@push('scripts')
<script>
    import Swiper from 'swiper';
    import { Autoplay, Pagination, Navigation } from 'swiper/modules';
    import 'swiper/css';
    import 'swiper/css/pagination';
    import 'swiper/css/navigation';

    const swiper = new Swiper('.myHomeSwiper', {
        modules: [Autoplay, Pagination, Navigation],
        spaceBetween: 0,
        centeredSlides: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        pagination: { clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    });
</script>
@endpush