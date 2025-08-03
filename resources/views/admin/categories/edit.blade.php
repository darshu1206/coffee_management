@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('header', 'Edit Category')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Edit Category</h3>
                    <p class="text-sm text-gray-600 mt-1">Update category details and settings</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.categories.show', $category) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                        <i class="fas fa-eye mr-2"></i>
                        View
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back
                    </a>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Basic Information -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 mb-4">Basic Information</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                   placeholder="Enter category name">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 @error('slug') border-red-500 @enderror"
                                   placeholder="auto-generated-from-name">
                            <p class="text-xs text-gray-500 mt-1">Leave empty to auto-generate from name</p>
                            @error('slug')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div> -->

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="4"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                      placeholder="Describe this category...">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Category Image -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 mb-4">Category Image</h4>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                        <div id="image-preview" class="{{ $category->image ? '' : 'hidden' }} mb-4">
                            <img id="preview-img" src="{{ $category->image ? asset('storage/' . $category->image) : '' }}" alt="Preview" class="mx-auto h-32 w-32 object-cover rounded-lg">
                        </div>
                        
                        <div id="upload-placeholder" class="{{ $category->image ? 'hidden' : '' }}">
                            <i class="fas fa-image text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600 mb-2">Upload category image</p>
                            <p class="text-sm text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                        
                        <input type="file" id="image" name="image" accept="image/*" class="hidden">
                        <button type="button" onclick="document.getElementById('image').click()" 
                                class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                            {{ $category->image ? 'Change Image' : 'Choose Image' }}
                        </button>
                        
                        @if($category->image)
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

            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    <i class="fas fa-save mr-2"></i>
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-generate slug from name (only if slug is empty)
document.getElementById('name').addEventListener('input', function(e) {
    const slugField = document.getElementById('slug');
    if (!slugField.value) {
        const name = e.target.value;
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
        slugField.value = slug;
    }
});

// Image preview
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