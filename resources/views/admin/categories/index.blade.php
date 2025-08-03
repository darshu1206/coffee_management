@extends('admin.layouts.app')

@section('title', 'Manage Categories')
@section('header', 'Category Management')

@section('content')
<div class="space-y-6">
    <!-- Header with Add Button -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">All Categories</h2>
            <p class="text-gray-600">Organize your coffee products into categories</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="mt-4 inline-block bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-plus mr-2"></i>
            Add New Category
        </a>
    </div>

    <!-- Search and Filter -->
    <!-- <div class="bg-white rounded-lg shadow p-6">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..." 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Categories</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg mr-2">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg">
                    Clear
                </a>
            </div>
        </form>
    </div> -->

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories ?? [] as $category)
            <div class="bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                <!-- Category Image -->
                <div class="h-48 bg-gradient-to-br from-blue-100 to-blue-200 rounded-t-lg flex items-center justify-center">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" 
                             class="h-full w-full object-cover rounded-t-lg">
                    @else
                        <i class="fas fa-tag text-4xl text-blue-400"></i>
                    @endif
                </div>
                
                <!-- Category Info -->
                <div class="p-6">
                    <!-- <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                        <span class="px-2 py-1 text-xs rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div> -->
                    
                    @if($category->description)
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $category->description }}</p>
                    @endif
                    
                    <!-- Stats -->
                    <div class="flex justify-between items-center mb-4 text-sm text-gray-500">
                        <span>{{ $category->coffees_count ?? 0 }} coffees</span>
                        <span>Created {{ $category->created_at->format('M d, Y') }}</span>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.categories.show', $category) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-amber-600 hover:text-amber-900 text-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm" 
                                        onclick="return confirm('Are you sure? This will also affect all coffees in this category.')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        <a href="{{ route('admin.categories.show', $category) }}" class="bg-amber-600 hover:bg-amber-700 text-white px-3 py-1 rounded text-sm">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <i class="fas fa-tags text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No categories found</h3>
                    <p class="text-gray-600 mb-6">Start organizing your coffee products by creating categories</p>
                    <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                        <i class="fas fa-plus mr-2"></i>
                        Create First Category
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(isset($categories) && $categories->hasPages())
        <div class="bg-white rounded-lg shadow p-6">
            {{ $categories->links() }}
        </div>
    @endif

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $stats['total_categories'] ?? 0 }}</div>
            <div class="text-sm text-gray-500">Total Categories</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $stats['active_categories'] ?? 0 }}</div>
            <div class="text-sm text-gray-500">Active Categories</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <div class="text-2xl font-bold text-amber-600">{{ $stats['categories_with_products'] ?? 0 }}</div>
            <div class="text-sm text-gray-500">With Products</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <div class="text-2xl font-bold text-gray-600">{{ $stats['empty_categories'] ?? 0 }}</div>
            <div class="text-sm text-gray-500">Empty Categories</div>
        </div>
    </div>
</div>
@endsection