@extends('layouts.user-layout')

@section('title', 'Contact Us')

@section('content')
<div class="coffee-gradient py-12">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
            <i class="fas fa-envelope text-yellow-300 mr-2"></i>
            Contact Us
        </h1>
        <p class="text-xl text-gray-200">
            Have a question or comment? We're here to help — reach out anytime!
        </p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Contact Form -->
        <div class="bg-white rounded-xl shadow p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Send a Message</h2>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('user.contact.submit') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Your Message</label>
                    <textarea id="message" name="message" rows="5" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500"
                        placeholder="Tell us what’s on your mind...">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="bg-amber-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-amber-700 transition duration-300 flex items-center justify-center space-x-2">
                    <i class="fas fa-paper-plane"></i>
                    <span>Send Message</span>
                </button>
            </form>
        </div>

        <!-- Contact Info -->
        <div class="space-y-8">
            <div class="bg-white rounded-xl shadow p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Our Location</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    <strong>Visit us at:</strong><br>
                    Rajkot, Gujarat, India
                </p>
                <p class="text-gray-700">
                    <strong>Email:</strong> info@coffeeshop.com<br>
                    <strong>Phone:</strong> +91 70462 99385
                </p>
            </div>

            <div class="bg-white rounded-xl shadow p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Follow Us</h2>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-blue-600 text-white flex items-center justify-center rounded-full hover:bg-blue-700">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-pink-600 text-white flex items-center justify-center rounded-full hover:bg-pink-700">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-blue-400 text-white flex items-center justify-center rounded-full hover:bg-blue-500">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
