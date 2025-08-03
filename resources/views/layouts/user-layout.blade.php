<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Coffee Shop') }} - @yield('title', 'Welcome')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .coffee-gradient {
            background: linear-gradient(135deg, #6B4423 0%, #8B4513 50%, #A0522D 100%);
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .coffee-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
        }
        
        .btn-coffee {
            background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-coffee:hover {
            background: linear-gradient(135deg, #A0522D 0%, #CD853F 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(139, 69, 19, 0.4);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="coffee-gradient shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('user.home') }}" class="flex items-center space-x-2">
                        <i class="fas fa-coffee text-2xl text-white"></i>
                        <span class="text-xl font-bold text-white">{{ config('app.name', 'Coffee Shop') }}</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('user.home') }}" 
                       class="text-white hover:text-yellow-300 transition-colors duration-200 {{ request()->routeIs('user.home') ? 'text-yellow-300 border-b-2 border-yellow-300' : '' }}">
                        <i class="fas fa-home mr-1"></i> Home
                    </a>
                    <a href="{{ route('user.shop') }}" 
                       class="text-white hover:text-yellow-300 transition-colors duration-200 {{ request()->routeIs('user.shop') ? 'text-yellow-300 border-b-2 border-yellow-300' : '' }}">
                        <i class="fas fa-store mr-1"></i> Shop
                    </a>
                    @auth
                    <a href="{{ route('user.dashboard') }}" 
                       class="text-white hover:text-yellow-300 transition-colors duration-200 {{ request()->routeIs('user.dashboard') ? 'text-yellow-300 border-b-2 border-yellow-300' : '' }}">
                        <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('user.orders') }}" 
                       class="text-white hover:text-yellow-300 transition-colors duration-200 {{ request()->routeIs('user.orders*') ? 'text-yellow-300 border-b-2 border-yellow-300' : '' }}">
                        <i class="fas fa-history mr-1"></i> Orders
                    </a>
                    @endauth
                    <a href="{{ route('user.about') }}" 
                       class="text-white hover:text-yellow-300 transition-colors duration-200 {{ request()->routeIs('user.about') ? 'text-yellow-300 border-b-2 border-yellow-300' : '' }}">
                        <i class="fas fa-info-circle mr-1"></i> About
                    </a>
                    <a href="{{ route('user.contact') }}" 
                       class="text-white hover:text-yellow-300 transition-colors duration-200 {{ request()->routeIs('user.contact*') ? 'text-yellow-300 border-b-2 border-yellow-300' : '' }}">
                        <i class="fas fa-envelope mr-1"></i> Contact
                    </a>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- Cart -->
                    @auth
                    <a href="{{ route('user.cart') }}" class="text-white hover:text-yellow-300 transition-colors relative">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center" id="cart-count">0</span>
                    </a>
                    @endauth

                    <!-- User Menu -->
                    @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-white hover:text-yellow-300 transition-colors">
                            <i class="fas fa-user-circle text-xl mr-1"></i>
                            {{ Auth::user()->name }}
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <!-- <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a> -->
                            <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('login') }}" class="text-white hover:text-yellow-300 transition-colors">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 px-4 py-2 rounded-md transition-colors font-medium">
                            Register
                        </a>
                    </div>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-data="{ mobileMenuOpen: false }" 
             class="md:hidden bg-gray-800 border-t border-gray-700">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('user.home') }}" class="block px-3 py-2 text-white hover:bg-gray-700 rounded-md">Home</a>
                <a href="{{ route('user.shop') }}" class="block px-3 py-2 text-white hover:bg-gray-700 rounded-md">Shop</a>
                @auth
                <a href="{{ route('user.dashboard') }}" class="block px-3 py-2 text-white hover:bg-gray-700 rounded-md">Dashboard</a>
                <a href="{{ route('user.orders') }}" class="block px-3 py-2 text-white hover:bg-gray-700 rounded-md">Orders</a>
                @endauth
                <a href="{{ route('user.about') }}" class="block px-3 py-2 text-white hover:bg-gray-700 rounded-md">About</a>
                <a href="{{ route('user.contact') }}" class="block px-3 py-2 text-white hover:bg-gray-700 rounded-md">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="coffee-gradient mt-16">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-coffee text-2xl text-white"></i>
                        <span class="text-xl font-bold text-white">{{ config('app.name') }}</span>
                    </div>
                    <p class="text-gray-300 text-sm">
                        Premium coffee beans from around the world, roasted to perfection and delivered fresh to your door.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('user.home') }}" class="text-gray-300 hover:text-yellow-300 transition-colors text-sm">Home</a></li>
                        <li><a href="{{ route('user.shop') }}" class="text-gray-300 hover:text-yellow-300 transition-colors text-sm">Shop</a></li>
                        <li><a href="{{ route('user.about') }}" class="text-gray-300 hover:text-yellow-300 transition-colors text-sm">About Us</a></li>
                        <li><a href="{{ route('user.contact') }}" class="text-gray-300 hover:text-yellow-300 transition-colors text-sm">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Customer Service</h3>
                    <ul class="space-y-2">
                        @auth
                        <li><a href="{{ route('user.orders') }}" class="text-gray-300 hover:text-yellow-300 transition-colors text-sm">Order History</a></li>
                        <li><a href="{{ route('user.profile') }}" class="text-gray-300 hover:text-yellow-300 transition-colors text-sm">My Account</a></li>
                        @endauth
                        <li><a href="#" class="text-gray-300 hover:text-yellow-300 transition-colors text-sm">FAQ</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-yellow-300 transition-colors text-sm">Shipping Info</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Contact Info</h3>
                    <ul class="space-y-2 text-gray-300 text-sm">
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Rajkot, Gujarat, India </li>
                        <li><i class="fas fa-phone mr-2"></i> +91 70462 99385 </li>
                        <li><i class="fas fa-envelope mr-2"></i> info@coffeeshop.com</li>
                    </ul>
                    
                    <!-- Social Media -->
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-300 hover:text-yellow-300 transition-colors">
                            <i class="fab fa-facebook text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-yellow-300 transition-colors">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-yellow-300 transition-colors">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-300 text-sm">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    @stack('scripts')
</body>
</html>