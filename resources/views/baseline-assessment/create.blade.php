<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Baseline Carbon Assessment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">
                        To calculate your baseline carbon footprint, please provide some information about your typical activities.
                        This will help us track your progress towards reducing your environmental impact.
                    </p>

                    <form method="POST" action="{{ route('baseline-assessment.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div class="max-w-xl">
                            <!-- Transportation Section -->
                            <div class="border-b border-gray-200 pb-6 mb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Transportation</h3>

                                <!-- Commute Type -->
                                <div class="mt-4">
                                    <x-input-label for="typical_commute_type" :value="__('Primary mode of transportation')" />
                                    <select id="typical_commute_type" name="typical_commute_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="">Select transportation type</option>
                                        @foreach($transportTypes as $value => $label)
                                            <option value="{{ $value }}" {{ old('typical_commute_type', $assessment->typical_commute_type) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('typical_commute_type')" />
                                </div>

                                <!-- Commute Distance -->
                                <div class="mt-4">
                                    <x-input-label for="typical_commute_distance" :value="__('One-way commute distance (km)')" />
                                    <x-text-input id="typical_commute_distance" name="typical_commute_distance" type="number" step="0.1" min="0" class="mt-1 block w-full" :value="old('typical_commute_distance', $assessment->typical_commute_distance)" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('typical_commute_distance')" />
                                </div>

                                <!-- Commute Days -->
                                <div class="mt-4">
                                    <x-input-label for="commute_days_per_week" :value="__('How many days per week do you commute?')" />
                                    <x-text-input id="commute_days_per_week" name="commute_days_per_week" type="number" min="0" max="7" class="mt-1 block w-full" :value="old('commute_days_per_week', $assessment->commute_days_per_week)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('commute_days_per_week')" />
                                </div>
                            </div>

                            <!-- Energy Usage Section -->
                            <div class="border-b border-gray-200 pb-6 mb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Energy Usage</h3>

                                <!-- Electricity Usage -->
                                <div class="mt-4">
                                    <x-input-label for="average_electricity_usage" :value="__('Average monthly electricity usage (kWh)')" />
                                    <x-text-input id="average_electricity_usage" name="average_electricity_usage" type="number" step="0.1" min="0" class="mt-1 block w-full" :value="old('average_electricity_usage', $assessment->average_electricity_usage)" required />
                                    <p class="text-sm text-gray-500 mt-1">You can find this on your electricity bill.</p>
                                    <x-input-error class="mt-2" :messages="$errors->get('average_electricity_usage')" />
                                </div>
                            </div>

                            <!-- Waste Generation Section -->
                            <div class="pb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Waste</h3>

                                <!-- Waste Generation -->
                                <div class="mt-4">
                                    <x-input-label for="average_waste_generation" :value="__('Average daily waste generation (kg)')" />
                                    <x-text-input id="average_waste_generation" name="average_waste_generation" type="number" step="0.1" min="0" class="mt-1 block w-full" :value="old('average_waste_generation', $assessment->average_waste_generation)" required />
                                    <p class="text-sm text-gray-500 mt-1">Estimate how much waste you typically generate daily.</p>
                                    <x-input-error class="mt-2" :messages="$errors->get('average_waste_generation')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save Assessment') }}</x-primary-button>

                            @if (session('status') === 'baseline-saved')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
