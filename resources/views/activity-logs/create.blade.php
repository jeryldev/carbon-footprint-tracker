<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Daily Activity') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('activity-logs.store') }}">
                        @csrf

                        <!-- Date -->
                        <div class="mt-4">
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date', $today)" required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <!-- Transport Type -->
                        <div class="mt-4">
                            <x-input-label for="transport_type" :value="__('Transportation Mode')" />
                            <select id="transport_type" name="transport_type" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                                @foreach($transportTypes as $value => $label)
                                    <option value="{{ $value }}" {{ old('transport_type') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('transport_type')" class="mt-2" />
                        </div>

                        <!-- Transport Distance -->
                        <div class="mt-4">
                            <x-input-label for="transport_distance" :value="__('Distance Traveled (km)')" />
                            <x-text-input id="transport_distance" class="block mt-1 w-full" type="number" name="transport_distance" :value="old('transport_distance')" required step="0.1" min="0" />
                            <x-input-error :messages="$errors->get('transport_distance')" class="mt-2" />
                        </div>

                        <!-- Electricity Usage -->
                        <div class="mt-4">
                            <x-input-label for="electricity_usage" :value="__('Electricity Usage (kWh)')" />
                            <x-text-input id="electricity_usage" class="block mt-1 w-full" type="number" name="electricity_usage" :value="old('electricity_usage')" step="0.1" min="0" />
                            <x-input-error :messages="$errors->get('electricity_usage')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Leave blank if daily usage is unknown.</p>
                        </div>

                        <!-- Waste Generation -->
                        <div class="mt-4">
                            <x-input-label for="waste_generation" :value="__('Waste Generated (kg)')" />
                            <x-text-input id="waste_generation" class="block mt-1 w-full" type="number" name="waste_generation" :value="old('waste_generation')" step="0.1" min="0" />
                            <x-input-error :messages="$errors->get('waste_generation')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Estimate the amount of waste generated today.</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Save Activity Log') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
