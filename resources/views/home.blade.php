@extends('layouts.guest')

@section('title', __('navigation.home'))

@push('styles')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(-5deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }
    
    @keyframes slideIn {
        from { transform: translateX(100%) rotate(15deg); opacity: 0; }
        to { transform: translateX(0) rotate(-5deg); opacity: 1; }
    }
    
    @keyframes slideOut {
        from { transform: translateX(0) rotate(-5deg); opacity: 1; }
        to { transform: translateX(-100%) rotate(-15deg); opacity: 0; }
    }
    
    .carousel-item {
        animation: float 6s ease-in-out infinite;
    }
    
    .carousel-item.entering {
        animation: slideIn 0.8s ease-out forwards, float 6s ease-in-out infinite 0.8s;
    }
    
    .carousel-item.exiting {
        animation: slideOut 0.8s ease-in forwards;
    }
    
    .text-shadow {
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    
    .backdrop-blur-custom {
        backdrop-filter: blur(8px);
        background: rgba(0, 0, 0, 0.3);
    }
    
    .stat-card-hover {
        transition: all 0.3s ease;
    }
    
    .stat-card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-red-900 via-black to-red-800 text-white py-20 min-h-screen flex items-center overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, #ef4444 0%, transparent 50%), radial-gradient(circle at 75% 75%, #dc2626 0%, transparent 50%);"></div>
    </div>
    
    <!-- Floating Images Carousel -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="carousel-container relative w-full h-full">
            <!-- Image 1 -->
            <div class="carousel-item absolute top-1/4 left-1/4 w-64 h-48 transform -rotate-12 opacity-80">
                <img src="{{ asset('images/2001815_bee-hive-1_1080x1440.jpg') }}" 
                     alt="Community" 
                     class="w-full h-full object-cover rounded-xl shadow-2xl border-4 border-red-400/30">
            </div>
            
            <!-- Image 2 -->
            <div class="carousel-item absolute top-1/3 right-1/4 w-56 h-40 transform rotate-8 opacity-70" style="animation-delay: -2s;">
                <img src="{{ asset('images/2001809_thumbnail_1080x810.jpg') }}"
                     alt="Education" 
                     class="w-full h-full object-cover rounded-xl shadow-2xl border-4 border-red-400/30">
            </div>
            
            <!-- Image 3 -->
            <div class="carousel-item absolute bottom-1/4 left-1/3 w-60 h-44 transform -rotate-6 opacity-75" style="animation-delay: -4s;">
                <img src="{{ asset('images/2001815_bee-hive-1_1080x1440.jpg') }}"
                     alt="Helping" 
                     class="w-full h-full object-cover rounded-xl shadow-2xl border-4 border-red-400/30">
            </div>
            
            <!-- Image 4 -->
            <div class="carousel-item absolute top-1/2 left-1/6 w-52 h-36 transform rotate-12 opacity-60" style="animation-delay: -1s;">
                <img src="{{ asset('images/DbyC0odW0AAFVM1.jfif') }}"
                     alt="Nature" 
                     class="w-full h-full object-cover rounded-xl shadow-2xl border-4 border-red-400/30">
            </div>
            
            <!-- Image 5 -->
            <div class="carousel-item absolute bottom-1/3 right-1/3 w-58 h-42 transform -rotate-10 opacity-65" style="animation-delay: -3s;">
                <img src="{{ asset('images/group-3137670_1280.jpg') }}"
                     alt="Support" 
                     class="w-full h-full object-cover rounded-xl shadow-2xl border-4 border-red-400/30">
            </div>
        </div>
    </div>
    
    <!-- Content Overlay -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center">
            <!-- Main Content Box -->
            <div class="backdrop-blur-custom rounded-3xl p-8 md:p-12 border border-red-400/20">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 text-shadow">
                    <span class="bg-gradient-to-r from-red-400 to-white bg-clip-text text-transparent">
                        {{ __('messages.organization_name') }}
                    </span>
                </h1>
                <p class="text-xl md:text-3xl mb-8 max-w-4xl mx-auto text-shadow font-light">
                    {{ __('messages.vision') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('programs') }}" 
                       class="group bg-white text-black px-8 py-4 rounded-full font-semibold hover:bg-red-100 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                        <span class="group-hover:text-red-600 transition-colors">
                            {{ __('messages.learn_more') }}
                        </span>
                    </a>
                    <a href="{{ route('donate') }}" 
                       class="group bg-gradient-to-r from-red-600 to-red-500 text-white px-8 py-4 rounded-full font-semibold hover:from-red-500 hover:to-red-400 transition-all duration-300 transform hover:scale-105 hover:shadow-xl border-2 border-red-400">
                        <span class="group-hover:text-red-100 transition-colors">
                            {{ __('messages.donate_now') }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Animated Elements -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-gradient-to-br from-gray-900 to-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div class="bg-gradient-to-br from-red-900 to-black p-6 rounded-lg shadow-lg border border-red-400/20 stat-card-hover">
                <div class="text-3xl font-bold text-red-400 mb-2">{{ number_format($stats['youth_empowered']) }}+</div>
                <div class="text-red-200">{{ __('messages.youth') }} {{ __('messages.empowerment') }}</div>
            </div>
            <div class="bg-gradient-to-br from-red-900 to-black p-6 rounded-lg shadow-lg border border-red-400/20 stat-card-hover">
                <div class="text-3xl font-bold text-red-400 mb-2">{{ $stats['programs_running'] }}+</div>
                <div class="text-red-200">{{ __('navigation.programs') }}</div>
            </div>
            <div class="bg-gradient-to-br from-red-900 to-black p-6 rounded-lg shadow-lg border border-red-400/20 stat-card-hover">
                <div class="text-3xl font-bold text-red-400 mb-2">{{ $stats['communities_served'] }}+</div>
                <div class="text-red-200">{{ __('messages.communities') }}</div>
            </div>
            <div class="bg-gradient-to-br from-red-900 to-black p-6 rounded-lg shadow-lg border border-red-400/20 stat-card-hover">
                <div class="text-3xl font-bold text-red-400 mb-2">{{ $stats['years_of_service'] }}+</div>
                <div class="text-red-200">Years of Service</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Programs -->
<section class="py-16 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-4">{{ __('navigation.programs') }}</h2>
            <p class="text-red-200 max-w-2xl mx-auto">Discover our impactful programs designed to empower youth and transform communities.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredPrograms as $program)
            <div class="bg-gradient-to-br from-red-900 to-black rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:scale-105 border border-red-400/20">
                <div class="h-48 bg-gradient-to-r from-red-600 to-red-800 relative overflow-hidden">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="absolute bottom-4 left-4 right-4">
                        <div class="w-full h-1 bg-red-400 rounded"></div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-3 text-white">
                        {{ app()->getLocale() == 'sw' ? $program['title_sw'] : $program['title'] }}
                    </h3>
                    <p class="text-red-200 mb-4">
                        {{ app()->getLocale() == 'sw' ? $program['description_sw'] : $program['description'] }}
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-red-400 font-semibold">{{ $program['participants'] }} participants</span>
                        <a href="{{ route('programs.show', $program['id']) }}" class="text-red-400 hover:text-red-300 font-semibold transition-colors">
                            {{ __('messages.learn_more') }} →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('programs') }}" class="bg-gradient-to-r from-red-600 to-red-500 text-white px-6 py-3 rounded-lg hover:from-red-500 hover:to-red-400 transition-all duration-300 transform hover:scale-105 font-semibold">
                {{ __('messages.view_all') }} {{ __('navigation.programs') }}
            </a>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-16 bg-gradient-to-br from-gray-900 to-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-4">{{ __('messages.testimonials') }}</h2>
            <p class="text-red-200">Hear from those whose lives have been transformed</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($testimonials as $testimonial)
            <div class="bg-gradient-to-br from-red-900 to-black p-6 rounded-lg shadow-lg border border-red-400/20 hover:shadow-2xl transition-all duration-300">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-800 rounded-full mr-4 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">{{ substr($testimonial['name'], 0, 1) }}</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-white">{{ $testimonial['name'] }}</h4>
                        <p class="text-sm text-red-200">
                            {{ app()->getLocale() == 'sw' ? $testimonial['role_sw'] : $testimonial['role'] }}
                        </p>
                    </div>
                </div>
                <p class="text-red-100 italic">
                    "{{ app()->getLocale() == 'sw' ? $testimonial['quote_sw'] : $testimonial['quote'] }}"
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-red-600 via-red-700 to-red-800 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">{{ __('messages.get_involved') }}</h2>
        <p class="text-xl mb-8 text-red-100">Join us in empowering youth and transforming communities</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('donate') }}" class="bg-white text-red-600 px-8 py-3 rounded-full font-semibold hover:bg-red-50 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                {{ __('messages.donate_now') }}
            </a>
            <a href="{{ route('contact') }}" class="bg-black text-white px-8 py-3 rounded-full font-semibold hover:bg-gray-900 transition-all duration-300 transform hover:scale-105 hover:shadow-xl border-2 border-white">
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
            const parent = img.parentElement;
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
    
    // Change images every 4 seconds
    setInterval(changeImages, 4000);
});
</script>
@endpush