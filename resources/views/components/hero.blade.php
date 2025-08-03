@push('styles')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotateY(15deg) rotateX(5deg); }
        50% { transform: translateY(-20px) rotateY(15deg) rotateX(5deg); }
    }
    
    @keyframes slideIn {
        from { transform: translateX(100%) rotateY(25deg) rotateX(10deg); opacity: 0; }
        to { transform: translateX(0) rotateY(15deg) rotateX(5deg); opacity: 1; }
    }
    
    @keyframes slideOut {
        from { transform: translateX(0) rotateY(15deg) rotateX(5deg); opacity: 1; }
        to { transform: translateX(-100%) rotateY(-15deg) rotateX(-5deg); opacity: 0; }
    }
    
    @keyframes backgroundShift {
        0%, 100% { 
            transform: scale(1.1) rotateY(-5deg) rotateX(2deg);
            filter: brightness(0.7) blur(1px);
        }
        50% { 
            transform: scale(1.15) rotateY(-3deg) rotateX(1deg);
            filter: brightness(0.8) blur(0.5px);
        }
    }
    
    .carousel-item {
        animation: float 6s ease-in-out infinite;
        transform-style: preserve-3d;
        perspective: 1000px;
    }
    
    .carousel-item.entering {
        animation: slideIn 1s ease-out forwards, float 6s ease-in-out infinite 1s;
    }
    
    .carousel-item.exiting {
        animation: slideOut 1s ease-in forwards;
    }
    
    .background-image {
        animation: backgroundShift 12s ease-in-out infinite;
        transform-style: preserve-3d;
        perspective: 1000px;
    }
    
    .text-shadow {
        text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
    }
    
    .backdrop-blur-custom {
        backdrop-filter: blur(12px);
        background: rgba(0, 0, 0, 0.4);
    }
    
    .tilt-3d {
        transform: perspective(1000px) rotateY(-5deg) rotateX(2deg);
        transform-style: preserve-3d;
    }
    
    .carousel-container {
        transform: perspective(1200px) rotateY(5deg);
        transform-style: preserve-3d;
    }
    
    .content-glow {
        box-shadow: 0 0 50px rgba(239, 68, 68, 0.3);
    }
    
    /* 3D hover effects for buttons */
    .btn-3d {
        transform: perspective(1000px) rotateX(0deg);
        transition: all 0.3s ease;
    }
    
    .btn-3d:hover {
        transform: perspective(1000px) rotateX(-5deg) translateY(-3px);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .tilt-3d, .carousel-container {
            transform: none;
        }
    }
