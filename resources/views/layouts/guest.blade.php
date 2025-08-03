<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sauti ya Mtaa') }} - @yield('title', __('navigation.home'))</title>
        <meta name="description" content="@yield('description', __('messages.organization_description'))">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

          <script src="https://cdn.tailwindcss.com"></script>
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

        @stack('styles')
        
        <style>
            @keyframes slideDown {
                from { transform: translateY(-100%); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
            
            @keyframes glow {
                0%, 100% { box-shadow: 0 0 5px rgba(239, 68, 68, 0.3); }
                50% { box-shadow: 0 0 20px rgba(239, 68, 68, 0.6), 0 0 30px rgba(239, 68, 68, 0.3); }
            }
            
            .nav-link {
                position: relative;
                transition: all 0.3s ease;
            }
            
            .nav-link::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 0;
                height: 2px;
                background: linear-gradient(90deg, #ef4444, #dc2626);
                transition: width 0.3s ease;
            }
            
            .nav-link:hover::after,
            .nav-link.active::after {
                width: 100%;
            }
            
            .mobile-menu-slide {
                animation: slideDown 0.3s ease-out;
            }
            
            .logo-glow {
                animation: glow 3s ease-in-out infinite;
            }
            
            .glass-effect {
                backdrop-filter: blur(10px);
                background: rgba(0, 0, 0, 0.8);
                border-bottom: 1px solid rgba(239, 68, 68, 0.2);
            }
            
            .flash-message {
                animation: slideDown 0.5s ease-out;
            }
            
            .footer-gradient {
                background: linear-gradient(135deg, #000000 0%, #1a1a1a 50%, #7f1d1d 100%);
            }
            
            .social-icon {
                transition: all 0.3s ease;
            }
            
            .social-icon:hover {
                transform: scale(1.2) rotate(5deg);
                color: #ef4444;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-black text-white">
        <!-- Navigation -->
        <nav class="glass-effect fixed w-full z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                            <div class="w-12 h-12 logo-gradient rounded-xl flex items-center justify-center logo-shadow transform hover:scale-105 transition-all duration-300">
                                    <img src="{{ asset('images/logo.jpeg') }}" alt="{{ __('messages.organization_name') }}" class="w-8 h-8">
                                </div>
                            <span class="font-bold text-2xl text-white group-hover:text-red-400 transition-colors duration-300">
                                {{ __('messages.organization_name') }}
                            </span>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden lg:flex items-center space-x-8">
                        <a href="{{ route('home') }}" 
                           class="nav-link text-gray-300 hover:text-red-400 transition-colors font-medium {{ request()->routeIs('home') ? 'text-red-400 active' : '' }}">
                            {{ __('navigation.home') }}
                        </a>
                        <a href="{{ route('about') }}" 
                           class="nav-link text-gray-300 hover:text-red-400 transition-colors font-medium {{ request()->routeIs('about') ? 'text-red-400 active' : '' }}">
                            {{ __('navigation.about') }}
                        </a>
                        <a href="{{ route('programs') }}" 
                           class="nav-link text-gray-300 hover:text-red-400 transition-colors font-medium {{ request()->routeIs('programs*') ? 'text-red-400 active' : '' }}">
                            {{ __('navigation.programs') }}
                        </a>
                        <a href="{{ route('blogs.index') }}" 
                           class="nav-link text-gray-300 hover:text-red-400 transition-colors font-medium {{ request()->routeIs('blogs') ? 'text-red-400 active' : '' }}">
                            {{ __('navigation.blogs') }}
                        </a>
                        <a href="{{ route('contact') }}" 
                           class="nav-link text-gray-300 hover:text-red-400 transition-colors font-medium {{ request()->routeIs('contact') ? 'text-red-400 active' : '' }}">
                            {{ __('navigation.contact') }}
                        </a>
                        
                        <!-- Enhanced Donate Button -->
                        <a href="{{ route('donate.index') }}" 
                           class="bg-gradient-to-r from-red-600 to-red-500 text-white px-6 py-3 rounded-full hover:from-red-500 hover:to-red-400 transition-all duration-300 transform hover:scale-105 font-bold shadow-lg hover:shadow-red-500/25">
                            {{ __('navigation.donate') }}
                        </a>

                        <!-- Enhanced Language Switcher -->
                        <div class="flex space-x-1 bg-gray-900/50 rounded-full p-1">
                            <a href="{{ route('locale.switch', 'en') }}" 
                               class="px-3 py-2 text-sm rounded-full font-medium transition-all duration-300 {{ app()->getLocale() == 'en' ? 'bg-red-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                                EN
                            </a>
                            <a href="{{ route('locale.switch', 'sw') }}" 
                               class="px-3 py-2 text-sm rounded-full font-medium transition-all duration-300 {{ app()->getLocale() == 'sw' ? 'bg-red-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                                SW
                            </a>
                        </div>

                        @auth
                            <a href="{{ route('dashboard') }}" 
                               class="text-gray-300 hover:text-red-400 transition-colors font-medium flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                <span>{{ __('navigation.dashboard') }}</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="text-gray-300 hover:text-red-400 transition-colors font-medium flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                <span>{{ __('auth.login') }}</span>
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="lg:hidden flex items-center">
                        <button id="mobile-menu-button" class="text-gray-300 hover:text-red-400 focus:outline-none transition-colors duration-300">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Enhanced Mobile Navigation Menu -->
            <div id="mobile-menu" class="lg:hidden hidden">
                <div class="mobile-menu-slide bg-black/95 backdrop-blur-lg border-t border-red-600/20">
                    <div class="px-6 pt-4 pb-6 space-y-3">
                        <a href="{{ route('home') }}" 
                           class="block px-4 py-3 text-gray-300 hover:text-red-400 hover:bg-red-900/20 rounded-lg transition-all duration-300 font-medium {{ request()->routeIs('home') ? 'text-red-400 bg-red-900/20' : '' }}">
                            {{ __('navigation.home') }}
                        </a>
                        <a href="{{ route('about') }}" 
                           class="block px-4 py-3 text-gray-300 hover:text-red-400 hover:bg-red-900/20 rounded-lg transition-all duration-300 font-medium {{ request()->routeIs('about') ? 'text-red-400 bg-red-900/20' : '' }}">
                            {{ __('navigation.about') }}
                        </a>
                        <a href="{{ route('programs') }}" 
                           class="block px-4 py-3 text-gray-300 hover:text-red-400 hover:bg-red-900/20 rounded-lg transition-all duration-300 font-medium {{ request()->routeIs('programs*') ? 'text-red-400 bg-red-900/20' : '' }}">
                            {{ __('navigation.programs') }}
                        </a>
                        <a href="{{ route('blogs.index') }}" 
                           class="block px-4 py-3 text-gray-300 hover:text-red-400 hover:bg-red-900/20 rounded-lg transition-all duration-300 font-medium {{ request()->routeIs('blogs.index') ? 'text-red-400 bg-red-900/20' : '' }}">
                            {{ __('navigation.blogs') }}
                        </a>
                        <a href="{{ route('contact') }}" 
                           class="block px-4 py-3 text-gray-300 hover:text-red-400 hover:bg-red-900/20 rounded-lg transition-all duration-300 font-medium {{ request()->routeIs('contact') ? 'text-red-400 bg-red-900/20' : '' }}">
                            {{ __('navigation.contact') }}
                        </a>
                        
                        <div class="pt-4">
                            <a href="{{ route('donate.index') }}" 
                               class="block bg-gradient-to-r from-red-600 to-red-500 text-white px-6 py-4 rounded-full hover:from-red-500 hover:to-red-400 transition-all duration-300 font-bold text-center shadow-lg">
                                {{ __('navigation.donate') }}
                            </a>
                        </div>
                        
                        <div class="flex justify-center space-x-2 pt-4">
                            <a href="{{ route('locale.switch', 'en') }}" 
                               class="px-4 py-2 text-sm rounded-full font-medium transition-all duration-300 {{ app()->getLocale() == 'en' ? 'bg-red-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                                EN
                            </a>
                            <a href="{{ route('locale.switch', 'sw') }}" 
                               class="px-4 py-2 text-sm rounded-full font-medium transition-all duration-300 {{ app()->getLocale() == 'sw' ? 'bg-red-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                                SW
                            </a>
                        </div>

                        @auth
                            <div class="pt-4 border-t border-gray-700">
                                <a href="{{ route('dashboard') }}" 
                                   class="block px-4 py-3 text-gray-300 hover:text-red-400 hover:bg-red-900/20 rounded-lg transition-all duration-300 font-medium">
                                    {{ __('navigation.dashboard') }}
                                </a>
                            </div>
                        @else
                            <div class="pt-4 border-t border-gray-700">
                                <a href="{{ route('login') }}" 
                                   class="block px-4 py-3 text-gray-300 hover:text-red-400 hover:bg-red-900/20 rounded-lg transition-all duration-300 font-medium">
                                    {{ __('auth.login') }}
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="pt-20">
            <!-- Enhanced Flash Messages -->
            @if (session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                    <div class="flash-message bg-gradient-to-r from-green-900 to-green-800 border border-green-400/30 text-green-100 px-6 py-4 rounded-lg mb-6 shadow-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                    <div class="flash-message bg-gradient-to-r from-red-900 to-red-800 border border-red-400/30 text-red-100 px-6 py-4 rounded-lg mb-6 shadow-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Enhanced Footer -->
        <footer class="footer-gradient text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, #ef4444 0%, transparent 50%), radial-gradient(circle at 75% 75%, #dc2626 0%, transparent 50%);"></div>
            </div>
            
            <div class="relative max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-red-600 to-red-800 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-xl">SYM</span>
                            </div>
                            <span class="font-bold text-3xl text-white">{{ __('messages.organization_name') }}</span>
                        </div>
                        <p class="text-gray-300 mb-6 max-w-lg text-lg leading-relaxed">{{ __('messages.vision') }}</p>
                        <div class="space-y-2">
                            <p class="text-gray-400 flex items-center">
                                <svg class="w-5 h-5 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-9 4v10a2 2 0 002 2h10a2 2 0 002-2V11a2 2 0 00-2-2H7a2 2 0 00-2 2z"></path>
                                </svg>
                                {{ __('messages.established') }}: {{ __('messages.establishment_date') }}
                            </p>
                            <p class="text-gray-400 flex items-center">
                                <svg class="w-5 h-5 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ __('messages.location') }}: {{ __('messages.organization_location') }}
                            </p>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-xl font-bold mb-6 text-red-400">{{ __('navigation.quick_links') }}</h4>
                        <ul class="space-y-3">
                            <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-red-400 transition-colors duration-300 flex items-center group">
                                <span class="group-hover:translate-x-1 transition-transform duration-300">{{ __('navigation.about') }}</span>
                            </a></li>
                            <li><a href="{{ route('programs') }}" class="text-gray-300 hover:text-red-400 transition-colors duration-300 flex items-center group">
                                <span class="group-hover:translate-x-1 transition-transform duration-300">{{ __('navigation.programs') }}</span>
                            </a></li>
                            <li><a href="{{ route('blogs.index') }}" class="text-gray-300 hover:text-red-400 transition-colors duration-300 flex items-center group">
                                <span class="group-hover:translate-x-1 transition-transform duration-300">{{ __('navigation.blogs') }}</span>
                            </a></li>
                            <li><a href="{{ route('stories.index') }}" class="text-gray-300 hover:text-red-400 transition-colors duration-300 flex items-center group">
                                <span class="group-hover:translate-x-1 transition-transform duration-300">{{ __('navigation.stories') }}</span>
                            </a></li>
                            <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-red-400 transition-colors duration-300 flex items-center group">
                                <span class="group-hover:translate-x-1 transition-transform duration-300">{{ __('navigation.contact') }}</span>
                            </a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="text-xl font-bold mb-6 text-red-400">{{ __('navigation.get_involved') }}</h4>
                        <ul class="space-y-3 mb-8">
                            <li><a href="{{ route('donate.index') }}" class="text-gray-300 hover:text-red-400 transition-colors duration-300 flex items-center group">
                                <span class="group-hover:translate-x-1 transition-transform duration-300">{{ __('navigation.donate') }}</span>
                            </a></li>
                            <li><a href="#" class="text-gray-300 hover:text-red-400 transition-colors duration-300 flex items-center group">
                                <span class="group-hover:translate-x-1 transition-transform duration-300">{{ __('navigation.volunteer') }}</span>
                            </a></li>
                            <li><a href="#" class="text-gray-300 hover:text-red-400 transition-colors duration-300 flex items-center group">
                                <span class="group-hover:translate-x-1 transition-transform duration-300">{{ __('navigation.partner') }}</span>
                            </a></li>
                        </ul>
                        
                        <div>
                            <h5 class="text-lg font-bold mb-4 text-red-400">{{ __('navigation.follow_us') }}</h5>
                            <div class="flex space-x-4">
                                <a href="https://www.facebook.com/SautiYa254" class="social-icon text-gray-300 hover:text-red-400 p-2 bg-gray-800 rounded-full hover:bg-red-900/20">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                <a href="https://x.com/Sauti_ya254" class="social-icon text-gray-300 hover:text-red-400 p-2 bg-gray-800 rounded-full hover:bg-red-900/20">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </a>
                                <a href="https://www.instagram.com/sauti_yamtaa/?hl=en" class="social-icon text-gray-300 hover:text-red-400 p-2 bg-gray-800 rounded-full hover:bg-red-900/20">
                                    <span class="sr-only">Instagram</span>
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                    </svg>
                                </a>
                                <a href="#" class="social-icon text-gray-300 hover:text-red-400 p-2 bg-gray-800 rounded-full hover:bg-red-900/20">
                                    <span class="sr-only">LinkedIn</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-700 mt-12 pt-8 text-center">
                    <p class="text-gray-400">
                        &copy; {{ date('Y') }} {{ __('messages.organization_name') }}. {{ __('messages.all_rights_reserved') }}.
                    </p>
                    <p class="text-gray-500 text-sm mt-2">
                        Empowering communities, transforming lives.
                    </p>
                </div>
            </div>
        </footer>

        <!-- Enhanced Mobile Menu JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const mobileMenu = document.getElementById('mobile-menu');
                
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                    
                    // Add animation class when showing
                    if (!mobileMenu.classList.contains('hidden')) {
                        const menuContent = mobileMenu.querySelector('.mobile-menu-slide');
                        menuContent.style.animation = 'none';
                        menuContent.offsetHeight; // Trigger reflow
                        menuContent.style.animation = null;
                    }
                });
                
                // Close mobile menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                    }
                });
                
                // Close mobile menu when resizing to desktop
                window.addEventListener('resize', function() {
                    if (window.innerWidth >= 1024) {
                        mobileMenu.classList.add('hidden');
                    }
                });
                
                // Add scroll effect to navigation
                let lastScrollTop = 0;
                const nav = document.querySelector('nav');
                
                window.addEventListener('scroll', function() {
                    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    
                    if (scrollTop > lastScrollTop && scrollTop > 100) {
                        // Scrolling down
                        nav.style.transform = 'translateY(-100%)';
                        nav.style.opacity = '0.95';
                    } else {
                        // Scrolling up
                        nav.style.transform = 'translateY(0)';
                        nav.style.opacity = '1';
                    }
                    
                    // Add background opacity based on scroll
                    if (scrollTop > 50) {
                        nav.style.background = 'rgba(0, 0, 0, 0.95)';
                        nav.style.backdropFilter = 'blur(15px)';
                    } else {
                        nav.style.background = 'rgba(0, 0, 0, 0.8)';
                        nav.style.backdropFilter = 'blur(10px)';
                    }
                    
                    lastScrollTop = scrollTop;
                });
                
                // Auto-hide flash messages
                const flashMessages = document.querySelectorAll('.flash-message');
                flashMessages.forEach(function(message) {
                    setTimeout(function() {
                        message.style.opacity = '0';
                        message.style.transform = 'translateY(-20px)';
                        setTimeout(function() {
                            message.remove();
                        }, 300);
                    }, 5000);
                });
                
                // Add smooth scrolling to all anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });
            });
        </script>
        
        @stack('scripts')
    </body>
</html>