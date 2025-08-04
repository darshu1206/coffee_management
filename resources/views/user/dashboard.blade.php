@extends('layouts.user-layout')

@section('title', 'Dashboard - Coffee Shop')

@section('content')
<!-- Hero Section -->
<div class="coffee-gradient py-12">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-3">
            <i class="fas fa-tachometer-alt text-yellow-300 mr-2"></i>
            Welcome back, {{ Auth::user()->name }}!
        </h1>
        <p class="text-xl text-gray-200">Here's your coffee journey overview</p>
    </div>
</div>

<!-- Dashboard Content -->
<div class="max-w-7xl mx-auto px-4 py-16 space-y-12">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Orders -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Orders</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Pending Orders</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $pendingOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Spent -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Spent</p>
                    <p class="text-3xl font-bold text-green-600">₹{{ number_format($totalSpent, 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders and Favorites -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Recent Orders</h2>
                <a href="{{ route('user.orders') }}" class="text-amber-600 hover:text-amber-700 text-sm font-medium">View All</a>
            </div>

            @if($recentOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow transition">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-semibold text-gray-800">Order #{{ $order->id }}</span>
                                <span class="text-xs px-2 py-1 rounded-full 
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status == 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ $order->orderItems->count() }} item(s) • ₹{{ number_format($order->total_amount, 2) }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                @foreach($order->orderItems->take(2) as $item)
                                    {{ $item->coffee->name }}{{ !$loop->last ? ',' : '' }}
                                @endforeach
                                @if($order->orderItems->count() > 2)
                                    and {{ $order->orderItems->count() - 2 }} more...
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-500 py-8">
                    <p>No orders yet</p>
                    <a href="{{ route('user.shop') }}" class="mt-3 inline-block bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700 transition">Start Shopping</a>
                </div>
            @endif
        </div>

        <!-- Favorite Categories -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Your Favorite Categories</h2>

            @if($favoriteCategories->count() > 0)
                <div class="space-y-4">
                    @foreach($favoriteCategories as $category)
                        <div class="flex justify-between items-center border border-gray-200 p-4 rounded-lg hover:shadow transition">
                            <div>
                                <h3 class="font-medium text-gray-800">{{ $category->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $category->description }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $category->order_count }} orders</p>
                            </div>
                            <a href="{{ route('user.shop', ['category' => $category->id]) }}"
                               class="bg-amber-600 text-white text-sm px-3 py-1 rounded hover:bg-amber-700 transition">
                                Shop
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-500 py-8">
                    <p>You haven’t discovered any favorites yet</p>
                    <a href="{{ route('user.shop') }}" class="mt-3 inline-block bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700 transition">Browse Categories</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Featured Coffees -->
    @if($featuredCoffees->count() > 0)
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Featured Coffees</h2>
            <a href="{{ route('user.shop') }}" class="text-amber-600 hover:text-amber-700 text-sm font-medium">View All</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredCoffees->take(6) as $coffee)
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow transition">
                    @if($coffee->image_url)
                        <img src="{{ asset('images/coffee_images/' . $coffee->image_url) }}" alt="{{ $coffee->name }}" class="w-full h-32 object-cover">
                    @else
                        <div class="w-full h-32 bg-gray-100 flex items-center justify-center text-gray-400">No Image</div>
                    @endif

                    <div class="p-4">
                        <h3 class="font-medium text-gray-900">{{ $coffee->name }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ Str::limit($coffee->description, 50) }}</p>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-lg font-bold text-amber-600">₹{{ number_format($coffee->price, 2) }}</span>
                            <span class="text-xs text-gray-500">{{ ucfirst($coffee->roast_level) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">{{ $coffee->origin }}</span>
                            <a href="{{ route('user.product.detail', $coffee->id) }}"
                               class="text-xs bg-amber-600 text-white px-3 py-1 rounded hover:bg-amber-700 transition">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
