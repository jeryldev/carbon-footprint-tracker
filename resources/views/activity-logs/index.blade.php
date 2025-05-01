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
                            <label for="month" class="sr-only">Choose a month</label>
                            <select id="month" name="month" onchange="this.form.submit()"
                                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach($months as $month)
                                    <option value="{{ $month['value'] }}" {{ $currentMonth === $month['value'] ? 'selected' : '' }}>
                                        {{ $month['label'] }}
                                    </option>
                                @endforeach
                            </select>

                            <a href="{{ route('activity-logs.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring ring-blue-300 transition">
                                Log Today
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Monthly Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <span class="text-2xl mr-2">🌍</span> My Impact This Month
                        </h3>

                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Days Logged</span>
                            <span class="text-sm text-gray-600">{{ $daysWithLogs }} / {{ $daysInMonth }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ ($daysWithLogs / $daysInMonth) * 100 }}%"></div>
                        </div>

                        <div class="mt-4">
                            <div class="text-lg font-medium flex justify-between items-center">
                                <span>Average Daily Footprint:</span>
                                <span>{{ number_format($dailyAverage, 2) }} kg CO₂e</span>
                            </div>

                            @if($daysWithLogs > 0)
                                <div class="text-lg font-medium flex justify-between items-center mt-2">
                                    <span>Total This Month:</span>
                                    <span>{{ number_format($totalFootprint, 2) }} kg CO₂e</span>
                                </div>

                                @if($isSaving)
                                    <div class="mt-4 p-3 bg-green-50 rounded-lg">
                                        <p class="text-green-700 text-center text-lg font-bold">
                                            Amazing! You saved {{ number_format($savingsAmount, 2) }} kg CO₂e this month!
                                        </p>
                                    </div>
                                @else
                                    <div class="mt-4 p-3 bg-amber-50 rounded-lg">
                                        <p class="text-amber-700 text-center text-lg font-bold">
                                            You're on your way! Keep trying to beat your baseline!
                                        </p>
                                    </div>
                                @endif
                            @else
                                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                                    <p class="text-blue-700 text-center">
                                        No activity logs yet this month. Start logging to see your impact!
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <span class="text-2xl mr-2">🏆</span> My Planet Protector Achievements
                        </h3>

                        @if($daysWithLogs > 0)
                            <div class="grid grid-cols-3 gap-4">
                                <div class="text-center p-3 bg-green-50 rounded-lg">
                                    <div class="text-3xl mb-1">🌳</div>
                                    <div class="text-xl font-bold text-green-800">{{ $treeDays }}</div>
                                    <div class="text-sm text-green-600">Tree Days</div>
                                </div>

                                <div class="text-center p-3 bg-cyan-50 rounded-lg">
                                    <div class="text-3xl mb-1">❄️</div>
                                    <div class="text-xl font-bold text-cyan-800">{{ $iceSaved }}</div>
                                    <div class="text-sm text-cyan-600">kg Ice Saved</div>
                                </div>

                                <div class="text-center p-3 bg-purple-50 rounded-lg">
                                    <div class="text-3xl mb-1">⚡</div>
                                    <div class="text-xl font-bold text-purple-800">{{ $heroPoints }}</div>
                                    <div class="text-sm text-purple-600">Hero Points</div>
                                </div>
                            </div>

                            <div class="mt-4">
                                @if($daysWithLogs >= 20)
                                    <div class="flex items-center mb-2">
                                        <span class="text-2xl mr-2">🏅</span>
                                        <span class="text-lg font-medium">Super Logger Badge</span>
                                    </div>
                                @endif

                                @if($isSaving && $savingsAmount > 10)
                                    <div class="flex items-center mb-2">
                                        <span class="text-2xl mr-2">🌟</span>
                                        <span class="text-lg font-medium">Carbon Crusher Badge</span>
                                    </div>
                                @endif

                                @if($treeDays > 50)
                                    <div class="flex items-center">
                                        <span class="text-2xl mr-2">🌱</span>
                                        <span class="text-lg font-medium">Forest Friend Badge</span>
                                    </div>
                                @endif
                            </div>
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
