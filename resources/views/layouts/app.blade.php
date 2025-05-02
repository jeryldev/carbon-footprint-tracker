<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Carbon Footprint Tracker') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm" role="alert">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl">🎉</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm" role="alert">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl">🤔</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-green-50 shadow-inner mt-6 py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <div class="flex justify-center space-x-4 mb-4">
                            <span class="text-3xl bg-white p-2 rounded-full shadow-sm">🌎</span>
                            <span class="text-3xl bg-white p-2 rounded-full shadow-sm">🌳</span>
                            <span class="text-3xl bg-white p-2 rounded-full shadow-sm">🚲</span>
                            <span class="text-3xl bg-white p-2 rounded-full shadow-sm">💚</span>
                        </div>
                        <p class="text-green-700 text-lg font-medium">
                            Every day is Earth Day when you're a Planet Protector!
                        </p>
                        <div class="mt-4 pt-4 border-t border-green-200 max-w-lg mx-auto">
                            <p class="text-gray-600 mb-1">
                                Carbon Footprint Tracker | CMSC 207 Final Project
                            </p>
                            <p class="text-gray-500 text-sm">
                                Created by <span class="font-semibold">Jeryl D. Estopace</span> | University of the Philippines Open University
                            </p>
                            <p class="text-gray-500 text-xs mt-2">
                                Based on research by Aiza C. Cortes from the University of the Philippines Cebu
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
