@extends('admin.layouts.app')

@section('title', 'Manage Coffees')
@section('header', 'Coffee Management')

@section('content')
<div class="space-y-6">
    <!-- Header with Add Button -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">All Coffees</h2>
            <p class="text-gray-600">Manage your coffee inventory</p>
        </div>
        <a href="{{ route('admin.coffees.create') }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Add New Coffee
        </a>
    </div>

    <!-- Search and Filter -->
    <!-- <div class="bg-white rounded-lg shadow p-6">
        <form method="GET" action="{{ route('admin.coffees.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search coffees..." 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-amber-500 focus:border-amber-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-amber-500 focus:border-amber-500">
                    <option value="">All Categories</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Stock Status</label>
                <select name="stock_status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-amber-500 focus:border-amber-500">
                    <option value="">All Items</option>
                    <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock (< 10)</option>
                    <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg mr-2">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.coffees.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg">
                    Clear
                </a>
            </div>
        </form>
    </div> -->

    <!-- Coffees Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coffee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Origin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th> -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($coffees ?? [] as $coffee)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($coffee->image_url)
                                        <img src="{{ asset('images/coffee_images/' . $coffee->image_url) }}" alt="{{ $coffee->name }}" class="h-12 w-12 rounded-lg object-cover mr-4">
                                    @else
                                        <div class="h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-coffee text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $coffee->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($coffee->description, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                    {{ $coffee->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $coffee->origin ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ₹{{ number_format($coffee->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full {{ $coffee->stock_quantity < 10 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $coffee->stock_quantity }} units
                                </span>
                            </td>
                            <!-- <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full {{ $coffee->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $coffee->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td> -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.coffees.show', $coffee) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.coffees.edit', $coffee) }}" class="text-amber-600 hover:text-amber-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.coffees.destroy', $coffee) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" 
                                            onclick="return confirm('Are you sure you want to delete this coffee?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-coffee text-4xl mb-4"></i>
                                    <p class="text-lg">No coffees found</p>
                                    <p class="text-sm">Start by adding your first coffee product</p>
                                    <a href="{{ route('admin.coffees.create') }}" class="mt-4 inline-block bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg">
                                        Add New Coffee
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(isset($coffees) && $coffees->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $coffees->links() }}
            </div>
        @endif
    </div>
</div>
@endsection