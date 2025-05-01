<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Baseline Assessment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('baseline-assessment.store') }}">
                        @csrf

                        <!-- Typical Commute Type -->
                        <div>
                            <x-input-label for="typical_commute_type" :value="__('Typical Mode of Transportation')" />
                            <select id="typical_commute_type" name="typical_commute_type" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                                @foreach($transportTypes as $value => $label)
                                    <option value="{{ $value }}" {{ old('typical_commute_type') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('typical_commute_type')" class="mt-2" />
                        </div>

                        <!-- Typical Commute Distance -->
                        <div class="mt-4">
                            <x-input-label for="typical_commute_distance" :value="__('Typical Distance Traveled (km/day)')" />
                            <x-text-input id="typical_commute_distance" class="block mt-1 w-full" type="number" name="typical_commute_distance" :value="old('typical_commute_distance')" required step="0.1" min="0" />
                            <x-input-error :messages="$errors->get('typical_commute_distance')" class="mt-2" />
                        </div>

                        <!-- Commute Days Per Week -->
                        <div class="mt-4">
                            <x-input-label for="commute_days_per_week" :value="__('Days Per Week')" />
                            <x-text-input id="commute_days_per_week" class="block mt-1 w-full" type="number" name="commute_days_per_week" :value="old('commute_days_per_week', 5)" required min="1" max="7" />
                            <x-input-error :messages="$errors->get('commute_days_per_week')" class="mt-2" />
                        </div>

                        <!-- Average Electricity Usage -->
                        <div class="mt-4">
                            <x-input-label for="average_electricity_usage" :value="__('Average Daily Electricity Usage (kWh)')" />
                            <x-text-input id="average_electricity_usage" class="block mt-1 w-full" type="number" name="average_electricity_usage" :value="old('average_electricity_usage')" step="0.1" min="0" />
                            <x-input-error :messages="$errors->get('average_electricity_usage')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Estimate based on your typical daily usage. Leave blank if unknown.</p>
                        </div>

                        <!-- Average Waste Generation -->
                        <div class="mt-4">
                            <x-input-label for="average_waste_generation" :value="__('Average Daily Waste Generation (kg)')" />
                            <x-text-input id="average_waste_generation" class="block mt-1 w-full" type="number" name="average_waste_generation" :value="old('average_waste_generation')" step="0.1" min="0" />
                            <x-input-error :messages="$errors->get('average_waste_generation')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Estimate the amount of waste you typically generate daily.</p>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button class="ml-4">
                                {{ __('Calculate Baseline') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
