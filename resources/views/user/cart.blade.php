@extends('layouts.user-layout')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            <i class="fas fa-shopping-cart text-yellow-600 mr-3"></i>
            Shopping Cart
        </h1>
        <p class="text-gray-600">Review your items and proceed to checkout</p>
    </div>

    @if($cartItems->count() > 0)
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
            <!-- Cart Items -->
            <div class="lg:col-span-7">
                <div class="coffee-card rounded-xl p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">
                        Cart Items ({{ $cartItems->count() }})
                    </h2>
                    
                    <div class="space-y-6">
                        @foreach($cartItems as $item)
                        <div class="flex items-center space-x-4 py-4 border-b border-gray-200 last:border-b-0">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                @if($item->coffee->image_url)
                                    <img src="{{ asset('images/coffee_images/' . $item->coffee->image_url) }}" alt="{{ $item->coffee->name }}" 
                                         class="w-20 h-20 object-cover rounded-lg">
                                @else
                                    <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-coffee text-2xl text-white"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Details -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-medium text-gray-900">
                                    <a href="{{ route('user.product.detail', $item->coffee->id) }}" 
                                       class="hover:text-yellow-600">
                                        {{ $item->coffee->name }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">{{ Str::limit($item->coffee->description, 60) }}</p>
                                <div class="flex items-center mt-2 space-x-4">
                                    <span class="text-xs bg-gray-100 px-2 py-1 rounded">
                                        {{ ucfirst($item->coffee->roast_level) }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $item->coffee->origin }}</span>
                                </div>
                            </div>
                            
                            <!-- Quantity Controls -->
                            <div class="flex items-center space-x-2">
                                <form method="POST" action="{{ route('user.cart.update', $item->id) }}" class="flex items-center">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button type="button" onclick="decreaseQuantity({{ $item->id }})" 
                                                class="px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                                            <i class="fas fa-minus text-xs"></i>
                                        </button>
                                        <input type="number" name="quantity" id="quantity-{{ $item->id }}" 
                                               value="{{ $item->quantity }}" min="1" max="10" 
                                               class="w-16 text-center border-0 focus:ring-0 text-sm"
                                               onchange="updateQuantity({{ $item->id }})">
                                        <button type="button" onclick="increaseQuantity({{ $item->id }})" 
                                                class="px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                                            <i class="fas fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Price and Remove -->
                            <div class="text-right">
                                <p class="text-lg font-semibold text-gray-900">
                                    ₹{{ number_format($item->quantity * $item->coffee->price, 2) }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    ₹{{ number_format($item->coffee->price, 2) }} each
                                </p>
                                <form method="POST" action="{{ route('user.cart.remove', $item->id) }}" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 text-sm font-medium"
                                            onclick="return confirm('Remove this item from cart?')">
                                        <i class="fas fa-trash mr-1"></i>Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Continue Shopping -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <a href="{{ route('user.shop') }}" 
                           class="text-yellow-600 hover:text-yellow-800 font-medium">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-5 mt-8 lg:mt-0">
                <div class="coffee-card rounded-xl p-6 sticky top-24">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                            <span class="font-medium">₹{{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-medium">
                                @if($subtotal >= 50)
                                    <span class="text-green-600">Free</span>
                                @else
                                    $10.00
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-medium">₹{{ number_format($tax, 2) }}</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold text-gray-900">Total</span>
                                <span class="text-lg font-semibold text-gray-900">₹{{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Promo Code -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex space-x-2">
                            <input type="text" placeholder="Promo code" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            <button class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors">
                                Apply
                            </button>
                        </div>
                    </div>
                    
                    <!-- Checkout Button -->
                    <div class="mt-6">
                        <a href="{{ route('user.checkout') }}" 
                           class="w-full btn-coffee py-3 px-4 rounded-lg font-semibold text-lg text-center block">
                            <i class="fas fa-lock mr-2"></i>
                            Proceed to Checkout
                        </a>
                    </div>
                    
                    <!-- Payment Methods -->
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-500 mb-2">We accept</p>
                        <div class="flex justify-center space-x-2">
                            <i class="fab fa-cc-visa text-2xl text-blue-600"></i>
                            <i class="fab fa-cc-mastercard text-2xl text-red-600"></i>
                            <i class="fab fa-cc-amex text-2xl text-blue-500"></i>
                            <i class="fab fa-paypal text-2xl text-blue-700"></i>
                        </div>
                    </div>
                    
                    <!-- Free Shipping Banner -->
                    @if($subtotal < 50)
                    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-800">
                            <i class="fas fa-truck text-yellow-600 mr-1"></i>
                            Add ₹{{ number_format(50 - $subtotal, 2) }} more for free shipping!
                        </p>
                    </div>
                    @else
                    <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-sm text-green-800">
                            <i class="fas fa-check text-green-600 mr-1"></i>
                            You qualify for free shipping!
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="text-center py-16">
            <div class="max-w-md mx-auto">
                <div class="mb-8">
                    <i class="fas fa-shopping-cart text-8xl text-gray-300"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Your cart is empty</h2>
                <p class="text-gray-600 mb-8">
                    Looks like you haven't added any items to your cart yet. Start shopping to fill it up!
                </p>
                <a href="{{ route('user.shop') }}" 
                   class="btn-coffee px-8 py-3 rounded-lg font-semibold inline-block">
                    <i class="fas fa-store mr-2"></i>
                    Continue Shopping
                </a>
            </div>
            
            <!-- Suggestions -->
            <div class="mt-16">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">You might like these</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Add some featured products here -->
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg z-50" id="success-toast">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg z-50" id="error-toast">
        <i class="fas fa-exclamation-circle mr-2"></i>
        {{ session('error') }}
    </div>
@endif
@endsection

@push('scripts')
<script>
function increaseQuantity(itemId) {
    const input = document.getElementById(`quantity-${itemId}`);
    const current = parseInt(input.value);
    if (current < 10) {
        input.value = current + 1;
        updateQuantity(itemId);
    }
}

function decreaseQuantity(itemId) {
    const input = document.getElementById(`quantity-${itemId}`);
    const current = parseInt(input.value);
    if (current > 1) {
        input.value = current - 1;
        updateQuantity(itemId);
    }
}

function updateQuantity(itemId) {
    const form = document.getElementById(`quantity-${itemId}`).closest('form');
    form.submit();
}

// Auto-hide toast messages
setTimeout(() => {
    const successToast = document.getElementById('success-toast');
    const errorToast = document.getElementById('error-toast');
    if (successToast) successToast.remove();
    if (errorToast) errorToast.remove();
}, 5000);
</script>
@endpush