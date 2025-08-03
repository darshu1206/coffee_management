<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Coffee Shop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-amber-50 to-orange-100 min-h-screen">
    <div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Background Image Layer -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/admin_bg.jpg') }}" alt="Background" class="w-full h-full object-cover opacity-70">
        </div>
        <div class="max-w-md w-full space-y-8 relative z-10">
            <!-- Header -->
            <div class="text-center">
                <!-- <div class="mx-auto h-16 w-16 bg-gradient-to-r from-amber-600 to-orange-600 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-coffee text-white text-2xl"></i>
                </div> -->
                <div>
                    <a href="/">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto w-28 h-28 object-contain">
                    </a>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Admin Panel</h2>
                <p class="text-white">Sign in to manage your coffee shop</p>
            </div>

            <!-- Login Form -->
            <div class="bg-white rounded-lg shadow-xl p-8">
                <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-amber-600"></i>Email Address
                        </label>
                        <input type="email" name="email" id="email" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200"
                               placeholder="admin@coffeeshop.com"
                               value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-amber-600"></i>Password
                        </label>
                        <input type="password" name="password" id="password" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200"
                               placeholder="Enter your password">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                               class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Remember me
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-amber-600 to-orange-600 text-white py-3 px-6 rounded-lg font-medium hover:from-amber-700 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transform transition duration-200 hover:scale-105">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </button>
                </form>

                <!-- Admin Credentials Info -->
                <!-- <div class="mt-6 p-4 bg-amber-50 rounded-lg">
                    <h4 class="text-sm font-medium text-amber-800 mb-2">Admin Access:</h4>
                    <p class="text-xs text-amber-700">
                        Use an email containing 'admin' or 'admin@coffeeshop.com' to access the admin panel.
                    </p>
                </div> -->

                <!-- Back to Site -->
                <div class="mt-6 text-center">
                    <a href="{{ route('user.home') }}" class="text-amber-600 hover:text-amber-800 text-sm">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Website
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>