@extends('layouts.user-layout')

@section('title', 'Order History')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            <i class="fas fa-history text-yellow-600 mr-3"></i>
            Order History
        </h1>
        <p class="text-gray-600">Track and manage all your coffee orders</p>
    </div>

    @if($orders->count() > 0)
        <!-- Filter and Sort -->
        <div class="coffee-card rounded-xl p-4 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex items-center space-x-4">
                    <select class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option>All Orders</option>
                        <option>Pending</option>
                        <option>Processing</option>
                        <option>Shipped</option>
                        <option>Delivered</option>
                        <option>Cancelled</option>
                    </select>
                    
                    <select class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option>Last 30 days</option>
                        <option>Last 3 months</option>
                        <option>Last 6 months</option>
                        <option>Last year</option>
                        <option>All time</option>
                    </select>
                </div>
                
                <div class="flex items-center space-x-2">
                    <input type="text" placeholder="Search orders..." 
                           class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    <button class="btn-coffee px-4 py-2 rounded-lg">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="space-y-6">
            @foreach($orders as $order)
            <div class="coffee-card rounded-xl p-6 hover-lift">
                <!-- Order Header -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
                    <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                        <div class="p-3 bg-yellow-100 rounded-full">
                            <i class="fas fa-receipt text-yellow-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                Placed on {{ $order->created_at->format('M d, Y \a\t g:i A') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0">
                        <div class="text-right sm:text-left">
                            <p class="text-lg font-bold text-gray-900">₹{{ number_format($order->total_amount, 2) }}</p>
                            <p class="text-sm text-gray-500">{{ $order->orderItems->sum('quantity') }} item(s)</p>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : 
                                   ($order->status === 'shipped' ? 'bg-blue-100 text-blue-800' : 
                                   ($order->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($order->status === 'pending' ? 'bg-orange-100 text-orange-800' : 
                                   ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')))) }}">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                {{ ucfirst($order->status) }}
                            </span>
                            
                            <a href="{{ route('user.order.detail', $order->id) }}" 
                               class="text-yellow-600 hover:text-yellow-800 font-medium text-sm">
                                View Details <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Order Items Preview -->
                <div class="border-t border-gray-200 pt-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($order->orderItems->take(4) as $item)
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                @if($item->coffee->image_url)
                                    <img src="{{ asset('images/coffee_images/' . $item->coffee->image_url) }}" alt="{{ $item->coffee->name }}" 
                                         class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-coffee text-white"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $item->coffee->name }}</p>
                                <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                            </div>
                        </div>
                        @endforeach
                        
                        @if($order->orderItems->count() > 4)
                        <div class="flex items-center justify-center text-sm text-gray-500">
                            +{{ $order->orderItems->count() - 4 }} more items
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Order Actions -->
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            @if($order->status === 'delivered')
                                <div class="flex items-center">
                                    <i class="fas fa-truck text-green-500 mr-1"></i>
                                    Delivered on {{ $order->updated_at->format('M d, Y') }}
                                </div>
                            @elseif($order->status === 'shipped')
                                <div class="flex items-center">
                                    <i class="fas fa-shipping-fast text-blue-500 mr-1"></i>
                                    Shipped • Track your package
                                </div>
                            @elseif($order->status === 'processing')
                                <div class="flex items-center">
                                    <i class="fas fa-cog text-yellow-500 mr-1"></i>
                                    Being prepared for shipment
                                </div>
                            @else
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-orange-500 mr-1"></i>
                                    Order confirmed
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            @if($order->status == 'delivered')
                                <button class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg hover:bg-yellow-200 transition-colors text-sm font-medium">
                                    <i class="fas fa-star mr-1"></i>
                                    Review
                                </button>
                            @endif
                            
                            @if(in_array($order->status, ['pending', 'processing']))
                                <button class="px-4 py-2 bg-red-100 text-red-800 rounded-lg hover:bg-red-200 transition-colors text-sm font-medium"
                                        onclick="cancelOrder({{ $order->id }})">
                                    <i class="fas fa-times mr-1"></i>
                                    Cancel
                                </button>
                            @endif
                            
                            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium"
                                    onclick="reorder({{ $order->id }})">
                                <i class="fas fa-redo mr-1"></i>
                                Reorder
                            </button>
                            
                            @if($order->status === 'shipped')
                                <button class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg hover:bg-blue-200 transition-colors text-sm font-medium">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    Track
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $orders->links() }}
        </div>
        
    @else
        <!-- No Orders -->
        <div class="text-center py-16">
            <div class="max-w-md mx-auto">
                <div class="mb-8">
                    <i class="fas fa-shopping-bag text-8xl text-gray-300"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">No orders yet</h2>
                <p class="text-gray-600 mb-8">
                    You haven't placed any orders yet. Start shopping to see your order history here!
                </p>
                <a href="{{ route('user.shop') }}" 
                   class="btn-coffee px-8 py-3 rounded-lg font-semibold inline-block">
                    <i class="fas fa-store mr-2"></i>
                    Start Shopping
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Cancel Order Modal -->
<div id="cancel-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Cancel Order</h3>
            <p class="text-gray-600 mb-6">
                Are you sure you want to cancel this order? This action cannot be undone.
            </p>
            <div class="flex space-x-4">
                <button onclick="closeCancelModal()" 
                        class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                    Keep Order
                </button>
                <button onclick="confirmCancel()" 
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Cancel Order
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let orderToCancel = null;

function cancelOrder(orderId) {
    orderToCancel = orderId;
    document.getElementById('cancel-modal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancel-modal').classList.add('hidden');
    orderToCancel = null;
}

function confirmCancel() {
    if (orderToCancel) {
        // Make API call to cancel order
        fetch(`/orders/${orderToCancel}/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Order cancelled successfully', 'success');
                location.reload();
            } else {
                showToast('Failed to cancel order', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to cancel order', 'error');
        });
    }
    closeCancelModal();
}

function reorder(orderId) {
    // Add all items from this order to cart
    fetch(`/orders/${orderId}/reorder`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Items added to cart!', 'success');
            // Update cart count
            document.getElementById('cart-count').textContent = data.cart_count;
        } else {
            showToast('Failed to reorder', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to reorder', 'error');
    });
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

// Close modal when clicking outside
document.getElementById('cancel-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCancelModal();
    }
});
</script>
@endpush