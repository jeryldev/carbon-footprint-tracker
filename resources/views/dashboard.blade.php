<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Planet Protector Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (!$hasBaseline)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex flex-row items-center">
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

            @if(isset($recommendation))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-green-700 mb-4 flex items-center">
                        <span class="text-2xl mr-2">💡</span> Today's Planet-Saving Tip
                    </h3>

                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-lg font-medium text-green-800 mb-2">{{ $recommendation['tip'] }}</p>

                        @if(isset($recommendation['impact_description']))
                        <p class="text-sm text-green-700 mb-2">{{ $recommendation['impact_description'] }}</p>
                        @endif

                        @if(isset($recommendation['potential_savings']) && $recommendation['potential_savings'] > 0)
                        <p class="text-sm text-green-600 font-medium">
                            You could save about {{ $recommendation['potential_savings'] }}g of carbon pollution each time you do this!
                        </p>
                        @endif
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-4 mb-6">
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
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Planet Saving Power</h3>

                            <div class="rounded-full bg-gray-100 px-4 py-1 text-sm">
                                {{ ucfirst($period) }}
                            </div>
                        </div>

                        @if (!$hasBaseline)
                            <!-- No Baseline Assessment -->
                            <div class="text-center py-8">
                                <div class="text-6xl mb-4">🌍</div>
                                <p class="text-lg text-gray-600">{{ $savings['message'] }}</p>
                                <div class="mt-6">
                                    <a href="{{ route('baseline-assessment.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring ring-blue-300 transition">
                                        Complete Baseline Assessment
                                    </a>
                                </div>
                            </div>
                        @elseif ($recentLogs->isEmpty())
                            <!-- Has Baseline but No Activity Logs -->
                            <div class="text-center py-8">
                                <div class="text-6xl mb-4">📝</div>
                                <p class="text-lg text-gray-600">You've completed your baseline assessment. Now let's start tracking your daily activities!</p>
                                <div class="mt-6">
                                    <a href="{{ route('activity-logs.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring ring-green-300 transition">
                                        Log My First Activity
                                    </a>
                                </div>
                            </div>
                        @elseif($savings['is_saving'] === null)
                            <!-- Has Baseline but No Activities in Selected Period -->
                            <div class="text-center py-8">
                                <div class="text-6xl mb-4">🔍</div>
                                <p class="text-lg text-gray-600">{{ $savings['message'] }}</p>
                                <div class="mt-6">
                                    <a href="{{ route('activity-logs.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring ring-blue-300 transition">
                                        Log Today's Activity
                                    </a>
                                </div>
                            </div>
                        @else
                            <!-- Has Baseline and Activities -->
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
                                <div class="text-center p-4 bg-green-50 rounded-lg group relative">
                                    <div class="text-4xl mb-2">🌳</div>
                                    <div class="text-2xl font-bold text-green-800">{{ $savings['trees_saved'] }}</div>
                                    <div class="text-sm text-green-600">Tree Days</div>
                                    <div class="opacity-0 group-hover:opacity-100 duration-300 absolute z-50 w-48 p-3 text-sm rounded-lg shadow-lg bg-white text-gray-600 left-1/2 transform -translate-x-1/2 mt-2 top-full">
                                        Each tree absorbs about 0.06 kg CO₂ per day. Your savings equal {{ $savings['trees_saved'] }} tree days!
                                        <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 rotate-45 w-2 h-2 bg-white"></div>
                                    </div>
                                </div>

                                <div class="text-center p-4 bg-blue-50 rounded-lg group relative">
                                    <div class="text-4xl mb-2">🚗</div>
                                    <div class="text-2xl font-bold text-blue-800">{{ $savings['car_kilometers'] }}</div>
                                    <div class="text-sm text-blue-600">Car Kilometers</div>
                                    <div class="opacity-0 group-hover:opacity-100 duration-300 absolute z-50 w-48 p-3 text-sm rounded-lg shadow-lg bg-white text-gray-600 left-1/2 transform -translate-x-1/2 mt-2 top-full">
                                        Equivalent to the CO₂ emitted by a car driving {{ $savings['car_kilometers'] }} kilometers.
                                        <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 rotate-45 w-2 h-2 bg-white"></div>
                                    </div>
                                </div>

                                <div class="text-center p-4 bg-cyan-50 rounded-lg group relative">
                                    <div class="text-4xl mb-2">❄️</div>
                                    <div class="text-2xl font-bold text-cyan-800">{{ $savings['ice_saved'] }}</div>
                                    <div class="text-sm text-cyan-600">kg Ice Saved</div>
                                    <div class="opacity-0 group-hover:opacity-100 duration-300 absolute z-50 w-48 p-3 text-sm rounded-lg shadow-lg bg-white text-gray-600 left-1/2 transform -translate-x-1/2 mt-2 top-full">
                                        For every kg of CO₂ saved, about 3kg of Arctic ice is preserved from melting.
                                        <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 rotate-45 w-2 h-2 bg-white"></div>
                                    </div>
                                </div>

                                <div class="text-center p-4 bg-purple-50 rounded-lg group relative">
                                    <div class="text-4xl mb-2">⚡</div>
                                    <div class="text-2xl font-bold text-purple-800">{{ $savings['superhero_points'] }}</div>
                                    <div class="text-sm text-purple-600">Hero Points</div>
                                    <div class="opacity-0 group-hover:opacity-100 duration-300 absolute z-50 w-48 p-3 text-sm rounded-lg shadow-lg bg-white text-gray-600 left-1/2 transform -translate-x-1/2 mt-2 top-full">
                                        You earn 10 Hero Points for each kg of CO₂ saved, plus bonus points for achievements!
                                        <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 rotate-45 w-2 h-2 bg-white"></div>
                                    </div>
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
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">About Carbon Footprint Tracker</h3>

                        <div class="prose max-w-none text-gray-700">
                            <p>
                                The Carbon Footprint Tracker helps visualize how daily activities affect the planet.
                                By tracking activities, anyone can see their contribution to saving the Earth! 🌍
                            </p>

                            <p class="mt-3">
                                This app uses our advanced calculation system that compares your actual activities with your baseline habits for accurate impact measurement. It's built on scientific principles from research by Aiza C. Cortes at the University of the Philippines Cebu.
                            </p>

                            <p class="mt-3">
                                <a href="https://philjournalsci.dost.gov.ph/images/pdf/pjs_pdf/vol151no3/greenhouse_gas_emissions_inventory_in_UP_Cebu_.pdf"
                                   class="text-blue-600 hover:underline"
                                   target="_blank">
                                    Read the research paper →
                                </a>
                            </p>

                            <div class="mt-4 p-4 bg-green-50 rounded-lg">
                                <h4 class="font-medium text-green-800">How to Help Save The Planet</h4>
                                <p class="text-green-700">
                                    Walking or biking instead of riding in a car helps reduce greenhouse gases.
                                    Every kilogram of CO₂ saved helps protect animals, plants, and people around the world.
                                    Everyone can be a planet-saving superhero! 🦸
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">My Recent Activity</h3>
                            @if (!$recentLogs->isEmpty())
                                <a href="{{ route('activity-logs.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
                            @endif
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
