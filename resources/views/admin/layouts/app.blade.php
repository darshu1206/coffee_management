<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Coffee Shop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="text-white w-64 min-h-screen p-4 fixed top-0 left-0 h-screen" style="background-color: #5B3E32;">
            <!-- Logo -->
            <div class="flex items-center space-x-2 mb-8">
                <i class="fas fa-coffee text-2xl"></i>
                <div>
                    <h1 class="text-xl font-bold">CoffeeShop</h1>
                    <p class="text-amber-200 text-sm">Admin Panel</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-[#986a57] transition-colors {{ request()->routeIs('admin.dashboard*') ? 'bg-[#986a57]' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-[#986a57] transition-colors {{ request()->routeIs('admin.users*') ? 'bg-[#986a57]' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>

                <a href="{{ route('admin.coffees.index') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-[#986a57] transition-colors {{ request()->routeIs('admin.coffees*') ? 'bg-[#986a57]' : '' }}">
                    <i class="fas fa-coffee"></i>
                    <span>Coffees</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-[#986a57] transition-colors {{ request()->routeIs('admin.categories*') ? 'bg-[#986a57]' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span>Categories</span>
                </a>

                <!-- <a href="{{ route('admin.suppliers.index') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-[#986a57] transition-colors {{ request()->routeIs('admin.suppliers*') ? 'bg-[#986a57]' : '' }}">
                    <i class="fas fa-truck"></i>
                    <span>Suppliers</span>
                </a> -->

                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-[#986a57] transition-colors {{ request()->routeIs('admin.orders*') ? 'bg-[#986a57]' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
            </nav>

            <!-- User Info -->
            <div class="absolute bottom-4 left-4 w-56 mx-auto">
                <div class="bg-[#986a57] p-3 rounded-lg">
                    <div class="flex items-center space-x-2 mb-2">
                        <i class="fas fa-user-shield"></i>
                        <span class="font-medium">{{ Auth::user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 px-3 py-2 rounded text-sm transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col pl-64">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800">@yield('header', 'Admin Panel')</h2>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('user.home') }}" target="_blank" class="text-[#5B3E32] hover:text-[#986a57]">
                            <i class="fas fa-external-link-alt mr-1"></i>View Site
                        </a>
                        <span class="text-gray-600">{{ now()->format('M d, Y') }}</span>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 p-6">
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>