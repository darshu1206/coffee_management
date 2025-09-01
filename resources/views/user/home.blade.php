@extends('layouts.user-layout')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden">
    <div class="coffee-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    Premium Coffee
                    <span class="block text-yellow-300">Delivered Fresh</span>
                </h1>
                <p class="text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
                    Discover the world's finest coffee beans, expertly roasted and delivered straight to your door. 
                    Start your perfect morning with us.
                </p>
                <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
                    <a href="{{ route('user.shop') }}" 
                       class="btn-coffee px-8 py-4 rounded-lg font-semibold text-lg inline-block">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Shop Now
                    </a>
                    <a href="{{ route('user.about') }}" 
                       class="border-2 border-white text-white hover:bg-white hover:text-gray-900 px-8 py-4 rounded-lg font-semibold text-lg inline-block transition-colors">
                        <i class="fas fa-info-circle mr-2"></i>
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 transform rotate-12 opacity-20">
            <i class="fas fa-coffee text-6xl text-yellow-300"></i>
        </div>
        <div class="absolute bottom-20 right-10 transform -rotate-12 opacity-20">
            <i class="fas fa-coffee text-8xl text-yellow-300"></i>
        </div>
        <div class="absolute top-1/2 left-1/4 transform rotate-45 opacity-10">
            <i class="fas fa-coffee text-4xl text-white"></i>
        </div>
    </div>
</div>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Why Choose Our Coffee?</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                We're passionate about delivering the perfect cup every time
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6 hover-lift">
                <div class="p-4 bg-yellow-100 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-seedling text-3xl text-yellow-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Premium Quality</h3>
                <p class="text-gray-600">
                    Hand-selected beans from the world's finest coffee regions, ensuring exceptional taste and aroma.
                </p>
            </div>
            
            <div class="text-center p-6 hover-lift">
                <div class="p-4 bg-blue-100 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-shipping-fast text-3xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Fresh Delivery</h3>
                <p class="text-gray-600">
                    Roasted to order and shipped within 24 hours to guarantee maximum freshness and flavor.
                </p>
            </div>
            
            <div class="text-center p-6 hover-lift">
                <div class="p-4 bg-green-100 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-leaf text-3xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Sustainable</h3>
                <p class="text-gray-600">
                    Ethically sourced and environmentally friendly practices that support coffee farming communities.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Browse by Category</h2>
            <p class="text-lg text-gray-600">Find your perfect match from our carefully curated selection</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('user.shop', ['category' => $category->id]) }}" 
               class="coffee-card rounded-xl p-6 text-center hover-lift group">
                
                    @if($category->image_url)
                        <img src="{{ asset('images/category_images/' . $category->image_url) }}" 
                            alt="{{ $category->name }}" 
                            class="w-32 h-32 object-cover rounded-3xl mx-auto">
                    @else
                        <div class="p-4 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center group-hover:from-yellow-500 group-hover:to-yellow-700 transition-all">
                            <i class="fas fa-coffee text-2xl text-white"></i>
                        </div>
                    @endif
                
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $category->name }}</h3>
                <p class="text-sm text-gray-600 mb-2">{{ $category->description ?? 'Premium selection' }}</p>
                <span class="text-xs bg-gray-100 px-2 py-1 rounded-full">
                    {{ $category->coffees_count }} {{ Str::plural('coffee', $category->coffees_count) }}
                </span>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Bestsellers Section -->
@if($bestsellers->count() > 0)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <i class="fas fa-crown text-yellow-500 mr-3"></i>
                Bestsellers
            </h2>
            <p class="text-lg text-gray-600">Our customers' favorite picks</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($bestsellers as $coffee)
            <div class="coffee-card rounded-xl overflow-hidden hover-lift group">
                <div class="relative">
                    @if($coffee->image_url)
                        <img src="{{ asset('images/coffee_images/' . $coffee->image_url) }}" alt="{{ $coffee->name }}" 
                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center">
                            <i class="fas fa-coffee text-6xl text-white"></i>
                        </div>
                    @endif
                    <div class="absolute top-3 left-3">
                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                            <i class="fas fa-fire mr-1"></i>Bestseller
                        </span>
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="bg-white text-gray-900 px-2 py-1 rounded-full text-sm font-bold">
                            ₹{{ number_format($coffee->price, 2) }}
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 mb-2">{{ $coffee->name }}</h3>
                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($coffee->description, 80) }}</p>
                    
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ ucfirst($coffee->roast_level) }}</span>
                        <span class="text-xs text-gray-500">{{ $coffee->origin }}</span>
                    </div>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('user.product.detail', $coffee->id) }}" 
                           class="flex-1 btn-coffee py-2 px-3 text-center rounded-lg text-sm font-medium">
                            View Details
                        </a>
                        @auth
                        <button onclick="addToCart({{ $coffee->id }})" 
                                class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-lg transition-colors">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('user.shop') }}" 
               class="btn-coffee px-8 py-3 rounded-lg font-semibold inline-block">
                View All Products <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Featured Products Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Featured Products</h2>
            <p class="text-lg text-gray-600">Discover our latest arrivals and seasonal favorites</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredCoffees->take(8) as $coffee)
            <div class="coffee-card rounded-xl overflow-hidden hover-lift">
                <div class="relative">
                    @if($coffee->image_url)
                        <img src="{{ asset('images/coffee_images/' . $coffee->image_url) }}" alt="{{ $coffee->name }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center">
                            <i class="fas fa-coffee text-6xl text-white"></i>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3">
                        <span class="bg-white text-gray-900 px-2 py-1 rounded-full text-sm font-bold">
                            ₹{{ number_format($coffee->price, 2) }}
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 mb-2">{{ $coffee->name }}</h3>
                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($coffee->description, 80) }}</p>
                    
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ ucfirst($coffee->roast_level) }}</span>
                        <span class="text-xs text-gray-500">{{ $coffee->origin }}</span>
                    </div>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('user.product.detail', $coffee->id) }}" 
                           class="flex-1 btn-coffee py-2 px-3 text-center rounded-lg text-sm font-medium">
                            View Details
                        </a>
                        @auth
                        <button onclick="addToCart({{ $coffee->id }})" 
                                class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-lg transition-colors">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="coffee-gradient py-16">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Ready to Start Your Coffee Journey?
        </h2>
        <p class="text-xl text-gray-200 mb-8">
            Join thousands of coffee lovers who trust us for their daily brew
        </p>
        <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
            @guest
            <a href="{{ route('register') }}" 
               class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 px-8 py-4 rounded-lg font-semibold text-lg inline-block transition-colors">
                <i class="fas fa-user-plus mr-2"></i>
                Sign Up Now
            </a>
            @else
            <a href="{{ route('user.shop') }}" 
               class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 px-8 py-4 rounded-lg font-semibold text-lg inline-block transition-colors">
                <i class="fas fa-shopping-bag mr-2"></i>
                Start Shopping
            </a>
            @endguest
            <a href="{{ route('user.contact') }}" 
               class="border-2 border-white text-white hover:bg-white hover:text-gray-900 px-8 py-4 rounded-lg font-semibold text-lg inline-block transition-colors">
                <i class="fas fa-envelope mr-2"></i>
                Contact Us
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function addToCart(coffeeId) {
    // Add to cart functionality - you'll need to implement this
    fetch('{{ route("user.cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            coffee_id: coffeeId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count
            document.getElementById('cart-count').textContent = data.cart_count;
            // Show success message
            showToast('Item added to cart!', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to add item to cart', 'error');
    });
}

function showToast(message, type) {
    // Simple toast notification
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
@endpush