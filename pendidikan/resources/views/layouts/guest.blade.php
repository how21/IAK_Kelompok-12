<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
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
    
            /* Smaller input field styling */
            .small-input {
                padding: 0.5rem; /* Reduced padding */
                font-size: 0.875rem; /* Reduced font size */
            }
        </style>
    </head>
    <body class="h-screen bg-blue-800 flex">
        <div class="w-1/2 flex justify-start items-center px-10 animate-fade-in">
            <div class="bg-blue-900 p-8 rounded-[30px] shadow-lg w-full max-w-md">
                <div class="text-center mb-8">
                    <img src="{{ asset('build/assets/edutrack_logo.png') }}" alt="EduTrack Logo" class="mx-auto w-20 mb-4">
                    <h1 class="text-white text-3xl font-bold">EduTrack</h1>
                </div>
                {{ $slot }}
            </div>
        </div>

        <script>
            const passwordField = document.querySelector('#password');
            const togglePasswordButton = document.querySelector('#togglePassword');
        
            // Listen for input in the password field
            passwordField.addEventListener('input', function () {
                if (passwordField.value.length > 0) {
                    // Show the button when there is input
                    togglePasswordButton.classList.remove('hidden');
                } else {
                    // Hide the button if the input is cleared
                    togglePasswordButton.classList.add('hidden');
                }
            });
        
            // Toggle password visibility when the button is clicked
            togglePasswordButton.addEventListener('click', function () {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                
                // Toggle the button text between Show and Hide
                this.textContent = type === 'password' ? 'Show' : 'Hide';
            });
        </script>
        
        
    
        <!-- Right Side - Image -->
        <div class="w-1/2 flex justify-center items-center animate-fade-in">
            <img src="{{ asset('build/assets/wave.png') }}"  alt="Right Side Image" class="w-full h-full">
        </div>
    </body>
</html>
