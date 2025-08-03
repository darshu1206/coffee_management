@extends('admin.layouts.app')

@section('title', 'Supplier Details')
@section('header', 'Supplier Details')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $supplier->name }}</h3>
                    <p class="text-gray-600">{{ $supplier->company }}</p>
                </div>
                <div class="flex space-x-3">
                    <!-- <span class="px-3 py-1 rounded-full text-sm font-medium 
                        {{ $supplier->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($supplier->status) }}
                    </span> -->
                    <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.suppliers.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Supplier Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900">Contact Information</h4>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                <a href="mailto:{{ $supplier->email }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $supplier->email }}
                                </a>
                            </div>
                        </div>
                        
                        @if($supplier->phone)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone</label>
                            <div class="flex items-center">
                                <i class="fas fa-phone text-gray-400 mr-2"></i>
                                <a href="tel:{{ $supplier->phone }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $supplier->phone }}
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($supplier->website)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Website</label>
                            <div class="flex items-center">
                                <i class="fas fa-globe text-gray-400 mr-2"></i>
                                <a href="{{ $supplier->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                    {{ $supplier->website }}
                                    <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            @if($supplier->address || $supplier->city || $supplier->country)
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900">Address</h4>
                </div>
                <div class="p-6">
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-gray-400 mr-3 mt-1"></i>
                        <div>
                            @if($supplier->address)
                                <p>{{ $supplier->address }}</p>
                            @endif
                            <p>
                                {{ $supplier->city }}{{ $supplier->city && ($supplier->state || $supplier->postal_code) ? ',' : '' }}
                                {{ $supplier->state }} {{ $supplier->postal_code }}
                            </p>
                            @if($supplier->country)
                                <p class="font-medium">{{ $supplier->country }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Description -->
            @if($supplier->description)
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900">Description</h4>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 leading-relaxed">{{ $supplier->description }}</p>
                </div>
            </div>
            @endif

            <!-- Payment Terms -->
            @if($supplier->payment_terms)
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900">Payment Terms</h4>
                </div>
                <div class="p-6">
                    <p class="text-gray-700">{{ $supplier->payment_terms }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900">Quick Stats</h4>
                </div>
                <div class="p-6 space-y-4">
                    <!-- <div class="flex justify-between items-center">
                        <span class="text-gray-600">Status</span>
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $supplier->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($supplier->status) }}
                        </span>
                    </div> -->
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Created</span>
                        <span class="text-gray-900">{{ $supplier->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Updated</span>
                        <span class="text-gray-900">{{ $supplier->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900">Actions</h4>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.suppliers.edit', $supplier) }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>Edit Supplier
                    </a>
                    
                    @if($supplier->email)
                    <a href="mailto:{{ $supplier->email }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-envelope mr-2"></i>Send Email
                    </a>
                    @endif
                    
                    @if($supplier->phone)
                    <a href="tel:{{ $supplier->phone }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-phone mr-2"></i>Call
                    </a>
                    @endif

                    <form method="POST" action="{{ route('admin.suppliers.destroy', $supplier) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this supplier? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash mr-2"></i>Delete Supplier
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection