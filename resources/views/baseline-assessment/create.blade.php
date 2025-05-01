<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Start Your Planet-Saving Adventure!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="bg-green-50 rounded-lg p-4 mb-6">
                        <h3 class="text-lg font-bold text-green-800 flex items-center mb-2">
                            <span class="text-3xl mr-2">🌎</span> Welcome, Planet Protector!
                        </h3>
                        <p class="text-green-700">
                            Before you start your adventure, we need to learn about your usual daily activities.
                            This will help us measure how much you're helping the planet each day!
                        </p>
                    </div>

                    <form method="POST" action="{{ route('baseline-assessment.store') }}">
                        @csrf

                        <div class="mb-8 bg-blue-50 rounded-lg p-4">
                            <h3 class="text-lg font-bold text-blue-800 flex items-center mb-3">
                                <span class="text-2xl mr-2">🚗</span> How You Get Around
                            </h3>

                            <!-- Transportation Type -->
                            <div class="mt-4">
                                <x-input-label for="typical_commute_type" class="text-base font-medium" :value="__('How do you usually travel every day?')" />

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
                                            <input type="radio" name="typical_commute_type" value="{{ $value }}"
                                                   class="sr-only peer"
                                                   {{ old('typical_commute_type') == $value ? 'checked' : '' }}
                                                   {{ $loop->first ? 'checked' : '' }}>
                                            <div class="flex flex-col items-center justify-center p-4 rounded-lg border-2
                                                        peer-checked:border-blue-500 peer-checked:bg-blue-100 hover:bg-blue-50">
                                                <span class="text-3xl mb-2">{{ $transportIcons[$value] ?? '🚀' }}</span>
                                                <span class="text-sm font-medium">{{ $label }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('typical_commute_type')" class="mt-2" />
                            </div>

                            <!-- Transportation Distance -->
                            <div class="mt-6">
                                <x-input-label for="typical_commute_distance" class="text-base font-medium"
                                              :value="__('How far do you travel on a typical day?')" />
                                <div class="flex items-center mt-1">
                                    <x-text-input id="typical_commute_distance" class="block w-full"
                                                 type="number" name="typical_commute_distance"
                                                 :value="old('typical_commute_distance')" required step="0.1" min="0" />
                                    <span class="ml-2 text-gray-700 font-medium">kilometers</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">
                                    This is how far you usually go in one day (to school and back home, for example).
                                </p>
                                <x-input-error :messages="$errors->get('typical_commute_distance')" class="mt-2" />
                            </div>

                            <!-- Days Per Week -->
                            <div class="mt-6">
                                <x-input-label for="commute_days_per_week" class="text-base font-medium"
                                              :value="__('How many days each week do you travel like this?')" />
                                <select id="commute_days_per_week" name="commute_days_per_week"
                                       class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                                    @for ($i = 0; $i <= 7; $i++)
                                        <option value="{{ $i }}" {{ old('commute_days_per_week', 5) == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ $i == 1 ? 'day' : 'days' }}
                                        </option>
                                    @endfor
                                </select>
                                <p class="text-sm text-gray-500 mt-1">
                                    Most students go to school 5 days a week!
                                </p>
                                <x-input-error :messages="$errors->get('commute_days_per_week')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-8 bg-yellow-50 rounded-lg p-4">
                            <h3 class="text-lg font-bold text-yellow-800 flex items-center mb-3">
                                <span class="text-2xl mr-2">🏠</span> Your Home Energy Use
                            </h3>

                            <!-- Electricity Usage -->
                            <div class="mt-4">
                                <x-input-label for="average_electricity_usage" class="text-base font-medium"
                                              :value="__('How much electricity does your home use each month?')" />
                                <div class="flex items-center mt-1">
                                    <x-text-input id="average_electricity_usage" class="block w-full"
                                                 type="number" name="average_electricity_usage"
                                                 :value="old('average_electricity_usage', 100)" step="1" min="0" />
                                    <span class="ml-2 text-gray-700 font-medium">kWh</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1 flex items-center">
                                    <span class="text-yellow-500 mr-1">💡</span>
                                    If you don't know, leave 100 as a starting point.
                                </p>
                                <x-input-error :messages="$errors->get('average_electricity_usage')" class="mt-2" />
                            </div>

                            <!-- Waste Generation -->
                            <div class="mt-6">
                                <x-input-label for="average_waste_generation" class="text-base font-medium"
                                              :value="__('How much trash does your family make each day?')" />
                                <div class="flex items-center mt-1">
                                    <x-text-input id="average_waste_generation" class="block w-full"
                                                 type="number" name="average_waste_generation"
                                                 :value="old('average_waste_generation', 1)" step="0.1" min="0" />
                                    <span class="ml-2 text-gray-700 font-medium">kilograms</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1 flex items-center">
                                    <span class="text-green-500 mr-1">♻️</span>
                                    A small grocery bag of trash is about 1 kilogram.
                                </p>
                                <x-input-error :messages="$errors->get('average_waste_generation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-10 text-center">
                            <button type="submit" class="py-3 px-8 bg-green-600 text-white font-bold text-lg rounded-full hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition-all flex items-center mx-auto">
                                <span class="mr-2">🚀</span> Start My Planet-Saving Journey!
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
