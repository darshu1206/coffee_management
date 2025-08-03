@extends('layouts.app')

@section('title', 'Order #' . $order->id . ' - Coffee Shop')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('user.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-amber-600">
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('user.order.history') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-amber-600 md:ml-2">Orders</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Order #{{ $order->id }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Header -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Order #{{ $order->id }}</h1>
                        <p class="text-gray-600">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status == 'completed') bg-green-100 text-green-800
                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <!-- Order Status Timeline -->
                <div class="mt-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="ml-2 text-sm font-medium text-green-600">Order Placed</span>
                        </div>
                        
                        <div class="flex-1 h-px bg-gray-300"></div>
                        
                        <div class="flex items-center">
                            <div class="w-8 h-8 {{ in_array($order->status, ['processing', 'completed']) ? 'bg-blue-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="ml-2 text-sm font-medium {{ in_array($order->status, ['processing', 'completed']) ? 'text-blue-600' : 'text-gray-400' }}">Processing</span>
                        </div>
                        
                        <div class="flex-1 h-px bg-gray-300"></div>
                        
                        <div class="flex items-center">
                            <div class="w-8 h-8 {{ $order->status == 'completed' ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="ml-2 text-sm font-medium {{ $order->status == 'completed' ? 'text-green-600' : 'text-gray-400' }}">Completed</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h2>
                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                    <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                        @if($item->coffee->image_url)
                        <img src="{{ $item->coffee->image_url }}" alt="{{ $item->coffee->name }}" class="w-20 h-20 object-cover rounded">
                        @else
                        <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                            <span class="text-gray-400 text-xs">No Image</span>
                        </div>
                        @endif
                        
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $item->coffee->name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $item->coffee->description }}</p>
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                <span>{{ ucfirst($item->coffee->roast_level) }} Roast</span>
                                <span>•</span>
                                <span>{{ $item->coffee->origin }}</span>
                            </div>
                        </div>
                        
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">₹{{ number_format($item->price, 2) }}</p>
                            <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                            <p class="text-sm font-medium text-amber-600">₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="space-y-6">
            <!-- Order Summary Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal ({{ $order->orderItems->sum('quantity') }} items)</span>
                        <span class="text-gray-900">₹{{ number_format($order->orderItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping</span>
                        <span class="text-gray-900">$0.00</span>
                    </div>
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax</span>
                        <span class="text-gray-900">$0.00</span>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-amber-600">₹{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h2>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Name</p>
                        <p class="text-sm text-gray-900">{{ $order->customer->name }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm font-medium text-gray-600">Email</p>
                        <p class="text-sm text-gray-900">{{ $order->customer->email }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm font-medium text-gray-600">Order Date</p>
                        <p class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions</h2>
                
                <div class="space-y-3">
                    @if($order->status == 'completed')
                    <button class="w-full bg-amber-600 text-white py-2 px-4 rounded hover:bg-amber-700 transition duration-300">
                        Reorder Items
                    </button>
                    @endif
                    
                    @if($order->status == 'pending')
                    <button class="w-full bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 transition duration-300">
                        Cancel Order
                    </button>
                    @endif
                    
                    <button class="w-full bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-700 transition duration-300">
                        Download Invoice
                    </button>
                    
                    <a href="{{ route('user.order.history') }}" class="w-full bg-gray-300 text-gray-700 py-2 px-4 rounded hover:bg-gray-400 transition duration-300 block text-center">
                        Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection