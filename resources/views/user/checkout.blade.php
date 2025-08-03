@extends('layouts.user-layout')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            <i class="fas fa-credit-card text-yellow-600 mr-3"></i>
            Checkout
        </h1>
        <p class="text-gray-600">Complete your order</p>
    </div>

    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex items-center">
            <div class="flex items-center text-sm">
                <div class="flex items-center text-yellow-600">
                    <div class="w-8 h-8 bg-yellow-600 rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-shopping-cart text-xs"></i>
                    </div>
                    <span class="ml-2 font-medium">Cart</span>
                </div>
                <div class="w-16 h-0.5 bg-yellow-600 mx-4"></div>
                <div class="flex items-center text-yellow-600">
                    <div class="w-8 h-8 bg-yellow-600 rounded-full flex items-center justify-center text-white">
                        <span class="text-xs">2</span>
                    </div>
                    <span class="ml-2 font-medium">Checkout</span>
                </div>
                <div class="w-16 h-0.5 bg-gray-300 mx-4"></div>
                <div class="flex items-center text-gray-400">
                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-xs"></i>
                    </div>
                    <span class="ml-2">Complete</span>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('user.checkout.process') }}">
        @csrf
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">
            <!-- Checkout Form -->
            <div class="lg:col-span-7">
                <!-- Billing Information -->
                <div class="coffee-card rounded-xl p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">
                        <i class="fas fa-user text-blue-500 mr-2"></i>
                        Billing Information
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', Auth::user()->name) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="coffee-card rounded-xl p-6 mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">
                            <i class="fas fa-truck text-green-500 mr-2"></i>
                            Shipping Address
                        </h2>
                        <label class="flex items-center">
                            <input type="checkbox" id="same-as-billing" class="mr-2">
                            <span class="text-sm text-gray-600">Same as billing</span>
                        </label>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 1</label>
                            <input type="text" name="address_line_1" value="{{ old('address_line_1') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 2 (Optional)</label>
                            <input type="text" name="address_line_2" value="{{ old('address_line_2') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                            <input type="text" name="city" value="{{ old('city') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">State/Province</label>
                            <input type="text" name="state" value="{{ old('state') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">ZIP/Postal Code</label>
                            <input type="text" name="zip_code" value="{{ old('zip_code') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                            <select name="country" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                                <option value="">Select Country</option>
                                <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United States</option>
                                <option value="CA" {{ old('country') == 'CA' ? 'selected' : '' }}>Canada</option>
                                <option value="GB" {{ old('country') == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                <option value="AU" {{ old('country') == 'AU' ? 'selected' : '' }}>Australia</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="coffee-card rounded-xl p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">
                        <i class="fas fa-credit-card text-purple-500 mr-2"></i>
                        Payment Method
                    </h2>
                    
                    <div class="space-y-4 mb-6">
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="credit_card" checked class="mr-3">
                            <div class="flex items-center">
                                <i class="fas fa-credit-card text-blue-600 mr-3"></i>
                                <span class="font-medium">Credit/Debit Card</span>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="paypal" class="mr-3">
                            <div class="flex items-center">
                                <i class="fab fa-paypal text-blue-700 mr-3"></i>
                                <span class="font-medium">PayPal</span>
                            </div>
                        </label>
                    </div>
                    
                    <!-- Credit Card Details -->
                    <div id="credit-card-details">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
                                <input type="text" name="card_number" placeholder="1234 5678 9012 3456" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                                <input type="text" name="expiry_date" placeholder="MM/YY" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">CVV</label>
                                <input type="text" name="cvv" placeholder="123" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cardholder Name</label>
                                <input type="text" name="cardholder_name" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="coffee-card rounded-xl p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">
                        <i class="fas fa-sticky-note text-orange-500 mr-2"></i>
                        Order Notes (Optional)
                    </h2>
                    <textarea name="order_notes" rows="3" 
                              placeholder="Any special instructions for your order..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"></textarea>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-5 mt-8 lg:mt-0">
                <div class="coffee-card rounded-xl p-6 sticky top-24">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
                    
                    <!-- Cart Items -->
                    <div class="space-y-4 mb-6 max-h-60 overflow-y-auto">
                        @foreach($cartItems as $item)
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                @if($item->coffee->image_url)
                                    <img src="{{ $item->coffee->image_url }}" alt="{{ $item->coffee->name }}" 
                                         class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-coffee text-white"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $item->coffee->name }}</p>
                                <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-sm font-medium text-gray-900">
                                ₹{{ number_format($item->quantity * $item->coffee->price, 2) }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pricing Breakdown -->
                    <div class="border-t border-gray-200 pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">₹{{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-medium">
                                @if($shipping == 0)
                                    <span class="text-green-600">Free</span>
                                @else
                                    ₹{{ number_format($shipping, 2) }}
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-medium">₹{{ number_format($tax, 2) }}</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-2">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold text-gray-900">Total</span>
                                <span class="text-lg font-semibold text-gray-900">₹{{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Place Order Button -->
                    <div class="mt-6">
                        <button type="submit" 
                                class="w-full btn-coffee py-3 px-4 rounded-lg font-semibold text-lg">
                            <i class="fas fa-lock mr-2"></i>
                            Place Order
                        </button>
                    </div>
                    
                    <!-- Security Info -->
                    <div class="mt-4 text-center">
                        <div class="flex items-center justify-center text-sm text-gray-500">
                            <i class="fas fa-shield-alt mr-2"></i>
                            <span>Secure SSL encryption</span>
                        </div>
                        <div class="flex justify-center space-x-2 mt-2">
                            <i class="fab fa-cc-visa text-2xl text-blue-600"></i>
                            <i class="fab fa-cc-mastercard text-2xl text-red-600"></i>
                            <i class="fab fa-cc-amex text-2xl text-blue-500"></i>
                            <i class="fab fa-paypal text-2xl text-blue-700"></i>
                        </div>
                    </div>
                    
                    <!-- Terms -->
                    <div class="mt-4">
                        <label class="flex items-start">
                            <input type="checkbox" name="agree_terms" required class="mt-1 mr-2">
                            <span class="text-xs text-gray-600">
                                I agree to the <a href="#" class="text-yellow-600 hover:text-yellow-800">Terms & Conditions</a> 
                                and <a href="#" class="text-yellow-600 hover:text-yellow-800">Privacy Policy</a>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Same as billing checkbox
document.getElementById('same-as-billing').addEventListener('change', function() {
    const billingInputs = ['first_name', 'last_name', 'email', 'phone'];
    const shippingInputs = ['address_line_1', 'address_line_2', 'city', 'state', 'zip_code', 'country'];
    
    if (this.checked) {
        // Copy billing info to shipping (you'd implement this logic)
        console.log('Copy billing to shipping');
    }
});

// Payment method toggle
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const creditCardDetails = document.getElementById('credit-card-details');
        if (this.value === 'credit_card') {
            creditCardDetails.style.display = 'block';
        } else {
            creditCardDetails.style.display = 'none';
        }
    });
});

// Card number formatting
document.querySelector('input[name="card_number"]')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
    e.target.value = formattedValue;
});

// Expiry date formatting
document.querySelector('input[name="expiry_date"]')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    e.target.value = value;
});
</script>
@endpush