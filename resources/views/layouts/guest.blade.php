@extends('layouts.guest')

@section('title', __('navigation.home'))

@push('styles')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(-5deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }
    
    @keyframes slideIn {
        from { transform: translateX(100%) rotate(15deg) scale(0.8); opacity: 0; }
        to { transform: translateX(0) rotate(-5deg) scale(1); opacity: 1; }
    }
    
    @keyframes slideOut {
        from { transform: translateX(0) rotate(-5deg) scale(1); opacity: 1; }
        to { transform: translateX(-100%) rotate(-15deg) scale(0.8); opacity: 0; }
    }
    
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(239, 68, 68, 0.3); }
        50% { box-shadow: 0 0 40px rgba(239, 68, 68, 0.6), 0 0 60px rgba(239, 68, 68, 0.3); }
    }
    
    @keyframes gradient-shift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    @keyframes sparkle {
        0%, 100% { transform: scale(0) rotate(0deg); opacity: 0; }
        50% { transform: scale(1) rotate(180deg); opacity: 1; }
    }
    
    .carousel-item {
        animation: float 6s ease-in-out infinite;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .carousel-item:hover {
        transform: scale(1.1) rotate(0deg) !important;
        z-index: 10;
        filter: brightness(1.2) saturate(1.3);
    }
    
    .carousel-item.entering {
        animation: slideIn 0.8s ease-out forwards, float 6s ease-in-out infinite 0.8s;
    }
    
    .carousel-item.exiting {
        animation: slideOut 0.8s ease-in forwards;
    }
    
    .text-shadow {
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5), 0 0 20px rgba(239, 68, 68, 0.3);
    }
    
    .backdrop-blur-custom {
        backdrop-filter: blur(12px);
        background: linear-gradient(135deg, 
            rgba(0, 0, 0, 0.4) 0%, 
            rgba(127, 29, 29, 0.3) 50%, 
            rgba(0, 0, 0, 0.4) 100%);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }
    
    .stat-card-hover {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .stat-card-hover::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(239, 68, 68, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .stat-card-hover:hover::before {
        left: 100%;
    }
    
    .stat-card-hover:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(239, 68, 68, 0.3), 0 0 0 1px rgba(239, 68, 68, 0.1);
    }
    
    .gradient-text {
        background: linear-gradient(45deg, #ef4444, #ffffff, #f87171, #fca5a5);
        background-size: 300% 300%;
        animation: gradient-shift 3s ease infinite;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .sparkle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: #ef4444;
        border-radius: 50%;
        animation: sparkle 2s ease-in-out infinite;
    }
    
    .sparkle:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
    .sparkle:nth-child(2) { top: 80%; left: 20%; animation-delay: 0.5s; }
    .sparkle:nth-child(3) { top: 40%; right: 15%; animation-delay: 1s; }
    .sparkle:nth-child(4) { bottom: 30%; right: 10%; animation-delay: 1.5s; }
    .sparkle:nth-child(5) { top: 60%; left: 80%; animation-delay: 0.3s; }
    .sparkle:nth-child(6) { bottom: 70%; left: 60%; animation-delay: 0.8s; }
    
    .program-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .program-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .program-card:hover::before {
        opacity: 1;
    }
    
    .program-card:hover {
        transform: translateY(-10px) rotateX(5deg);
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.5), 0 0 40px rgba(239, 68, 68, 0.2);
    }
    
    .testimonial-card {
        transition: all 0.3s ease;
        position: relative;
    }
    
    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 20px rgba(239, 68, 68, 0.2);
    }
    
    .cta-section {
        background: linear-gradient(135deg, #dc2626, #991b1b, #7f1d1d);
        background-size: 400% 400%;
        animation: gradient-shift 8s ease infinite;
        position: relative;
        overflow: hidden;
    }
    
    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 30% 70%, rgba(239, 68, 68, 0.3) 0%, transparent 50%),
                    radial-gradient(circle at 70% 30%, rgba(220, 38, 38, 0.3) 0%, transparent 50%);
        animation: float 10s ease-in-out infinite;
    }
    
    .button-primary {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .button-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .button-primary:hover::before {
        left: 100%;
    }
    
    .section-background {
        background: linear-gradient(135deg, #000000 0%, #1a1a1a 50%, #000000 100%);
        position: relative;
    }
    
    .section-background::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: 
            radial-gradient(circle at 25% 25%, rgba(239, 68, 68, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 75% 75%, rgba(220, 38, 38, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-red-900 via-black to-red-800 text-white py-20 min-h-screen flex items-center overflow-hidden">
    <!-- Enhanced Background Pattern -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0" style="background-image: 
            radial-gradient(circle at 25% 25%, #ef4444 0%, transparent 50%), 
            radial-gradient(circle at 75% 75%, #dc2626 0%, transparent 50%),
            radial-gradient(circle at 50% 50%, #991b1b 0%, transparent 30%);"></div>
    </div>
    
    <!-- Sparkle Elements -->
    <div class="absolute inset-0">
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="sparkle"></div>
    </div>
    
    <!-- Enhanced Floating Images Carousel -->
    <div class="absolute inset-0 overflow-hidden opacity-90">
        <div class="carousel-container relative w-full h-full">
            <!-- Image 1 -->
            <div class="carousel-item absolute top-1/4 left-1/4 w-64 h-48 transform -rotate-12">
                <div class="relative group">
                    <img src="{{ asset('images/2001815_bee-hive-1_1080x1440.jpg') }}" 
                         alt="Community" 
                         class="w-full h-full object-cover rounded-xl shadow-2xl border-4 border-red-400/40 group-hover:border-red-300/60 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-xl"></div>
                </div>
            </div>
            
            <!-- Image 2 -->
            <div class="carousel-item absolute top-1/3 right-1/4 w-56 h-40 transform rotate-8" style="animation-delay: -2s;">
                <div class="relative group">
                    <img src="{{ asset('images/2001809_thumbnail_1080x810.jpg') }}"
                         alt="Education" 
                         class="w-full h-full object-cover rounded-xl shadow-2xl border-4 border-red-400/40 group-hover:border-red-300/60 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-xl"></div>
                </div>
            </div>
            
            <!-- Image 3 -->
            <div class="carousel-item absolute bottom-1/4 left-1/3 w-60 h-44 transform -rotate-6" style="animation-delay: -4s;">
                <div class="relative group">
                    <img src="{{ asset('images/2001815_bee-hive-1_1080x1440.jpg') }}"
                         alt="Helping" 
                         class="w-full h-full object-cover rounded-xl shadow-2xl border-4 border-red-400/40 group-hover:border-red-300/60 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-xl"></div>
                </div>
            </div>
            
            <!-- Image 4 -->
            <div class="carousel-item absolute top-1/2 left-1/6 w-52 h-36 transform rotate-12" style="animation-delay: -1s;">
                <div class="relative group">
                    <img src="{{ asset('images/DbyC0odW0AAFVM1.jfif') }}"
                         alt="Nature" 
                         class="w-full h-full object-cover rounded-xl shadow-2xl border-4 border-red-400/40 group-hover:border-red-300/60 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-xl"></div>
                </div>
            </div>
            
            <!-- Image 5 -->
            <div class="carousel-item absolute bottom-1/3 right-1/3 w-58 h-42 transform -rotate-10" style="animation-delay: -3s;">
                <div class="relative group">
                    <img src="{{ asset('images/group-3137670_1280.jpg') }}"
                         alt="Support" 
                         class="w-full h-full object-cover rounded-xl shadow-2xl border-4 border-red-400/40 group-hover:border-red-300/60 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-xl"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Content Overlay -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center">
            <!-- Enhanced Main Content Box -->
            <div class="backdrop-blur-custom rounded-3xl p-8 md:p-16 border-2 border-red-400/30 shadow-2xl">
                <h1 class="text-5xl md:text-8xl font-bold mb-8 text-shadow">
                    <span class="gradient-text">
                        {{ __('messages.organization_name') }}
                    </span>
                </h1>
                <p class="text-xl md:text-3xl mb-10 max-w-4xl mx-auto text-shadow font-light leading-relaxed">
                    {{ __('messages.vision') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="{{ route('programs') }}" 
                       class="button-primary group bg-white text-black px-10 py-5 rounded-full font-bold hover:bg-red-50 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl text-lg">
                        <span class="group-hover:text-red-600 transition-colors relative z-10">
                            {{ __('messages.learn_more') }}
                        </span>
                    </a>
                    <a href="{{ route('donate') }}" 
                       class="button-primary group bg-gradient-to-r from-red-600 to-red-500 text-white px-10 py-5 rounded-full font-bold hover:from-red-500 hover:to-red-400 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl border-2 border-red-400 text-lg">
                        <span class="group-hover:text-red-100 transition-colors relative z-10">
                            {{ __('messages.donate_now') }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Animated Elements -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- Enhanced Stats Section -->
<section class="py-20 section-background">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-white mb-4">Our Impact</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-red-500 to-red-400 mx-auto rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div class="bg-gradient-to-br from-red-900 to-black p-8 rounded-2xl shadow-2xl border border-red-400/30 stat-card-hover">
                <div class="text-4xl font-bold text-red-400 mb-3">{{ number_format($stats['youth_empowered']) }}+</div>
                <div class="text-red-200 text-lg font-medium">{{ __('messages.youth') }} {{ __('messages.empowerment') }}</div>
            </div>
            <div class="bg-gradient-to-br from-red-900 to-black p-8 rounded-2xl shadow-2xl border border-red-400/30 stat-card-hover">
                <div class="text-4xl font-bold text-red-400 mb-3">{{ $stats['programs_running'] }}+</div>
                <div class="text-red-200 text-lg font-medium">{{ __('navigation.programs') }}</div>
            </div>
            <div class="bg-gradient-to-br from-red-900 to-black p-8 rounded-2xl shadow-2xl border border-red-400/30 stat-card-hover">
                <div class="text-4xl font-bold text-red-400 mb-3">{{ $stats['communities_served'] }}+</div>
                <div class="text-red-200 text-lg font-medium">{{ __('messages.communities') }}</div>
            </div>
            <div class="bg-gradient-to-br from-red-900 to-black p-8 rounded-2xl shadow-2xl border border-red-400/30 stat-card-hover">
                <div class="text-4xl font-bold text-red-400 mb-3">{{ $stats['years_of_service'] }}+</div>
                <div class="text-red-200 text-lg font-medium">Years of Service</div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Featured Programs -->
<section class="py-20 bg-black relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, #ef4444 0px, #ef4444 1px, transparent 1px, transparent 20px);"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white mb-6">{{ __('navigation.programs') }}</h2>
            <p class="text-red-200 max-w-3xl mx-auto text-xl leading-relaxed">Discover our impactful programs designed to empower youth and transform communities through innovative approaches and sustainable solutions.</p>
            <div class="w-32 h-1 bg-gradient-to-r from-red-500 to-red-400 mx-auto rounded-full mt-6"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach($featuredPrograms as $program)
            <div class="program-card bg-gradient-to-br from-red-900 to-black rounded-2xl shadow-2xl overflow-hidden border border-red-400/30">
                <div class="h-56 bg-gradient-to-br from-red-600 to-red-800 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-red-600/20 to-red-800/20"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <div class="w-full h-2 bg-gradient-to-r from-red-400 to-red-300 rounded-full shadow-lg"></div>
                    </div>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-bold mb-4 text-white leading-tight">
                        {{ app()->getLocale() == 'sw' ? $program['title_sw'] : $program['title'] }}
                    </h3>
                    <p class="text-red-200 mb-6 leading-relaxed">
                        {{ app()->getLocale() == 'sw' ? $program['description_sw'] : $program['description'] }}
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-red-400 font-bold bg-red-900/50 px-3 py-1 rounded-full">{{ $program['participants'] }} participants</span>
                        <a href="{{ route('programs.show', $program['id']) }}" class="text-red-400 hover:text-red-300 font-bold transition-colors text-lg group">
                            {{ __('messages.learn_more') }} 
                            <span class="group-hover:translate-x-1 inline-block transition-transform">→</span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('programs') }}" class="button-primary bg-gradient-to-r from-red-600 to-red-500 text-white px-10 py-4 rounded-full hover:from-red-500 hover:to-red-400 transition-all duration-300 transform hover:scale-105 font-bold text-lg shadow-2xl">
                {{ __('messages.view_all') }} {{ __('navigation.programs') }}
            </a>
        </div>
    </div>
</section>

<!-- Enhanced Testimonials -->
<section class="py-20 section-background">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white mb-6">{{ __('messages.testimonials') }}</h2>
            <p class="text-red-200 text-xl">Hear from those whose lives have been transformed through our programs</p>
            <div class="w-24 h-1 bg-gradient-to-r from-red-500 to-red-400 mx-auto rounded-full mt-6"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            @foreach($testimonials as $testimonial)
            <div class="testimonial-card bg-gradient-to-br from-red-900 to-black p-8 rounded-2xl shadow-2xl border border-red-400/30">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-800 rounded-full mr-6 flex items-center justify-center shadow-xl">
                        <span class="text-white font-bold text-xl">{{ substr($testimonial['name'], 0, 1) }}</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-lg">{{ $testimonial['name'] }}</h4>
                        <p class="text-red-200 font-medium">
                            {{ app()->getLocale() == 'sw' ? $testimonial['role_sw'] : $testimonial['role'] }}
                        </p>
                    </div>
                </div>
                <p class="text-red-100 italic text-lg leading-relaxed">
                    "{{ app()->getLocale() == 'sw' ? $testimonial['quote_sw'] : $testimonial['quote'] }}"
                </p>
                <div class="mt-4 flex text-red-400">
                    <span class="text-2xl">★★★★★</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Enhanced Call to Action -->
<section class="py-20 cta-section text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
        <h2 class="text-4xl md:text-5xl font-bold mb-6 text-shadow">{{ __('messages.get_involved') }}</h2>
        <p class="text-xl md:text-2xl mb-10 text-red-100 max-w-3xl mx-auto leading-relaxed">Join us in empowering youth and transforming communities. Your contribution makes a real difference in people's lives.</p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
            <a href="{{ route('donate') }}" class="button-primary bg-white text-red-600 px-12 py-4 rounded-full font-bold hover:bg-red-50 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl text-lg">
                {{ __('messages.donate_now') }}
            </a>
            <a href="{{ route('contact') }}" class="button-primary bg-black/80 text-white px-12 py-4 rounded-full font-bold hover:bg-black transition-all duration-300 transform hover:scale-105 hover:shadow-2xl border-2 border-white text-lg">
                {{ __('messages.volunteer') }}
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const images = [
        '{{ asset("images/10-frame-assembled-hive-kits-no-bees-821599.webp") }}',
        '{{ asset("images/2001809_thumbnail_1080x810.jpg") }}',
        '{{ asset("images/2001815_bee-hive-1_1080x1440.jpg") }}',
        '{{ asset("images/D1UAu6jW0AA0i0G.jfif") }}',
        '{{ asset("images/DbyC0odW0AAFVM1.jfif") }}',
        '{{ asset("images/DbyCnQXX0AAU2cB.jfif") }}',
        '{{ asset("images/EwJM3ilWQAk8ePU.jfif") }}',
        '{{ asset("images/group-3137670_1280.jpg") }}'
    ];
    
    const carouselItems = document.querySelectorAll('.carousel-item img');
    let currentImageIndex = 0;
    
    function changeImages() {
        carouselItems.forEach((img, index) => {
            const newImageIndex = (currentImageIndex + index) % images.length;
            
            // Add transition effect
            const parent = img.closest('.carousel-item');
            parent.classList.add('exiting');
            
            setTimeout(() => {
                img.src = images[newImageIndex];
                parent.classList.remove('exiting');
                parent.classList.add('entering');
                
                setTimeout(() => {
                    parent.classList.remove('entering');
                }, 800);
            }, 400);
        });
        
        currentImageIndex = (currentImageIndex + 1) % images.length;
    }
    
    // Change images every 5 seconds
    setInterval(changeImages, 5000);
    
    // Add scroll reveal animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe elements for scroll animations
    document.querySelectorAll('.stat-card-hover, .program-card, .testimonial-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});
</script>
@endpush