<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTrack Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 1.5s ease-out forwards;
        }
    </style>
</head>
<body class="bg-blue-800 text-white font-sans">
    <!-- Navbar -->
    <nav class="bg-blue-900 p-5">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('build/assets/edutrack_logo.png') }}" alt="EduTrack Logo" class="w-12 h-12">
                <h1 class="text-2xl font-bold ml-2">EduTrack</h1>
            </div>
            <div>
                <a href="#features" class="ml-5 text-white hover:underline">Features</a>
                <a href="#about" class="ml-5 text-white hover:underline">About</a>
                {{-- <a href="#contact" class="ml-5 text-white hover:underline">Join Us</a> --}}
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="h-screen flex items-center bg-blue-700">
        <div class="container mx-auto flex flex-col md:flex-row items-center">
            <!-- Left Content -->
            <div class="md:w-1/2 p-10 animate-fade-in">
                <h2 class="text-5xl font-bold mb-5">Track Education Data with <span class="text-blue-300">EduTrack</span></h2>
                <p class="text-lg mb-6">EduTrack is a website to keep track of educational data over the past 6 months</p>
                <a href="#features" class="bg-blue-500 text-white py-3 px-6 rounded-lg hover:bg-blue-600">Get Started</a>
            </div>
            <!-- Right Image -->
            <div class="md:w-9/12 flex items-center justify-end">
                <img src="{{ asset('build/assets/wave.png') }}" alt="Educational Image" class="w-auto h-auto">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-blue-900">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-4xl font-bold mb-8">Features</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Feature 1 -->
                <div class="p-6 bg-blue-700 rounded-lg shadow-lg">
                    <h4 class="text-2xl font-bold mb-3">Track Data</h4>
                    <p>Monitor educational data with detailed visualizations.</p>
                </div>
                <!-- Feature 2 -->
                <div class="p-6 bg-blue-700 rounded-lg shadow-lg">
                    <h4 class="text-2xl font-bold mb-3">Multiple Visualizations</h4>
                    <p>Observe the educational data with various visualizations.</p>
                </div>
                <!-- Feature 3 -->
                <div class="p-6 bg-blue-700 rounded-lg shadow-lg">
                    <h4 class="text-2xl font-bold mb-3">Various Data</h4>
                    <p>Observe official educational data such as teachers and schools data.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-blue-800">
        <div class="container mx-auto text-center">
            <h3 class="text-4xl font-bold mb-8">About EduTrack</h3>
            <p class="text-lg">EduTrack is a platform designed for your educational data observation needs.</p>
        </div>
    </section>

    <!-- Login / Register Section -->
    <section id="auth" class="py-20 bg-blue-900">
        <div class="container mx-auto text-center">
            @if (Route::has('login'))
                @auth
                    <!-- Jika sudah login, tampilkan pesan dan tombol untuk Dashboard -->
                    <h3 class="text-4xl font-bold mb-12">Welcome Back!</h3>
                    <a href="{{ url('/dashboard') }}" class="w-40 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-500">Dashboard</a>
                @else
                    <!-- Jika belum login, tampilkan pesan dan tombol untuk Login dan Register -->
                    <h3 class="text-4xl font-bold mb-8">Join EduTrack</h3>
                    <p class="text-lg mb-6">Login or create an account to get started with tracking your educational journey.</p>
                    <div class="flex justify-center space-x-4">
                        <!-- Login Button -->
                        <a href="{{ route('login') }}" class="w-40 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-500">
                            Login
                        </a>
                        <!-- Register Button -->
                        <a href="{{ route('register') }}" class="w-40 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-500">
                            Register
                        </a>
                    </div>
                @endauth
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-800 py-6">
        <div class="container mx-auto text-center">
            <p class="text-white">&copy; 2024 EduTrack. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
