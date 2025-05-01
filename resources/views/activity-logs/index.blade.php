<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activity History') }}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($activityLogs->isEmpty())
                        <p class="text-gray-500">You haven't logged any activities yet.</p>
                        <div class="mt-4">
                            <a href="{{ route('activity-logs.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300">
                                {{ __('Log Your First Activity') }}
                            </a>
                        </div>
                    @else
                        <div class="mb-4">
                            <a href="{{ route('activity-logs.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300">
                                {{ __('Log New Activity') }}
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Transport
                                        </th>
                                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Distance (km)
                                        </th>
                                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Electricity (kWh)
                                        </th>
                                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Waste (kg)
                                        </th>
                                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Carbon Footprint
                                        </th>
                                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activityLogs as $log)
                                        <tr>
                                            <td class="py-2 px-4 border-b border-gray-200">
                                                {{ $log->date->format('Y-m-d') }}
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-200">
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
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-200">
                                                {{ number_format($log->transport_distance, 1) }}
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-200">
                                                {{ number_format($log->electricity_usage, 1) }}
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-200">
                                                {{ number_format($log->waste_generation, 1) }}
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-200">
                                                {{ number_format($log->carbon_footprint, 2) }} kg CO<sub>2</sub>e
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-200">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('activity-logs.edit', $log) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>

                                                    <form method="POST" action="{{ route('activity-logs.destroy', $log) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this log?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $activityLogs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
