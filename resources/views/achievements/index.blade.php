<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Planet Protector Achievements') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-green-50 to-blue-50 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-center justify-between">
                    <div class="text-center sm:text-left mb-4 sm:mb-0">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">Your Achievement Progress</h3>
                        <p class="text-gray-600">
                            You've unlocked {{ $unlockedCount }} out of {{ $totalCount }} achievements!
                        </p>
                    </div>
                    <div class="bg-purple-100 rounded-lg p-4 text-center">
                        <div class="text-4xl font-bold text-purple-700">{{ $totalPoints }}</div>
                        <div class="text-sm text-purple-600">Hero Points</div>
                    </div>
                </div>

                <div class="mt-4 w-full bg-gray-200 rounded-full h-4">
                    @php
                        $percentComplete = $totalCount > 0 ? ($unlockedCount / $totalCount) * 100 : 0;
                    @endphp
                    <div class="bg-green-600 h-4 rounded-full" style="width: {{ $percentComplete }}%"></div>
                </div>
                <div class="text-center mt-2 text-sm text-gray-600">{{ round($percentComplete) }}% Complete</div>
            </div>

            @forelse($achievements as $type => $achievementGroup)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            @if($type == 'activity')
                                <span class="text-2xl mr-2">📝</span> Activity Achievements
                            @elseif($type == 'transport')
                                <span class="text-2xl mr-2">🚲</span> Transportation Achievements
                            @elseif($type == 'emission')
                                <span class="text-2xl mr-2">🌿</span> Carbon Saving Achievements
                            @else
                                <span class="text-2xl mr-2">🏆</span> {{ ucfirst($type) }} Achievements
                            @endif
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($achievementGroup as $achievement)
                                <div class="border rounded-lg p-4 {{ $achievement->is_unlocked ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                                    <div class="flex items-start">
                                        <div class="text-3xl mr-3 {{ $achievement->is_unlocked ? '' : 'opacity-40' }}">
                                            {{ $achievement->icon }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">{{ $achievement->name }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">{{ $achievement->description }}</p>

                                            @if($achievement->is_unlocked)
                                                <div class="mt-2 flex items-center">
                                                    <span class="text-green-600 text-sm font-medium flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        Unlocked on {{ $achievement->unlocked_at->format('M j, Y') }}
                                                    </span>
                                                </div>
                                                <div class="mt-1 text-sm text-purple-600 font-medium">
                                                    +{{ $achievement->points }} points
                                                </div>
                                            @else
                                                <div class="mt-2 text-sm text-gray-500">
                                                    Keep going! +{{ $achievement->points }} points when unlocked
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 text-center">
                        <div class="text-6xl mb-4">🏆</div>
                        <p class="text-gray-600">No achievements available yet. Start your planet-saving journey!</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
