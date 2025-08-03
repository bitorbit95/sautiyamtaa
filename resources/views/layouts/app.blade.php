<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sauti ya Mtaa') }} - @yield('title', __('navigation.dashboard'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
  
        <style>
            .logo-gradient {
                background: linear-gradient(135deg, #1a1a1a 0%, #dc2626 100%);
            }
            .logo-shadow {
                box-shadow: 0 4px 20px rgba(220, 38, 38, 0.3);
            }
            .logo-svg {
                filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
            }
            .dashboard-card {
                background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }
            .dashboard-nav {
                background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            }

    </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
            <!-- Navigation -->
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow-lg border-b border-gray-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center space-x-4">
                            <!-- Mini Logo for Header -->
                            <div class="w-12 h-12 logo-gradient rounded-xl flex items-center justify-center logo-shadow transform hover:scale-105 transition-all duration-300">
                                    <img src="{{ asset('images/logo.jpeg') }}" alt="{{ __('messages.organization_name') }}" class="w-8 h-8">
                                </div>
                            <div class="flex-1">
                                {{ $header }}
                            </div>
                        </div>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="pb-16">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 text-green-800 px-6 py-4 rounded-r-lg shadow-md">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                        <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-400 text-red-800 px-6 py-4 rounded-r-lg shadow-md">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Enhanced Footer -->
            <footer class="dashboard-nav text-white mt-16">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div class="col-span-1 md:col-span-2">
                            <div class="flex items-center space-x-3 mb-4">
                                <!-- Footer Logo -->
                                <div class="w-10 h-10 logo-gradient rounded-xl flex items-center justify-center logo-shadow">
                                    <svg class="w-6 h-6 logo-svg" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 6C16 6 12 8 8 12C6 14 4 16 4 20C4 24 6 26 8 28C12 32 16 34 16 34" stroke="white" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                                        <path d="M16 10C16 10 14 11 12 14C11 15 10 16 10 18C10 20 11 21 12 22C14 25 16 26 16 26" stroke="white" stroke-width="2" stroke-linecap="round" fill="none"/>
                                        <circle cx="20" cy="12" r="3" fill="white"/>
                                        <circle cx="26" cy="16" r="2.5" fill="rgba(255,255,255,0.8)"/>
                                        <circle cx="22" cy="20" r="2" fill="rgba(255,255,255,0.7)"/>
                                        <path d="M20 15L22 18M24 16L22 18" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <h3 class="text-lg font-bold">{{ __('messages.organization_name') }}</h3>
                                    <span class="text-sm text-red-400 font-medium tracking-wider">Dashboard Portal</span>
                                </div>
                            </div>
                            <p class="text-gray-300 text-sm max-w-md leading-relaxed">{{ __('messages.vision') }}</p>
                            <div class="mt-4 space-y-1">
                                <p class="text-gray-400 text-xs">{{ __('messages.established') }}: {{ __('messages.establishment_date') }}</p>
                                <p class="text-gray-400 text-xs">{{ __('messages.location') }}: {{ __('messages.organization_location') }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-md font-semibold mb-3 text-red-400 border-b border-gray-700 pb-2">{{ __('navigation.quick_links') }}</h4>
                            <ul class="space-y-2 text-sm">
                                <li><a href="/about" class="text-gray-300 hover:text-red-400 transition-colors duration-200 flex items-center group">
                                    <span class="w-1.5 h-1.5 bg-gray-600 rounded-full mr-2 group-hover:bg-red-400 transition-colors"></span>
                                    {{ __('navigation.about') }}
                                </a></li>
                                <li><a href="/programs" class="text-gray-300 hover:text-red-400 transition-colors duration-200 flex items-center group">
                                    <span class="w-1.5 h-1.5 bg-gray-600 rounded-full mr-2 group-hover:bg-red-400 transition-colors"></span>
                                    {{ __('navigation.programs') }}
                                </a></li>
                                <li><a href="/blogs" class="text-gray-300 hover:text-red-400 transition-colors duration-200 flex items-center group">
                                    <span class="w-1.5 h-1.5 bg-gray-600 rounded-full mr-2 group-hover:bg-red-400 transition-colors"></span>
                                    {{ __('navigation.blogs') }}
                                </a></li>
                                <li><a href="/contact" class="text-gray-300 hover:text-red-400 transition-colors duration-200 flex items-center group">
                                    <span class="w-1.5 h-1.5 bg-gray-600 rounded-full mr-2 group-hover:bg-red-400 transition-colors"></span>
                                    {{ __('navigation.contact') }}
                                </a></li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 class="text-md font-semibold mb-3 text-red-400 border-b border-gray-700 pb-2">{{ __('navigation.language') }}</h4>
                            <div class="space-y-2">
                                <a href="/locale/en" 
                                   class="flex items-center space-x-2 px-3 py-2 text-sm rounded-lg transition-all duration-200 {{ app()->getLocale() == 'en' ? 'bg-red-600 text-white shadow-lg' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>English</span>
                                </a>
                                <a href="/locale/sw" 
                                   class="flex items-center space-x-2 px-3 py-2 text-sm rounded-lg transition-all duration-200 {{ app()->getLocale() == 'sw' ? 'bg-red-600 text-white shadow-lg' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Kiswahili</span>
                                </a>
                            </div>
                            
                            <!-- Additional Dashboard Links -->
                            <div class="mt-6">
                                <h5 class="text-sm font-semibold mb-2 text-red-400">Dashboard</h5>
                                <div class="space-y-1">
                                    <a href="/dashboard/status" class="block text-xs text-gray-400 hover:text-gray-300">System Status</a>
                                    <a href="/help" class="block text-xs text-gray-400 hover:text-gray-300">Help Center</a>
                                    <a href="/api/docs" class="block text-xs text-gray-400 hover:text-gray-300">API Documentation</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-700 mt-8 pt-6">
                        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
                            <p class="text-sm text-gray-400">
                                &copy; {{ date('Y') }} {{ __('messages.organization_name') }}. {{ __('messages.all_rights_reserved') }}.
                            </p>
                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                <span>Dashboard v2.1.0</span>
                                <span>•</span>
                                <span>Last updated: {{ date('M j, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>