@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-amber-100 rounded-lg">
                    <i class="fas fa-coffee text-amber-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Coffees</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_coffees'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">₹{{ number_format($stats['total_revenue'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending Orders</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Low Stock Items</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['low_stock_items'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <i class="fas fa-tags text-indigo-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Categories</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
                </div>
            </div>
        </div>

        <!-- <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-teal-100 rounded-lg">
                    <i class="fas fa-truck text-teal-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Suppliers</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_suppliers'] }}</p>
                </div>
            </div>
        </div> -->
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Orders</h3>
            </div>
            <div class="p-6">
                @if($recentOrders->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentOrders as $order)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">Order #{{ $order->id }}</p>
                                    <p class="text-sm text-gray-600">{{ $order->customer->name ?? 'Guest' }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">₹{{ number_format($order->total_amount, 2) }}</p>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.orders.index') }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium">
                            View all orders <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No recent orders</p>
                @endif
            </div>
        </div>

        <!-- Low Stock Items -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Low Stock Alert</h3>
            </div>
            <div class="p-6">
                @if($lowStockItems->count() > 0)
                    <div class="space-y-4">
                        @foreach($lowStockItems as $coffee)
                            <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $coffee->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $coffee->category->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-red-600">{{ $coffee->stock_quantity }} left</p>
                                    <p class="text-sm text-gray-500">₹{{ number_format($coffee->price, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.coffees.index') }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium">
                            Manage inventory <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">All items are well stocked</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Top Selling Coffees -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Top Selling Coffees (Last 30 Days)</h3>
        </div>
        <div class="p-6">
            @if($topSellingCoffees->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($topSellingCoffees as $coffee)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-gray-900">{{ $coffee->name }}</h4>
                                <span class="text-sm font-bold text-amber-600">{{ $coffee->total_sold }} sold</span>
                            </div>
                            <p class="text-sm text-gray-600">{{ $coffee->category->name }}</p>
                            <p class="text-sm text-gray-500">₹{{ number_format($coffee->price, 2) }}</p>
                            <div class="mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-amber-600 h-2 rounded-full" style="width: {{ ($coffee->total_sold / $topSellingCoffees->max('total_sold')) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No sales data available</p>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.coffees.create') }}" class="flex items-center p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
                    <i class="fas fa-plus-circle text-amber-600 text-xl mr-3"></i>
                    <span class="font-medium text-gray-900">Add New Coffee</span>
                </a>
                
                <a href="{{ route('admin.categories.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <i class="fas fa-tag text-blue-600 text-xl mr-3"></i>
                    <span class="font-medium text-gray-900">Add Category</span>
                </a>
                
                <!-- <a href="{{ route('admin.suppliers.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <i class="fas fa-truck text-green-600 text-xl mr-3"></i>
                    <span class="font-medium text-gray-900">Add Supplier</span>
                </a> -->
                
                <a href="{{ route('admin.orders.index') }}?status=pending" class="flex items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <i class="fas fa-clock text-orange-600 text-xl mr-3"></i>
                    <span class="font-medium text-gray-900">Pending Orders</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection