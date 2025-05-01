<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-semibold mb-4">Quick Actions</h2>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('activity-logs.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            {{ __('Log Today\'s Activity') }}
                        </a>
                        <a href="{{ route('activity-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            {{ __('View Activity History') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-lg font-semibold mb-4">Your Carbon Summary</h2>

                        @php
                            $recentLogs = Auth::user()->activityLogs()->latest('date')->take(7)->get();
                            $totalFootprint = $recentLogs->sum('carbon_footprint');
                            $avgFootprint = $recentLogs->count() > 0 ? $totalFootprint / $recentLogs->count() : 0;
                        @endphp

                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Last 7 days total:</p>
                            <p class="text-3xl font-bold text-gray-800">{{ number_format($totalFootprint, 2) }} kg CO<sub>2</sub>e</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Daily average:</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ number_format($avgFootprint, 2) }} kg CO<sub>2</sub>e</p>
                        </div>

                        <!-- Placeholder for future visualization -->
                        <div class="bg-gray-100 p-4 rounded-md mt-4">
                            <p class="text-gray-500 text-sm">Carbon footprint visualization will appear here in a future update.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-lg font-semibold mb-4">Recent Activities</h2>

                        @if ($recentLogs->isEmpty())
                            <p class="text-gray-500">You haven't logged any activities yet.</p>
                        @else
                            <div class="space-y-4">
                                @foreach ($recentLogs->take(5) as $log)
                                    <div class="border-b border-gray-200 pb-3">
                                        <div class="flex justify-between">
                                            <span class="font-medium">{{ $log->date->format('M d, Y') }}</span>
                                            <span class="text-gray-600">{{ number_format($log->carbon_footprint, 2) }} kg CO<sub>2</sub>e</span>
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            <span>Transport:
                                                @switch($log->transport_type)
                                                    @case('walk')
                                                        Walking
                                                        @break
                                                    @case('bicycle')
                                                        Cycling
                                                        @break
                                                    @case('motorcycle')
                                                        Motorcycle
                                                        @break
                                                    @case('car')
                                                        Car
                                                        @break
                                                    @case('public_transit')
                                                        Public Transit
                                                        @break
                                                    @default
                                                        {{ ucfirst($log->transport_type) }}
                                                @endswitch
                                                ({{ number_format($log->transport_distance, 1) }} km)
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('activity-logs.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                                    View all activity logs →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