</style>
@endpush

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-red-900 via-black to-red-800 text-white min-h-screen flex items-center overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, #ef4444 0%, transparent 50%), radial-gradient(circle at 75% 75%, #dc2626 0%, transparent 50%);"></div>
    </div>
    
    <!-- Two Column Layout -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center min-h-screen py-20">
            
            <!-- Left Column - Content -->
            <div class="space-y-8">
                <div class="backdrop-blur-custom rounded-3xl p-8 md:p-12 border border-red-400/30 content-glow">
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 text-shadow">
                        <span class="bg-gradient-to-r from-red-400 via-white to-red-300 bg-clip-text text-transparent">
                            {{ __('messages.organization_name') }}
                        </span>
                    </h1>
                    <p class="text-lg md:text-xl lg:text-2xl mb-8 text-shadow font-light text-red-100">
                        {{ __('messages.vision') }}
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('programs') }}" 
                           class="group bg-white text-black px-8 py-4 rounded-full font-semibold hover:bg-red-100 transition-all duration-300 btn-3d">
                            <span class="group-hover:text-red-600 transition-colors">
                                {{ __('messages.learn_more') }}
                            </span>
                        </a>
                        <a href="{{ route('donate') }}" 
                           class="group bg-gradient-to-r from-red-600 to-red-500 text-white px-8 py-4 rounded-full font-semibold hover:from-red-500 hover:to-red-400 transition-all duration-300 btn-3d border-2 border-red-400">
                            <span class="group-hover:text-red-100 transition-colors">
                                {{ __('messages.donate_now') }}
                            </span>
                        </a>
                    </div>
                </div>
                
                <!-- Stats Preview -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="backdrop-blur-custom rounded-xl p-4 border border-red-400/20">
                        <div class="text-2xl font-bold text-red-400">{{ number_format($stats['youth_empowered']) }}+</div>
                        <div class="text-sm text-red-200">{{ __('messages.youth') }} {{ __('messages.empowerment') }}</div>
                    </div>
                    <div class="backdrop-blur-custom rounded-xl p-4 border border-red-400/20">
                        <div class="text-2xl font-bold text-red-400">{{ $stats['programs_running'] }}+</div>
                        <div class="text-sm text-red-200">{{ __('navigation.programs') }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - 3D Carousel with Background -->
            <div class="relative tilt-3d">
                <!-- Background Image that changes with carousel -->
                <div class="absolute inset-0 rounded-3xl overflow-hidden">
                    <div id="background-image" class="background-image w-full h-full object-cover transition-all duration-1000">
                        <img src="{{ asset('images/2001815_bee-hive-1_1080x1440.jpg') }}" 
                             alt="Background" 
                             class="w-full h-full object-cover" />
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                </div>
                
                <!-- Floating Carousel Images -->
                <div class="carousel-container relative w-full h-96 lg:h-[500px]">
                    <!-- Image 1 -->
                    <div class="carousel-item absolute top-1/4 left-1/4 w-32 h-24 lg:w-48 lg:h-36 transform rotate-12 z-20">
                        <img src="{{ asset('images/2001815_bee-hive-1_1080x1440.jpg') }}" 
                             alt="Community" 
                             class="w-full h-full object-cover rounded-xl shadow-2xl border-2 border-red-400/50">
                    </div>
                    
                    <!-- Image 2 -->
                    <div class="carousel-item absolute top-1/3 right-1/4 w-28 h-20 lg:w-40 lg:h-30 transform -rotate-8 z-30" style="animation-delay: -2s;">
                        <img src="{{ asset('images/2001809_thumbnail_1080x810.jpg') }}"
                             alt="Education" 
                             class="w-full h-full object-cover rounded-xl shadow-2xl border-2 border-red-400/50">
                    </div>
                    
                    <!-- Image 3 -->
                    <div class="carousel-item absolute bottom-1/4 left-1/3 w-36 h-28 lg:w-52 lg:h-40 transform rotate-6 z-10" style="animation-delay: -4s;">
                        <img src="{{ asset('images/group-3137670_1280.jpg') }}"
                             alt="Helping" 
                             class="w-full h-full object-cover rounded-xl shadow-2xl border-2 border-red-400/50">
                    </div>
                    
                    <!-- Image 4 -->
                    <div class="carousel-item absolute top-1/2 left-1/6 w-24 h-18 lg:w-36 lg:h-28 transform -rotate-12 z-15" style="animation-delay: -1s;">
                        <img src="{{ asset('images/DbyC0odW0AAFVM1.jfif') }}"
                             alt="Nature" 
                             class="w-full h-full object-cover rounded-xl shadow-2xl border-2 border-red-400/50">
                    </div>
                    
                    <!-- Image 5 -->
                    <div class="carousel-item absolute bottom-1/3 right-1/3 w-30 h-22 lg:w-44 lg:h-32 transform rotate-10 z-25" style="animation-delay: -3s;">
                        <img src="{{ asset('images/EwJM3ilWQAk8ePU.jfif') }}"
                             alt="Support" 
                             class="w-full h-full object-cover rounded-xl shadow-2xl border-2 border-red-400/50">
                    </div>
                </div>
                
                <!-- Carousel Indicator -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 z-40">
                    <div class="w-2 h-2 bg-red-400 rounded-full animate-pulse carousel-indicator"></div>
                    <div class="w-2 h-2 bg-red-400/50 rounded-full carousel-indicator"></div>
                    <div class="w-2 h-2 bg-red-400/50 rounded-full carousel-indicator"></div>
                    <div class="w-2 h-2 bg-red-400/50 rounded-full carousel-indicator"></div>
                    <div class="w-2 h-2 bg-red-400/50 rounded-full carousel-indicator"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce z-20">
        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const images = [
        '{{ asset("images/2001815_bee-hive-1_1080x1440.jpg") }}',
        '{{ asset("images/2001809_thumbnail_1080x810.jpg") }}',
        '{{ asset("images/group-3137670_1280.jpg") }}',
        '{{ asset("images/DbyC0odW0AAFVM1.jfif") }}',
        '{{ asset("images/EwJM3ilWQAk8ePU.jfif") }}',
        '{{ asset("images/D1UAu6jW0AA0i0G.jfif") }}',
        '{{ asset("images/DbyCnQXX0AAU2cB.jfif") }}',
        '{{ asset("images/10-frame-assembled-hive-kits-no-bees-821599.webp") }}'
    ];
    
    const carouselItems = document.querySelectorAll('.carousel-item img');
    const backgroundImage = document.getElementById('background-image').querySelector('img');
    const indicators = document.querySelectorAll('.carousel-indicator');
    
    let currentImageIndex = 0;
    
    function updateIndicators(activeIndex) {
        indicators.forEach((indicator, index) => {
            if (index === activeIndex) {
                indicator.classList.remove('bg-red-400/50');
                indicator.classList.add('bg-red-400', 'animate-pulse');
            } else {
                indicator.classList.remove('bg-red-400', 'animate-pulse');
                indicator.classList.add('bg-red-400/50');
            }
        });
    }
    
    function changeImages() {
        // Update background image first
        const backgroundImg = backgroundImage;
        backgroundImg.style.opacity = '0.3';
        
        setTimeout(() => {
            backgroundImg.src = images[currentImageIndex];
            backgroundImg.style.opacity = '1';
        }, 500);
        
        // Update carousel images
        carouselItems.forEach((img, index) => {
            const newImageIndex = (currentImageIndex + index) % images.length;
            const parent = img.parentElement;
            
            parent.classList.add('exiting');
            
            setTimeout(() => {
                img.src = images[newImageIndex];
                parent.classList.remove('exiting');
                parent.classList.add('entering');
                
                setTimeout(() => {
                    parent.classList.remove('entering');
                }, 1000);
            }, 500);
        });
        
        // Update indicators
        updateIndicators(currentImageIndex % indicators.length);
        
        currentImageIndex = (currentImageIndex + 1) % images.length;
    }
    
    // Initialize indicators
    updateIndicators(0);
    
    // Change images every 5 seconds
    setInterval(changeImages, 5000);
    
    // Add click handlers to indicators
    indicators.forEach((indicator, index) => {
        indicator.style.cursor = 'pointer';
        indicator.addEventListener('click', () => {
            currentImageIndex = index;
            changeImages();
        });
    });
});
</script>
@endpush