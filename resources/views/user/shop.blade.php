@extends('layouts.user-layout')

@section('title', 'Shop')

@section('content')
<!-- Shop Header -->
<div class="coffee-gradient py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                <i class="fas fa-store text-yellow-300 mr-3"></i>
                Coffee Shop
            </h1>
            <p class="text-xl text-gray-200">Discover your perfect cup from our premium collection</p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Filters Sidebar -->
        <div class="lg:w-1/4">
            <div class="coffee-card rounded-xl p-6 sticky top-24">
                <h2 class="text-xl font-bold text-gray-900 mb-6">
                    <i class="fas fa-filter text-yellow-600 mr-2"></i>
                    Filters
                </h2>
                
                <form method="GET" action="{{ route('user.shop') }}">
                    <!-- Search -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search coffee..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Roast Level Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Roast Level</label>
                        <select name="roast_level" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            <option value="">All Roast Levels</option>
                            @foreach($roastLevels as $roastLevel)
                                <option value="{{ $roastLevel }}" {{ request('roast_level') == $roastLevel ? 'selected' : '' }}>
                                    {{ ucfirst($roastLevel) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Origin Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Origin</label>
                        <select name="origin" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            <option value="">All Origins</option>
                            @foreach($origins as $origin)
                                <option value="{{ $origin }}" {{ request('origin') == $origin ? 'selected' : '' }}>
                                    {{ $origin }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Sort By -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <select name="sort" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A to Z</option>
                        </select>
                    </div>
                    
                    <div class="space-y-3">
                        <button type="submit" class="w-full btn-coffee py-2 px-4 rounded-lg font-medium">
                            <i class="fas fa-search mr-2"></i>
                            Apply Filters
                        </button>
                        <a href="{{ route('user.shop') }}" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-lg font-medium text-center block transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Clear Filters
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="lg:w-3/4">
            <!-- Results Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        Coffee Products
                        <span class="text-sm font-normal text-gray-600 ml-2">
                            ({{ $coffees->total() }} {{ Str::plural('result', $coffees->total()) }})
                        </span>
                    </h2>
                </div>
                
                <!-- View Toggle -->
                <div class="hidden sm:flex items-center space-x-2">
                    <button id="grid-view" class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button id="list-view" class="p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>
            
            @if($coffees->count() > 0)
                <!-- Products Grid -->
                <div id="products-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($coffees as $coffee)
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
                                <span class="bg-white text-gray-900 px-2 py-1 rounded-full text-sm font-bold shadow-lg">
                                    ₹{{ number_format($coffee->price, 2) }}
                                </span>
                            </div>
                            
                            @if($coffee->stock_quantity < 10)
                                <div class="absolute top-3 left-3">
                                    <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                        Low Stock
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 mb-2">{{ $coffee->name }}</h3>
                            <p class="text-sm text-gray-600 mb-3">{{ Str::limit($coffee->description, 80) }}</p>
                            
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs bg-gray-100 px-2 py-1 rounded">
                                    {{ ucfirst($coffee->roast_level) }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $coffee->origin }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs text-gray-500">
                                    <i class="fas fa-box mr-1"></i>
                                    {{ $coffee->stock_quantity }} in stock
                                </span>
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    @endfor
                                    <span class="text-xs text-gray-500 ml-1">(4.8)</span>
                                </div>
                            </div>
                            
                            <div class="flex space-x-2">
                                <a href="{{ route('user.product.detail', $coffee->id) }}" 
                                   class="flex-1 btn-coffee py-2 px-3 text-center rounded-lg text-sm font-medium">
                                    View Details
                                </a>
                                @auth
                                    @if($coffee->stock_quantity > 0)
                                        <button onclick="addToCart({{ $coffee->id }}, 1)" 
                                                class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-lg transition-colors">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    @else
                                        <button disabled class="bg-gray-100 text-gray-400 px-3 py-2 rounded-lg cursor-not-allowed">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" 
                                       class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-lg transition-colors">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $coffees->appends(request()->query())->links() }}
                </div>
            @else
                <!-- No Results -->
                <div class="text-center py-12">
                    <div class="max-w-md mx-auto">
                        <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Products Found</h3>
                        <p class="text-gray-600 mb-6">
                            We couldn't find any products matching your criteria. Try adjusting your filters or search terms.
                        </p>
                        <a href="{{ route('user.shop') }}" 
                           class="btn-coffee px-6 py-3 rounded-lg font-medium inline-block">
                            <i class="fas fa-redo mr-2"></i>
                            Reset Filters
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /**
     * addToCart helper
     * Call addToCart(coffeeId, qty) from product pages/buttons.
     * Updates badge on success.
     */
    function addToCart(coffeeId, qty = 1) {
        const badge = document.getElementById('cart-count');
        console.log('Adding to cart:', coffeeId, qty);
        console.log('Cart badge element:', badge);
        fetch("{{ route('user.cart.add') }}", {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ coffee_id: coffeeId, quantity: qty })
        })
        .then(res => res.ok ? res.json() : res.json().then(e => Promise.reject(e)))
        .then(data => {
            console.log('Add to cart response:', data);
            if (data && data.cart_count !== undefined) {
                const count = Number(data.cart_count) || 0;
                console.log('Cart count updated:', count);
                if (badge) {
                    badge.textContent = count;
                    badge.style.display = count > 0 ? 'flex' : 'none';
                }
            }
            // Optional: show a toast/snackbar using your UI method
        })
        .catch(err => {
            console.error('Add to cart failed:', err);
            // Optional: show error message to user
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

// View toggle functionality
document.getElementById('grid-view').addEventListener('click', function() {
    document.getElementById('products-grid').className = 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8';
    this.className = 'p-2 bg-yellow-100 text-yellow-600 rounded-lg';
    document.getElementById('list-view').className = 'p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200';
});

document.getElementById('list-view').addEventListener('click', function() {
    document.getElementById('products-grid').className = 'grid grid-cols-1 gap-6 mb-8';
    this.className = 'p-2 bg-yellow-100 text-yellow-600 rounded-lg';
    document.getElementById('grid-view').className = 'p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200';
});
</script>
@endpush