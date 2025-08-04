@extends('admin.layouts.app')

@section('title', 'Edit Coffee')
@section('header', 'Edit Coffee')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Edit Coffee</h3>
                    <p class="text-sm text-gray-600 mt-1">Update coffee product details</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.coffees.show', $coffee) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                        <i class="fas fa-eye mr-2"></i>
                        View
                    </a>
                    <a href="{{ route('admin.coffees.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back
                    </a>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.coffees.update', $coffee) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div>
                        <h4 class="text-md font-medium text-gray-900 mb-4">Basic Information</h4>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Coffee Name *</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $coffee->name) }}" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-amber-500 focus:border-amber-500 @error('name') border-red-500 @enderror"
                                       placeholder="Enter coffee name">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea id="description" name="description" rows="4"
                                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-amber-500 focus:border-amber-500 @error('description') border-red-500 @enderror"
                                          placeholder="Describe your coffee...">{{ old('description', $coffee->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                                <select id="category_id" name="category_id" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-amber-500 focus:border-amber-500 @error('category_id') border-red-500 @enderror">
                                    <option value="">Select a category</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $coffee->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-2">Supplier</label>
                                <select id="supplier_id" name="supplier_id"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-amber-500 focus:border-amber-500 @error('supplier_id') border-red-500 @enderror">
                                    <option value="">Select a supplier</option>
                                    @foreach($suppliers ?? [] as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $coffee->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pricing and Stock -->
                    <div>
                        <h4 class="text-md font-medium text-gray-900 mb-4">Pricing & Stock</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (₹) *</label>
                                <input type="number" id="price" name="price" value="{{ old('price', $coffee->price) }}" required step="0.01" min="0"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-amber-500 focus:border-amber-500 @error('price') border-red-500 @enderror"
                                       placeholder="0.00">
                                @error('price')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity *</label>
                                <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $coffee->stock_quantity) }}" required min="0"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-amber-500 focus:border-amber-500 @error('stock_quantity') border-red-500 @enderror"
                                       placeholder="0">
                                @error('stock_quantity')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Image Upload -->
                    <div>
                        <h4 class="text-md font-medium text-gray-900 mb-4">Product Image</h4>
                        
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-amber-400 transition-colors">
                            <div id="image-preview" class="{{ $coffee->image_url ? '' : 'hidden' }} mb-4">
                                <img id="preview-img" src="{{ $coffee->image_url ? asset('images/coffee_images/' . $coffee->image_url) : '' }}" alt="Preview" class="mx-auto h-32 w-32 object-cover rounded-lg">
                            </div>
                            
                            <div id="upload-placeholder" class="{{ $coffee->image_url ? 'hidden' : '' }}">
                                <i class="fas fa-image text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-600 mb-2">Upload product image</p>
                                <p class="text-sm text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                            
                            <input type="file" id="image" name="image" accept="image/*" class="hidden">
                            <button type="button" onclick="document.getElementById('image').click()" 
                                    class="mt-4 bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg text-sm">
                                {{ $coffee->image ? 'Change Image' : 'Choose Image' }}
                            </button>
                            
                            @if($coffee->image_url)
                                <div class="mt-2">
                                    <label class="flex items-center justify-center">
                                        <input type="checkbox" name="remove_image" value="1" class="mr-2">
                                        <span class="text-sm text-red-600">Remove current image</span>
                                    </label>
                                </div>
                            @endif
                        </div>
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Additional Details -->
                    <div>
                        <h4 class="text-md font-medium text-gray-900 mb-4">Additional Details</h4>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="roast_level" class="block text-sm font-medium text-gray-700 mb-2">Roast Level</label>
                                <select id="roast_level" name="roast_level"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-amber-500 focus:border-amber-500">
                                    <option value="">Select roast level</option>
                                    <option value="light" {{ old('roast_level', $coffee->roast_level) == 'light' ? 'selected' : '' }}>Light</option>
                                    <option value="medium" {{ old('roast_level', $coffee->roast_level) == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="medium-dark" {{ old('roast_level', $coffee->roast_level) == 'medium-dark' ? 'selected' : '' }}>Medium Dark</option>
                                    <option value="dark" {{ old('roast_level', $coffee->roast_level) == 'dark' ? 'selected' : '' }}>Dark</option>
                                </select>
                            </div>

                            <div>
                                <label for="origin" class="block text-sm font-medium text-gray-700 mb-2">Origin</label>
                                <input type="text" id="origin" name="origin" value="{{ old('origin', $coffee->origin) }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-amber-500 focus:border-amber-500"
                                       placeholder="e.g., Colombia, Ethiopia">
                            </div>

                            <!-- <div class="flex items-center">
                                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $coffee->is_active) ? 'checked' : '' }}
                                       class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                    Active (available for purchase)
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $coffee->is_featured) ? 'checked' : '' }}
                                       class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                                <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                    Featured product
                                </label>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.coffees.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-2 rounded-lg">
                    <i class="fas fa-save mr-2"></i>
                    Update Coffee
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection