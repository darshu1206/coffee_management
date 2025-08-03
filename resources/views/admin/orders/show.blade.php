@extends('admin.layouts.app')

@section('title', 'Order Details')
@section('header', 'Order #' . $order->id . ' Details')

@section('content')
<div class="space-y-6">
    <!-- Order Header -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Order #{{ $order->id }}</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="px-3 py-1 text-sm rounded-full font-medium
                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                           ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                        {{ ucfirst($order->status) }}
                    </span>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Orders
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-amber-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-dollar-sign text-amber-600 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Amount</p>
                        <p class="text-2xl font-bold text-gray-900">₹{{ number_format($order->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-shopping-cart text-blue-600 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Items</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $order->orderItems->sum('quantity') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-credit-card text-green-600 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Payment Method</p>
                        <p class="text-lg font-bold text-gray-900">{{ ucfirst($order->payment_method ?? 'Not specified') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Items -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Order Items</h3>
            </div>
            <div class="p-6">
                @if($order->orderItems->count() > 0)
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    @if($item->coffee->image)
                                        <img src="{{ asset('storage/' . $item->coffee->image) }}" 
                                             alt="{{ $item->coffee->name }}" 
                                             class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-coffee text-gray-400 text-xl"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $item->coffee->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $item->coffee->category->name ?? 'No Category' }}</p>
                                        <p class="text-sm text-gray-500">₹{{ number_format($item->price, 2) }} each</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                    <p class="font-bold text-gray-900">₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Total Breakdown -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="text-gray-900">₹{{ number_format($order->orderItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold pt-2 border-t">
                                <span class="text-gray-900">Total:</span>
                                <span class="text-gray-900">₹{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No items in this order</p>
                @endif
            </div>
        </div>

        <!-- Order Information -->
        <div class="space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
                </div>
                <div class="p-6">
                    @if($order->customer)
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Name</p>
                                <p class="text-gray-900">{{ $order->customer->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Email</p>
                                <p class="text-gray-900">{{ $order->customer->email }}</p>
                            </div>
                            @if($order->customer->phone)
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Phone</p>
                                    <p class="text-gray-900">{{ $order->customer->phone }}</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-500">Guest Customer</p>
                    @endif
                </div>
            </div>

            <!-- Delivery Information -->
            @if($order->delivery_address)
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Delivery Address</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-900 whitespace-pre-line">{{ $order->delivery_address }}</p>
                    </div>
                </div>
            @endif

            <!-- Order Notes -->
            @if($order->notes)
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Order Notes</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-900 whitespace-pre-line">{{ $order->notes }}</p>
                    </div>
                </div>
            @endif

            <!-- Status Update -->
            @if($order->status !== 'completed' && $order->status !== 'cancelled')
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Update Status</h3>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                            @csrf
                            @method('PATCH')
                            <div class="space-y-4">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                        Current Status: <span class="font-bold">{{ ucfirst($order->status) }}</span>
                                    </label>
                                    <select id="status" 
                                            name="status" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                    <i class="fas fa-save mr-2"></i>Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Delete Order -->
            <div class="bg-white rounded-lg shadow border border-red-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-red-900">Danger Zone</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-4">
                        Deleting this order will permanently remove all order data. This action cannot be undone.
                    </p>
                    <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <i class="fas fa-trash mr-2"></i>Delete Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div id="success-alert" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('success-alert').style.display = 'none';
        }, 3000);
    </script>
@endif
@endsection