<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Planet-Saving Journey') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Month Selector -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4 bg-white border-b border-gray-200">
                    <form action="{{ route('activity-logs.index') }}" method="GET" class="flex items-center justify-between">
                        <div class="text-lg font-medium flex items-center">
                            <span class="text-2xl mr-2">📅</span> {{ $currentMonthName }}
                        </div>
                        <div class="flex items-center space-x-2">
                            @if (!$activityLogs->isEmpty() && $months->isNotEmpty())
                                <label for="month" class="sr-only">Choose a month</label>
                                <select id="month" name="month" onchange="this.form.submit()"
                                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach($months as $month)
                                        <option value="{{ $month['value'] }}" {{ $currentMonth === $month['value'] ? 'selected' : '' }}>
                                            {{ $month['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            <a href="{{ route('activity-logs.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring ring-blue-300 transition">
                                {{ $activityLogs->isEmpty() ? 'Log Your First Activity' : 'Log Today' }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Monthly Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 items-start">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-gray-200 self-start">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="text-2xl mr-2">🌍</span> My Impact This Month
                    </h3>

                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Days Logged</span>
                        <span class="text-sm text-gray-600">9 / 30</span>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: 30%"></div>
                    </div>

                    <div class="mt-4">
                        <div class="text-lg font-medium flex justify-between items-center">
                            <span>Average Daily Footprint:</span>
                            <span>5.21 kg CO<sub>2</sub>e</span>
                        </div>

                        <div class="text-lg font-medium flex justify-between items-center mt-2">
                            <span>Total This Month:</span>
                            <span>46.92 kg CO<sub>2</sub>e</span>
                        </div>

                        <div class="mt-4 p-3 bg-green-50 rounded-lg">
                            <p class="text-green-700 text-center text-lg font-bold">
                                Amazing! You saved 8.26 kg CO<sub>2</sub>e this month!
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <span class="text-2xl mr-2">🏆</span> My Planet Protector Achievements
                        </h3>

                        @if($daysWithLogs > 0)
                            <div class="grid grid-cols-3 gap-4 mb-6">
                                <div class="text-center p-3 bg-green-50 rounded-lg group relative">
                                    <div class="text-3xl mb-1">🌳</div>
                                    <div class="text-xl font-bold text-green-800">{{ $treeDays }}</div>
                                    <div class="text-sm text-green-600">Tree Days</div>
                                    <!-- Tooltip positioned below -->
                                    <div class="opacity-0 group-hover:opacity-100 duration-300 absolute z-10 w-48 p-3 text-sm rounded-lg shadow-lg bg-white text-gray-600 left-1/2 transform -translate-x-1/2 mt-2 top-full">
                                        Each tree absorbs about 0.06 kg CO₂ per day. Your savings equal {{ $treeDays }} tree days!
                                        <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 rotate-45 w-2 h-2 bg-white"></div>
                                    </div>
                                </div>

                                <div class="text-center p-3 bg-cyan-50 rounded-lg group relative">
                                    <div class="text-3xl mb-1">❄️</div>
                                    <div class="text-xl font-bold text-cyan-800">{{ $iceSaved }}</div>
                                    <div class="text-sm text-cyan-600">kg Ice Saved</div>
                                    <!-- Tooltip positioned below -->
                                    <div class="opacity-0 group-hover:opacity-100 duration-300 absolute z-10 w-48 p-3 text-sm rounded-lg shadow-lg bg-white text-gray-600 left-1/2 transform -translate-x-1/2 mt-2 top-full">
                                        For every kg of CO₂ saved, about 3kg of Arctic ice is preserved from melting.
                                        <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 rotate-45 w-2 h-2 bg-white"></div>
                                    </div>
                                </div>

                                <div class="text-center p-3 bg-purple-50 rounded-lg group relative">
                                    <div class="text-3xl mb-1">⚡</div>
                                    <div class="text-xl font-bold text-purple-800">{{ $heroPoints }}</div>
                                    <div class="text-sm text-purple-600">Hero Points</div>
                                    <!-- Tooltip positioned below -->
                                    <div class="opacity-0 group-hover:opacity-100 duration-300 absolute z-10 w-48 p-3 text-sm rounded-lg shadow-lg bg-white text-gray-600 left-1/2 transform -translate-x-1/2 mt-2 top-full">
                                        You earn 10 Hero Points for each kg of CO₂ saved, plus bonus points for achievements!
                                        <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 rotate-45 w-2 h-2 bg-white"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Explanation Box - Simplified -->
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <p class="text-gray-600 text-sm">
                                    <strong>How are savings calculated?</strong> We compare your actual footprint with what it would have been using your baseline transportation mode ({{ ucfirst(str_replace('_', ' ', $baseline->typical_commute_type ?? 'unknown')) }}).
                                </p>
                            </div>

                            <!-- Earned Badges -->
                            <h4 class="font-medium text-gray-900 mb-3">Earned Badges</h4>

                            @if($unlockedAchievements->isEmpty())
                                <p class="text-gray-500 italic">Keep tracking your activities to earn badges!</p>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($unlockedAchievements as $achievement)
                                        <div class="flex items-center p-3 bg-green-50 rounded-lg group relative">
                                            <span class="text-2xl mr-3">{{ $achievement->icon }}</span>
                                            <div>
                                                <div class="font-bold text-green-800">{{ $achievement->name }}</div>
                                                <div class="text-xs text-green-600">{{ $achievement->description }}</div>
                                                @if($achievement->unlocked_at)
                                                    <div class="text-xs text-gray-500 mt-1">Unlocked: {{ $achievement->unlocked_at->format('M d, Y') }}</div>
                                                @endif
                                            </div>
                                            <!-- Tooltip positioned below -->
                                            <div class="opacity-0 group-hover:opacity-100 duration-300 absolute z-10 w-64 p-3 text-sm rounded-lg shadow-lg bg-white text-gray-600 left-1/2 transform -translate-x-1/2 mt-1 top-full">
                                                <strong>{{ $achievement->name }}:</strong> {{ $achievement->description }}
                                                <br>
                                                <strong>Reward:</strong> {{ $achievement->points }} Hero Points
                                                <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 rotate-45 w-2 h-2 bg-white"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <div class="text-5xl mb-3">🌱</div>
                                <p class="text-gray-600">Start logging your activities to earn planet-saving achievements!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Activity Logs -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="text-2xl mr-2">📝</span> My Planet-Saving Activities
                    </h3>

                    @if($activityLogs->isEmpty())
                        <div class="text-center py-8">
                            <div class="text-6xl mb-4">🚲</div>
                            <p class="text-gray-600 mb-4">No activities logged for this month yet!</p>
                            <a href="{{ route('activity-logs.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring ring-blue-300 transition">
                                Log Your First Activity
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transportation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Distance</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Footprint</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($activityLogs as $log)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $log->date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($log->transport_type == 'walk')
                                                    <span class="inline-flex items-center">
                                                        <span class="text-xl mr-1">🚶</span>
                                                        <span>Walking</span>
                                                    </span>
                                                @elseif($log->transport_type == 'bicycle')
                                                    <span class="inline-flex items-center">
                                                        <span class="text-xl mr-1">🚲</span>
                                                        <span>Bicycle</span>
                                                    </span>
                                                @elseif($log->transport_type == 'car')
                                                    <span class="inline-flex items-center">
                                                        <span class="text-xl mr-1">🚗</span>
                                                        <span>Car</span>
                                                    </span>
                                                @elseif($log->transport_type == 'motorcycle')
                                                    <span class="inline-flex items-center">
                                                        <span class="text-xl mr-1">🏍️</span>
                                                        <span>Motorcycle</span>
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center">
                                                        <span class="text-xl mr-1">🚌</span>
                                                        <span>Public Transit</span>
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $log->transport_distance }} km
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ number_format($log->carbon_footprint, 2) }} kg
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('activity-logs.edit', $log) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>

                                                <form method="POST" action="{{ route('activity-logs.destroy', $log) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                            onclick="return confirm('Are you sure you want to remove this log?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
