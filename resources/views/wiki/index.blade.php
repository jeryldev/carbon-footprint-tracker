<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Carbon Footprint Tracker Knowledge Base') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-bold text-green-700 mb-4 flex items-center">
                    <span class="text-3xl mr-2">📚</span> Learn about Carbon Footprint Tracking
                </h2>

                <p class="text-gray-700 mb-6">
                    Welcome to our knowledge base! Here you'll find everything you need to understand
                    carbon footprints, how we calculate them, and how your actions can make a difference.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <a href="{{ route('wiki.show', 'about') }}" class="bg-blue-50 p-5 rounded-lg hover:bg-blue-100 transition">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">📋 About This Project</h3>
                        <p class="text-blue-700">Learn about the carbon footprint tracker, why it was created, and the science behind it.</p>
                    </a>

                    <a href="{{ route('wiki.show', 'calculations') }}" class="bg-green-50 p-5 rounded-lg hover:bg-green-100 transition">
                        <h3 class="text-lg font-semibold text-green-800 mb-2">🧮 How We Calculate</h3>
                        <p class="text-green-700">Understand the formulas and science behind our carbon footprint calculations.</p>
                    </a>

                    <a href="{{ route('wiki.show', 'metrics') }}" class="bg-purple-50 p-5 rounded-lg hover:bg-purple-100 transition">
                        <h3 class="text-lg font-semibold text-purple-800 mb-2">📊 Understanding Metrics</h3>
                        <p class="text-purple-700">Learn what tree days, car kilometers, kg ice saved, and hero points mean.</p>
                    </a>

                    <a href="{{ route('wiki.show', 'achievements') }}" class="bg-yellow-50 p-5 rounded-lg hover:bg-yellow-100 transition">
                        <h3 class="text-lg font-semibold text-yellow-800 mb-2">🏆 Achievements Guide</h3>
                        <p class="text-yellow-700">How to earn achievements and badges in the app.</p>
                    </a>

                    <a href="{{ route('wiki.show', 'terminology') }}" class="bg-red-50 p-5 rounded-lg hover:bg-red-100 transition">
                        <h3 class="text-lg font-semibold text-red-800 mb-2">📖 Terminology</h3>
                        <p class="text-red-700">What does kg CO₂e mean? Learn key terms used in carbon tracking.</p>
                    </a>

                    <a href="{{ route('wiki.show', 'research') }}" class="bg-indigo-50 p-5 rounded-lg hover:bg-indigo-100 transition">
                        <h3 class="text-lg font-semibold text-indigo-800 mb-2">🔬 Research & References</h3>
                        <p class="text-indigo-700">The scientific studies and papers that inform our app.</p>
                    </a>
                </div>

                <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">📝 Quick Reference</h3>
                    <ul class="list-disc pl-5 text-gray-700 space-y-1">
                        <li>CO₂e = Carbon dioxide equivalent (a standard unit for measuring carbon footprints)</li>
                        <li>1 tree absorbs about 22kg of CO₂ per year (0.06kg per day)</li>
                        <li>Car emissions average about 0.21kg CO₂ per kilometer</li>
                        <li>1kg of CO₂ saved helps prevent approximately 3kg of arctic ice from melting</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
