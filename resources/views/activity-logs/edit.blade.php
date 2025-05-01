<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update My Planet-Saving Activity') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6 bg-blue-50 rounded-lg p-4">
                        <p class="text-blue-700 flex items-center">
                            <span class="text-xl mr-2">📅</span>
                            Updating your activity for <strong class="ml-1">{{ $activityLog->date->format('F j, Y') }}</strong>
                        </p>
                    </div>

                    <form method="POST" action="{{ route('activity-logs.update', $activityLog) }}">
                        @csrf
                        @method('PUT')

                        <!-- Transport Type -->
                        <div class="mt-4">
                            <x-input-label for="transport_type" class="text-lg" :value="__('How did you get around?')" />

                            <div class="mt-3 grid grid-cols-2 md:grid-cols-5 gap-3">
                                @php
                                    $transportIcons = [
                                        'walk' => '🚶',
                                        'bicycle' => '🚲',
                                        'motorcycle' => '🏍️',
                                        'car' => '🚗',
                                        'public_transit' => '🚌'
                                    ];
                                @endphp

                                @foreach($transportTypes as $value => $label)
                                    <label class="transport-option relative cursor-pointer">
                                        <input type="radio" name="transport_type" value="{{ $value }}"
                                               class="sr-only peer"
                                               {{ old('transport_type', $activityLog->transport_type) == $value ? 'checked' : '' }}>
                                        <div class="flex flex-col items-center justify-center p-4 rounded-lg border-2
                                                    peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50">
                                            <span class="text-3xl mb-2">{{ $transportIcons[$value] ?? '🚀' }}</span>
                                            <span class="text-sm font-medium">{{ $label }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('transport_type')" class="mt-2" />
                        </div>

                        <!-- Transport Distance -->
                        <div class="mt-6">
                            <x-input-label for="transport_distance" class="text-base" :value="__('How far did you travel?')" />
                            <div class="flex items-center mt-1">
                                <x-text-input id="transport_distance" class="block w-full" type="number" name="transport_distance" :value="old('transport_distance', $activityLog->transport_distance)" required step="0.1" min="0" />
                                <span class="ml-2 text-gray-700 font-medium">kilometers</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">This is the total distance you traveled on this day.</p>
                            <x-input-error :messages="$errors->get('transport_distance')" class="mt-2" />
                        </div>

                        <div class="mt-10 border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
                                <span class="text-xl mr-2">🏠</span> At Home Activities
                            </h3>

                            <!-- Electricity Usage -->
                            <div class="mt-4">
                                <x-input-label for="electricity_usage" class="text-base" :value="__('How much electricity did you use?')" />
                                <div class="flex items-center mt-1">
                                    <x-text-input id="electricity_usage" class="block w-full" type="number" name="electricity_usage" :value="old('electricity_usage', $activityLog->electricity_usage)" step="0.1" min="0" />
                                    <span class="ml-2 text-gray-700 font-medium">kWh</span>
                                </div>
                                <div class="flex items-center mt-1 text-sm text-gray-500">
                                    <span class="text-yellow-500 mr-1">💡</span>
                                    Leave at 0 if you're not sure how much you used.
                                </div>
                                <x-input-error :messages="$errors->get('electricity_usage')" class="mt-2" />
                            </div>

                            <!-- Waste Generation -->
                            <div class="mt-6">
                                <x-input-label for="waste_generation" class="text-base" :value="__('How much trash did you make?')" />
                                <div class="flex items-center mt-1">
                                    <x-text-input id="waste_generation" class="block w-full" type="number" name="waste_generation" :value="old('waste_generation', $activityLog->waste_generation)" step="0.1" min="0" />
                                    <span class="ml-2 text-gray-700 font-medium">kilograms</span>
                                </div>
                                <div class="flex items-center mt-1 text-sm text-gray-500">
                                    <span class="text-green-500 mr-1">♻️</span>
                                    A small grocery bag of trash is about 1 kilogram.
                                </div>
                                <x-input-error :messages="$errors->get('waste_generation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-10 flex items-center justify-between">
                            <a href="{{ route('activity-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                                <span class="mr-1">←</span> Back to List
                            </a>

                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-full font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                <span class="mr-1">✨</span> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
