<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Planet Savior Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (!$hasBaseline)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="text-2xl">🌟</div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Let's start your planet-saving journey! Complete your baseline assessment to see how much you can help the Earth.
                                <a href="{{ route('baseline-assessment.create') }}" class="font-medium underline text-yellow-700 hover:text-yellow-600">
                                    Complete it now
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-6">
                <form action="{{ route('dashboard') }}" method="GET" class="flex justify-between items-center">
                    <div class="text-gray-700 font-medium">I want to see my planet-saving power for:</div>

                    <div class="flex space-x-2">
                        <button type="submit" name="period" value="today"
                                class="px-4 py-2 rounded-full {{ $period === 'today' ? 'bg-blue-600 text-white' : 'bg-gray-100 hover:bg-gray-200' }}">
                            Today
                        </button>

                        <button type="submit" name="period" value="week"
                                class="px-4 py-2 rounded-full {{ $period === 'week' ? 'bg-blue-600 text-white' : 'bg-gray-100 hover:bg-gray-200' }}">
                            This Week
                        </button>

                        <button type="submit" name="period" value="month"
                                class="px-4 py-2 rounded-full {{ $period === 'month' ? 'bg-blue-600 text-white' : 'bg-gray-100 hover:bg-gray-200' }}">
                            This Month
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Planet Saving Power</h3>

                            <div class="rounded-full bg-gray-100 px-4 py-1 text-sm">
                                {{ ucfirst($period) }}
                            </div>
                        </div>

                        @if($savings['is_saving'] === null)
                            <div class="text-center py-8">
                                <div class="text-6xl mb-4">🌍</div>
                                <p class="text-lg text-gray-600">{{ $savings['message'] }}</p>
                                <div class="mt-6">
                                    <a href="{{ route('baseline-assessment.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring ring-blue-300 transition">
                                        Complete Baseline Assessment
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="text-center mb-6">
                                <p class="text-xl font-semibold text-gray-800 mb-2">
                                    {{ $savings['message'] }}
                                </p>

                                @if($savings['is_saving'])
                                    <div class="text-5xl mb-2">
                                        🎉
                                    </div>
                                    <div class="text-3xl font-bold text-green-600">
                                        {{ number_format($savings['savings'], 1) }} kg CO₂e saved!
                                    </div>
                                @else
                                    <div class="text-5xl mb-2">
                                        💪
                                    </div>
                                    <div class="text-3xl font-bold text-amber-600">
                                        Let's save more tomorrow!
                                    </div>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                                <div class="text-center p-4 bg-green-50 rounded-lg">
                                    <div class="text-4xl mb-2">🌳</div>
                                    <div class="text-2xl font-bold text-green-800">{{ $savings['trees_saved'] }}</div>
                                    <div class="text-sm text-green-600">Tree Days</div>
                                </div>

                                <div class="text-center p-4 bg-blue-50 rounded-lg">
                                    <div class="text-4xl mb-2">🚗</div>
                                    <div class="text-2xl font-bold text-blue-800">{{ $savings['car_kilometers'] }}</div>
                                    <div class="text-sm text-blue-600">Car Kilometers</div>
                                </div>

                                <div class="text-center p-4 bg-cyan-50 rounded-lg">
                                    <div class="text-4xl mb-2">❄️</div>
                                    <div class="text-2xl font-bold text-cyan-800">{{ $savings['ice_saved'] }}</div>
                                    <div class="text-sm text-cyan-600">kg Ice Saved</div>
                                </div>

                                <div class="text-center p-4 bg-purple-50 rounded-lg">
                                    <div class="text-4xl mb-2">⚡</div>
                                    <div class="text-2xl font-bold text-purple-800">{{ $savings['superhero_points'] }}</div>
                                    <div class="text-sm text-purple-600">Hero Points</div>
                                </div>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('activity-logs.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring ring-blue-300 transition">
                                    Log Today's Activity
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">About Carbon Footprint Tracker</h3>

                        <div class="prose max-w-none text-gray-700">
                            <p>
                                The Carbon Footprint Tracker helps you understand how your daily activities affect our planet.
                                By tracking what you do, you can see how you're helping save the Earth! 🌍
                            </p>

                            <p class="mt-3">
                                Our app uses real science to calculate your carbon footprint based on research by Aiza C. Cortes
                                from the University of the Philippines Cebu.
                            </p>

                            <p class="mt-3">
                                <a href="https://philjournalsci.dost.gov.ph/images/pdf/pjs_pdf/vol151no3/greenhouse_gas_emissions_inventory_in_UP_Cebu_.pdf"
                                   class="text-blue-600 hover:underline"
                                   target="_blank">
                                    Read the research paper →
                                </a>
                            </p>

                            <div class="mt-4 p-4 bg-green-50 rounded-lg">
                                <h4 class="font-medium text-green-800">How You're Saving The Planet</h4>
                                <p class="text-green-700">
                                    When you walk or bike instead of riding in a car, you help reduce greenhouse gases.
                                    Every kilogram of CO₂ you save helps protect animals, plants, and people around the world.
                                    You're a planet-saving superhero! 🦸
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">My Recent Activity</h3>
                            <a href="{{ route('activity-logs.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
                        </div>

                        @if ($recentLogs->isEmpty())
                            <div class="text-center py-6">
                                <div class="text-4xl mb-4">🚲</div>
                                <p class="text-gray-500">No activity logs yet. Start tracking to see your planet-saving power!</p>
                                <div class="mt-4">
                                    <a href="{{ route('activity-logs.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring ring-blue-300 transition">
                                        Log My First Activity
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="divide-y divide-gray-200">
                                @foreach ($recentLogs as $log)
                                    <div class="py-3">
                                        <div class="flex justify-between">
                                            <span class="text-sm font-medium">{{ $log->date->format('M d, Y') }}</span>
                                            <span class="text-sm font-semibold">{{ number_format($log->carbon_footprint, 2) }} kg CO₂e</span>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-500 mt-1">
                                            @if($log->transport_type == 'walk')
                                                <span class="mr-1">🚶</span>
                                            @elseif($log->transport_type == 'bicycle')
                                                <span class="mr-1">🚲</span>
                                            @elseif($log->transport_type == 'car')
                                                <span class="mr-1">🚗</span>
                                            @elseif($log->transport_type == 'motorcycle')
                                                <span class="mr-1">🏍️</span>
                                            @else
                                                <span class="mr-1">🚌</span>
                                            @endif
                                            {{ ucfirst(str_replace('_', ' ', $log->transport_type)) }} - {{ $log->transport_distance }} km
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
