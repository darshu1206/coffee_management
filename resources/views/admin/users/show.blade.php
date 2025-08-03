@extends('admin.layouts.app')

@section('title', 'User Details')
@section('header', 'User Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">User Details</h2>
            <p class="text-gray-600">View user information and activity</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-edit mr-2"></i>Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Back to Users
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Information -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <div class="text-center">
                        <div class="h-20 w-20 bg-gray-300 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user text-gray-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <!-- <div class="mt-2">
                            <span class="px-3 py-1 text-sm rounded-full 
                                {{ $user->is_admin ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $user->is_admin ? 'Administrator' : 'Regular User' }}
                            </span>
                        </div> -->
                    </div>
                </div>
                <div class="border-t border-gray-200 px-6 py-4">
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">User ID</dt>
                            <dd class="text-sm text-gray-900">#{{ $user->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Joined</dt>
                            <dd class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="text-sm text-gray-900">{{ $user->updated_at->format('M d, Y h:i A') }}</dd>
                        </div>
                        <!-- <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="text-sm">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            </dd>
                        </div> -->
                    </dl>
                </div>
            </div>
        </div>

        <!-- Activity & Statistics -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Orders</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $user->orders()->count() ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fas fa-dollar-sign text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Spent</p>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($user->orders()->where('status', 'completed')->sum('total_amount') ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-amber-100 rounded-lg">
                            <i class="fas fa-calendar text-amber-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Member Since</p>
                            <p class="text-lg font-bold text-gray-900">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Recent Orders</h3>
                </div>
                <div class="p-6">
                    @php
                        $recentOrders = $user->orders()->latest()->take(5)->get();
                    @endphp
                    
                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">Order #{{ $order->id }}</p>
                                        <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                               ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($user->orders()->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="{{ route('admin.orders.index') }}?user_id={{ $user->id }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium">
                                    View all orders <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-500 text-center py-8">No orders found</p>
                    @endif
                </div>
            </div>

            <!-- Account Actions -->
            @if($user->id !== auth()->id())
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Account Actions</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 border border-red-200 rounded-lg bg-red-50">
                                <div>
                                    <h4 class="font-medium text-red-900">Delete Account</h4>
                                    <p class="text-sm text-red-700">Permanently delete this user account and all associated data.</p>
                                </div>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">
                                        <i class="fas fa-trash mr-2"></i>Delete User
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection