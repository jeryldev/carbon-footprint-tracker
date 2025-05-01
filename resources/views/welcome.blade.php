<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Planet Protectors - Save Our Earth! 🌎</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .bg-dots-darker {
                background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
            }

            body {
                background: linear-gradient(to bottom, #e0f7fa, #ffffff);
                min-height: 100vh;
            }

            .hero-animation {
                animation: float 6s ease-in-out infinite;
            }

            @keyframes float {
                0% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-20px);
                }
                100% {
                    transform: translateY(0px);
                }
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-fixed selection:bg-green-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-800 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-green-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-800 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-green-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-800 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-green-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center">
                    <div class="hero-animation text-8xl">🌍</div>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 lg:gap-8">
                        <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-green-500">
                            <div class="text-center w-full">
                                <h1 class="text-4xl md:text-5xl font-extrabold text-green-600 mb-4">Welcome to Planet Protectors!</h1>
                                <div class="mt-4 text-xl text-gray-700 leading-relaxed space-y-4">
                                    <p>Join our team of planet heroes and help save the Earth! 🌎</p>
                                    <p>Track your daily activities, see how much carbon you're saving, and earn special badges!</p>
                                </div>

                                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                                    <div class="p-4 bg-green-50 rounded-lg">
                                        <div class="text-4xl mb-2">🌱</div>
                                        <h3 class="text-lg font-semibold text-green-800">Track Your Actions</h3>
                                        <p class="text-sm text-green-600 mt-2">Log how you travel, use electricity, and create waste each day.</p>
                                    </div>

                                    <div class="p-4 bg-blue-50 rounded-lg">
                                        <div class="text-4xl mb-2">📊</div>
                                        <h3 class="text-lg font-semibold text-blue-800">See Your Impact</h3>
                                        <p class="text-sm text-blue-600 mt-2">Watch how your daily choices help save our planet!</p>
                                    </div>

                                    <div class="p-4 bg-purple-50 rounded-lg">
                                        <div class="text-4xl mb-2">🏆</div>
                                        <h3 class="text-lg font-semibold text-purple-800">Earn Rewards</h3>
                                        <p class="text-sm text-purple-600 mt-2">Collect hero points and special badges for your efforts!</p>
                                    </div>
                                </div>

                                <div class="mt-10 flex items-center justify-center gap-4">
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="px-6 py-3 bg-green-600 rounded-full text-white font-semibold text-lg hover:bg-green-700 transition">Go to Your Dashboard</a>
                                    @else
                                        <a href="{{ route('register') }}" class="px-6 py-3 bg-green-600 rounded-full text-white font-semibold text-lg hover:bg-green-700 transition">Start Your Journey!</a>
                                        <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-600 rounded-full text-white font-semibold text-lg hover:bg-blue-700 transition">Welcome Back!</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                    <div class="text-center text-sm text-gray-500 sm:text-left">
                        <div class="flex items-center gap-4">
                            <div>Created by Jeryl D. Estopace for the final project in CMSC 207 - Web Programming and Development</div>
                        </div>
                    </div>

                    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                        Made with 💚 for the planet
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
