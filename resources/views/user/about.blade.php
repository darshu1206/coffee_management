@extends('layouts.user-layout')

@section('title', 'About Us')

@section('content')
<div class="coffee-gradient py-12">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
            <i class="fas fa-info-circle text-yellow-300 mr-2"></i>
            About Our Coffee Shop
        </h1>
        <p class="text-xl text-gray-200">
            Learn about our story, mission, and values that fuel our passion for coffee.
        </p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 py-16 space-y-16">
    <!-- Our Story -->
    <section>
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Story</h2>
        <p class="text-gray-700 leading-relaxed">
            Born from a love for rich aromas and deep flavor, our journey started in a small neighborhood with a big dream — to bring world-class coffee experiences to every corner. From ethically sourced beans to hand-crafted brews, we believe great coffee builds community.
        </p>
    </section>

    <!-- Mission -->
    <section>
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Mission</h2>
        <p class="text-gray-700 leading-relaxed">
            We're committed to sustainability, fair trade, and delivering exceptional coffee. Our mission is to inspire moments of connection — one cup at a time.
        </p>
    </section>

    <!-- Meet the Team -->
    <!-- <section>
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Meet the Team</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <img src="https://i.pravatar.cc/150?img=3" alt="Team Member" class="w-24 h-24 mx-auto rounded-full mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Emily Carter</h3>
                <p class="text-sm text-gray-600">Head Barista</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <img src="https://i.pravatar.cc/150?img=12" alt="Team Member" class="w-24 h-24 mx-auto rounded-full mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Liam Roberts</h3>
                <p class="text-sm text-gray-600">Roast Master</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <img src="https://i.pravatar.cc/150?img=5" alt="Team Member" class="w-24 h-24 mx-auto rounded-full mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Sofia Bennett</h3>
                <p class="text-sm text-gray-600">Creative Director</p>
            </div>
        </div>
    </section> -->

    <!-- Our Values -->
    <section>
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Values</h2>
        <ul class="list-disc list-inside text-gray-700 space-y-2">
            <li><strong>Quality:</strong> We never compromise on taste or sourcing.</li>
            <li><strong>Community:</strong> Coffee is more than a drink — it's a connection.</li>
            <li><strong>Sustainability:</strong> Supporting ethical farming and reducing our footprint.</li>
        </ul>
    </section>

    <!-- Call to Action -->
    <section class="text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Visit us or order online today</h2>
        <a href="{{ route('user.shop') }}" class="btn-coffee inline-block px-6 py-3 rounded-lg font-medium">
            <i class="fas fa-mug-hot mr-2"></i> Explore Our Coffee
        </a>
    </section>
</div>
@endsection
