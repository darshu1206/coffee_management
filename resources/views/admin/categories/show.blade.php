@extends('admin.layouts.app')

@section('title', 'Category Details')
@section('header', 'Category Details')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header with Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h3>
                <p class="text-gray-600 mt-1">Category details and associated products</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.categories.edit', $category) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Category
                </a>
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Category Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900">Category Information</h4>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $category->name }}</p>
                        </div>
                        
                        <!-- <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Slug</label>
                            <p class="text-gray-900 font-mono text-sm bg-gray-100 px-2 py-1 rounded">{{ $category->slug }}</p>
                        </div> -->
                        
                        <!-- <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex px-3 py-1 text-sm rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if($category->is_featured)
                                    <span class="inline-flex px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">
                                        Featured
                                    </span>
                                @endif
                            </div>
                        </div> -->
                        
                        <!-- <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Sort Order</label>
                            <p class="text-gray-900">{{ $category->sort_order ?? 'Not set' }}</p>
                        </div> -->
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Total Products</label>
                            <p class="text-2xl font-bold text-blue-600">{{ $category->coffees_count ?? 0 }}</p>
                        </div>
                        
                        <!-- <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Active Products</label>
                            <p class="text-lg font-semibold text-green-600">{{ $activeProductsCount ?? 0 }}</p>
                        </div> -->
                    </div>
                    
                    @if($category->description)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Description</label>
                        <p class="text-gray-700 leading-relaxed">{{ $category->description }}</p>
                    </div>
                    @endif

                    @if($category->meta_title || $category->meta_description)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-500 mb-2">SEO Information</label>
                        <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                            @if($category->meta_title)
                                <div>
                                    <span class="text-xs font-medium text-gray-500">Meta Title:</span>
                                    <p class="text-sm text-gray-700">{{ $category->meta_title }}</p>
                                </div>
                            @endif
                            @if($category->meta_description)
                                <div>
                                    <span class="text-xs font-medium text-gray-500">Meta Description:</span>
                                    <p class="text-sm text-gray-700">{{ $category->meta_description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Category Products -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-medium text-gray-900">Products in this Category</h4>
                        <a href="{{ route('admin.coffees.create') }}?category={{ $category->id }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg text-sm">
                            <i class="fas fa-plus mr-2"></i>
                            Add Product
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($category->coffees && $category->coffees->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($category->coffees as $coffee)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-center space-x-4">
                                        @if($coffee->image)
                                            <img src="{{ asset('storage/' . $coffee->image) }}" alt="{{ $coffee->name }}" class="h-16 w-16 rounded-lg object-cover">
                                        @else
                                            <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-coffee text-gray-400"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="flex-1">
                                            <h5 class="font-medium text-gray-900">{{ $coffee->name }}</h5>
                                            <p class="text-sm text-gray-600">${{ number_format($coffee->price, 2) }}</p>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="px-2 py-1 text-xs rounded-full {{ $coffee->stock_quantity < 10 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ $coffee->stock_quantity }} in stock
                                                </span>
                                                <span class="px-2 py-1 text-xs rounded-full {{ $coffee->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ $coffee->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex flex-col space-y-2">
                                            <a href="{{ route('admin.coffees.show', $coffee) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.coffees.edit', $coffee) }}" class="text-amber-600 hover:text-amber-900 text-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4 text-center">
                            <a href="{{ route('admin.coffees.index') }}?category={{ $category->id }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View all products in this category <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-coffee text-4xl text-gray-400 mb-4"></i>
                            <h5 class="text-lg font-medium text-gray-900 mb-2">No products yet</h5>
                            <p class="text-gray-600 mb-4">Start adding coffee products to this category</p>
                            <a href="{{ route('admin.coffees.create') }}?category={{ $category->id }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg">
                                <i class="fas fa-plus mr-2"></i>
                                Add First Product
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Category Image -->
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Category Image</h4>
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" 
                         class="w-full h-48 object-cover rounded-lg">
                @else
                    <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-500">No image uploaded</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h4>
                <div class="space-y-3">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-center block">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Category
                    </a>
                    
                    <a href="{{ route('admin.coffees.create') }}?category={{ $category->id }}" 
                       class="w-full bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg text-center block">
                        <i class="fas fa-plus mr-2"></i>
                        Add Product
                    </a>
                    
                    <!-- @if($category->is_active)
                        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_active" value="0">
                            <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                                <i class="fas fa-pause mr-2"></i>
                                Deactivate
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_active" value="1">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                                <i class="fas fa-play mr-2"></i>
                                Activate
                            </button>
                        </form>
                    @endif -->
                    
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this category? This will also affect all products in this category.')" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Category
                        </button>
                    </form>
                </div>
            </div>

            <!-- Category Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Category Details</h4>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Created</span>
                        <span class="text-sm text-gray-900">{{ $category->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Last Updated</span>
                        <span class="text-sm text-gray-900">{{ $category->updated_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">ID</span>
                        <span class="text-sm text-gray-900">#{{ $category->id }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection