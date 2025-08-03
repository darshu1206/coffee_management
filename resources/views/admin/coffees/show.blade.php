@extends('admin.layouts.app')

@section('title', 'Coffee Details')
@section('header', 'Coffee Details')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header with Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $coffee->name }}</h3>
                <p class="text-gray-600 mt-1">Coffee product details and information</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.coffees.edit', $coffee) }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg text-sm">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Coffee
                </a>
                <a href="{{ route('admin.coffees.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Coffee Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900">Coffee Information</h4>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $coffee->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Category</label>
                            <span class="inline-flex px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                                {{ $coffee->category->name ?? 'N/A' }}
                            </span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Price</label>
                            <p class="text-2xl font-bold text-green-600">₹{{ number_format($coffee->price, 2) }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Stock Quantity</label>
                            <div class="flex items-center">
                                <span class="text-lg font-semibold {{ $coffee->stock_quantity < 10 ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $coffee->stock_quantity }} units
                                </span>
                                @if($coffee->stock_quantity < 10)
                                    <span class="ml-2 px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                        Low Stock
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        @if($coffee->roast_level)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Roast Level</label>
                            <p class="text-gray-900 capitalize">{{ $coffee->roast_level }}</p>
                        </div>
                        @endif
                        
                        @if($coffee->origin)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Origin</label>
                            <p class="text-gray-900">{{ $coffee->origin }}</p>
                        </div>
                        @endif
                        
                        @if($coffee->supplier)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Supplier</label>
                            <p class="text-gray-900">{{ $coffee->supplier->name }}</p>
                        </div>
                        @endif
                        
                        <!-- <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            <span class="inline-flex px-3 py-1 text-sm rounded-full {{ $coffee->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $coffee->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if($coffee->is_featured)
                                <span class="ml-2 inline-flex px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">
                                    Featured
                                </span>
                            @endif
                        </div> -->
                    </div>
                    
                    @if($coffee->description)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Description</label>
                        <p class="text-gray-700 leading-relaxed">{{ $coffee->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sales Performance -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900">Sales Performance</h4>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $salesStats['total_sold'] ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Total Units Sold</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">₹{{ number_format($salesStats['total_revenue'] ?? 0, 2) }}</div>
                            <div class="text-sm text-gray-500">Total Revenue</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ $salesStats['orders_count'] ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Number of Orders</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Product Image -->
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Product Image</h4>
                @if($coffee->image)
                    <img src="{{ asset('storage/' . $coffee->image) }}" alt="{{ $coffee->name }}" 
                         class="w-full h-64 object-cover rounded-lg">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-coffee text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-500">No image available</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h4>
                <div class="space-y-3">
                    <a href="{{ route('admin.coffees.edit', $coffee) }}" 
                       class="w-full bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg text-center block">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Coffee
                    </a>
                    
                    <!-- @if($coffee->is_active)
                        <form action="{{ route('admin.coffees.update', $coffee) }}" method="POST" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_active" value="0">
                            <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                                <i class="fas fa-pause mr-2"></i>
                                Deactivate
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.coffees.update', $coffee) }}" method="POST" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_active" value="1">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                                <i class="fas fa-play mr-2"></i>
                                Activate
                            </button>
                        </form>
                    @endif -->
                    
                    <form action="{{ route('admin.coffees.destroy', $coffee) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this coffee? This action cannot be undone.')" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Coffee
                        </button>
                    </form>
                </div>
            </div>

            <!-- Product Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h4>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Created</span>
                        <span class="text-sm text-gray-900">{{ $coffee->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Last Updated</span>
                        <span class="text-sm text-gray-900">{{ $coffee->updated_at->format('M d, Y') }}</span>
                    </div>
                    <!-- <div class="flex justify-between">
                        <span class="text-sm text-gray-500">SKU</span>
                        <span class="text-sm text-gray-900">{{ $coffee->sku ?? 'N/A' }}</span>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection