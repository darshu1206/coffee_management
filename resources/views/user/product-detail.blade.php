@extends('layouts.user-layout')

@section('title', $coffee->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('user.home') }}" class="text-gray-700 hover:text-yellow-600">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('user.shop') }}" class="text-gray-700 hover:text-yellow-600">Shop</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">{{ $coffee->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">
        <!-- Product Images -->
        <div>
            <div class="sticky top-24">
                <!-- Main Image -->
                <div class="bg-gray-100 rounded-2xl overflow-hidden mb-4 aspect-square">
                    @if($coffee->image_url)
                        <img src="{{ asset('images/coffee_images/' . $coffee->image_url) }}" alt="{{ $coffee->name }}" 
                             class="w-full h-full object-cover" id="main-image">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center">
                            <i class="fas fa-coffee text-8xl text-white"></i>
                        </div>
                    @endif
                </div>
                
                <!-- Thumbnail Images (if you have multiple images) -->
                <div class="flex space-x-2">
                    @if($coffee->image_url)
                        <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden cursor-pointer border-2 border-yellow-500">
                            <img src="{{ asset('images/coffee_images/' . $coffee->image_url) }}" alt="{{ $coffee->name }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div>
            <div class="mb-4">
                <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-medium rounded-full mb-2">
                    {{ $coffee->category->name ?? 'Coffee' }}
                </span>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $coffee->name }}</h1>
                <div class="flex items-center mb-4">
                    <div class="flex items-center mr-4">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-yellow-400"></i>
                        @endfor
                        <span class="text-gray-600 ml-2">(4.8) • 127 reviews</span>
                    </div>
                </div>
            </div>

            <!-- Price -->
            <div class="mb-6">
                <span class="text-4xl font-bold text-gray-900">₹{{ number_format($coffee->price, 2) }}</span>
                <span class="text-lg text-gray-500 ml-2">per bag</span>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                <p class="text-gray-600 leading-relaxed">{{ $coffee->description }}</p>
            </div>

            <!-- Product Details -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="coffee-card p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-fire text-orange-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-500">Roast Level</p>
                            <p class="font-semibold text-gray-900">{{ ucfirst($coffee->roast_level) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="coffee-card p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-globe text-green-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-500">Origin</p>
                            <p class="font-semibold text-gray-900">{{ $coffee->origin }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="coffee-card p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-weight-hanging text-blue-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-500">Weight</p>
                            <p class="font-semibold text-gray-900">12 oz (340g)</p>
                        </div>
                    </div>
                </div>
                
                <div class="coffee-card p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-box text-purple-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-500">Stock</p>
                            <p class="font-semibold text-gray-900">{{ $coffee->stock_quantity }} available</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add to Cart Section -->
            @auth
            <div class="border-t pt-6">
                <form onsubmit="addToCartWithQuantity(event, {{ $coffee->id }})">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="flex items-center">
                            <label class="text-sm font-medium text-gray-700 mr-3">Quantity:</label>
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button type="button" onclick="decreaseQuantity()" 
                                        class="px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" id="quantity" value="1" min="1" max="{{ $coffee->stock_quantity }}" 
                                       class="w-16 text-center border-0 focus:ring-0">
                                <button type="button" onclick="increaseQuantity()" 
                                        class="px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex space-x-4">
                        @if($coffee->stock_quantity > 0)
                            <button type="submit" 
                                    class="flex-1 btn-coffee py-3 px-6 rounded-lg font-semibold text-lg">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Add to Cart
                            </button>
                            <button type="button" onclick="addToWishlist({{ $coffee->id }})"
                                    class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:border-red-500 hover:text-red-500 transition-colors">
                                <i class="far fa-heart"></i>
                            </button>
                        @else
                            <button disabled class="flex-1 bg-gray-300 text-gray-500 py-3 px-6 rounded-lg font-semibold text-lg cursor-not-allowed">
                                <i class="fas fa-times mr-2"></i>
                                Out of Stock
                            </button>
                        @endif
                    </div>
                </form>
            </div>
            @else
            <div class="border-t pt-6">
                <p class="text-gray-600 mb-4">Please log in to add items to your cart.</p>
                <div class="flex space-x-4">
                    <a href="{{ route('login') }}" 
                       class="flex-1 btn-coffee py-3 px-6 rounded-lg font-semibold text-lg text-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login to Order
                    </a>
                    <a href="{{ route('register') }}" 
                       class="px-6 py-3 border-2 border-yellow-600 text-yellow-600 rounded-lg hover:bg-yellow-600 hover:text-white transition-colors font-semibold">
                        Register
                    </a>
                </div>
            </div>
            @endauth

            <!-- Additional Info -->
            <div class="mt-8 space-y-4">
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-truck text-green-500 mr-2"></i>
                    Free shipping on orders over ₹500
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-undo text-blue-500 mr-2"></i>
                    30-day return guarantee
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-shield-alt text-purple-500 mr-2"></i>
                    Secure payment processing
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Section -->
    <div class="border-t pt-12" x-data="{ activeTab: 'description' }">
        <div class="flex border-b border-gray-200 mb-8">
            <button @click="activeTab = 'description'" 
                    :class="activeTab === 'description' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-2 px-1 border-b-2 font-medium text-sm mr-8">
                Description
            </button>
            <button @click="activeTab = 'reviews'" 
                    :class="activeTab === 'reviews' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-2 px-1 border-b-2 font-medium text-sm mr-8">
                Reviews (127)
            </button>
            <button @click="activeTab = 'brewing'" 
                    :class="activeTab === 'brewing' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-2 px-1 border-b-2 font-medium text-sm">
                Brewing Guide
            </button>
        </div>

        <!-- Tab Contents -->
        <div x-show="activeTab === 'description'" class="space-y-4">
            <h3 class="text-xl font-semibold text-gray-900">About This Coffee</h3>
            <p class="text-gray-600 leading-relaxed">
                {{ $coffee->description }} This premium coffee is carefully selected from the finest beans, 
                roasted to perfection to bring out its unique flavor profile and aroma.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <h4 class="font-semibold text-gray-900 mb-2">Tasting Notes</h4>
                    <ul class="text-gray-600 space-y-1">
                        <li>• Rich chocolate undertones</li>
                        <li>• Subtle fruity notes</li>
                        <li>• Smooth, balanced finish</li>
                        <li>• Medium body with low acidity</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-2">Processing Details</h4>
                    <ul class="text-gray-600 space-y-1">
                        <li>• Altitude: 1,200-1,800m</li>
                        <li>• Processing: Washed</li>
                        <li>• Harvest: Hand-picked</li>
                        <li>• Roast Date: Within 7 days</li>
                    </ul>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'reviews'" class="space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold text-gray-900">Customer Reviews</h3>
                <button class="btn-coffee px-4 py-2 rounded-lg font-medium">
                    Write a Review
                </button>
            </div>
            
            <!-- Sample Reviews -->
            <div class="space-y-6">
                <div class="border-b pb-6">
                    <div class="flex items-center mb-2">
                        <div class="flex items-center mr-4">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-yellow-400"></i>
                            @endfor
                        </div>
                        <span class="font-semibold text-gray-900">Sarah Johnson</span>
                        <span class="text-gray-500 text-sm ml-2">• 2 days ago</span>
                    </div>
                    <p class="text-gray-600">
                        Absolutely love this coffee! The flavor is rich and smooth, perfect for my morning routine. 
                        Fast shipping and great packaging too.
                    </p>
                </div>
                
                <div class="border-b pb-6">
                    <div class="flex items-center mb-2">
                        <div class="flex items-center mr-4">
                            @for($i = 1; $i <= 4; $i++)
                                <i class="fas fa-star text-yellow-400"></i>
                            @endfor
                            <i class="far fa-star text-yellow-400"></i>
                        </div>
                        <span class="font-semibold text-gray-900">Mike Chen</span>
                        <span class="text-gray-500 text-sm ml-2">• 1 week ago</span>
                    </div>
                    <p class="text-gray-600">
                        Great quality coffee with excellent aroma. The roast level is perfect for espresso. 
                        Will definitely order again!
                    </p>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'brewing'" class="space-y-6">
            <h3 class="text-xl font-semibold text-gray-900">How to Brew the Perfect Cup</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3">
                        <i class="fas fa-coffee text-yellow-600 mr-2"></i>
                        Drip Coffee
                    </h4>
                    <ul class="text-gray-600 space-y-2">
                        <li><strong>Ratio:</strong> 1:15 (coffee to water)</li>
                        <li><strong>Grind:</strong> Medium</li>
                        <li><strong>Water temp:</strong> 195-205°F</li>
                        <li><strong>Brew time:</strong> 4-6 minutes</li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3">
                        <i class="fas fa-coffee text-yellow-600 mr-2"></i>
                        Espresso
                    </h4>
                    <ul class="text-gray-600 space-y-2">
                        <li><strong>Ratio:</strong> 1:2 (coffee to water)</li>
                        <li><strong>Grind:</strong> Fine</li>
                        <li><strong>Water temp:</strong> 190-196°F</li>
                        <li><strong>Brew time:</strong> 25-30 seconds</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedCoffees->count() > 0)
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">You Might Also Like</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedCoffees as $relatedCoffee)
            <div class="coffee-card rounded-xl overflow-hidden hover-lift">
                <div class="relative">
                    @if($relatedCoffee->image_url) 
                        <img src="{{ asset('images/coffee_images/' . $relatedCoffee->image_url) }}" alt="{{ $relatedCoffee->name }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center">
                            <i class="fas fa-coffee text-4xl text-white"></i>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3">
                        <span class="bg-white text-gray-900 px-2 py-1 rounded-full text-sm font-bold">
                            ₹{{ number_format($relatedCoffee->price, 2) }}
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 mb-2">{{ $relatedCoffee->name }}</h3>
                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($relatedCoffee->description, 60) }}</p>
                    <a href="{{ route('user.product.detail', $relatedCoffee->id) }}" 
                       class="btn-coffee w-full py-2 px-3 text-center rounded-lg text-sm font-medium block">
                        View Details
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function increaseQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.getAttribute('max'));
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    const min = parseInt(input.getAttribute('min'));
    const current = parseInt(input.value);
    if (current > min) {
        input.value = current - 1;
    }
}

function addToCartWithQuantity(event, coffeeId) {
    event.preventDefault();
    const quantity = document.getElementById('quantity').value;
    
    fetch('{{ route("user.cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            coffee_id: coffeeId,
            quantity: parseInt(quantity)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('cart-count').textContent = data.cart_count;
            showToast('Added to cart successfully!', 'success');
        } else {
            showToast('Failed to add to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to add to cart', 'error');
    });
}

function addToWishlist(coffeeId) {
    // Wishlist functionality - implement as needed
    showToast('Added to wishlist!', 'success');
}

function showToast(message, type) {
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