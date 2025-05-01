<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ucfirst($topic) }} | Carbon Footprint Tracker Knowledge Base
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 mb-6">
                @switch($topic)
                    @case('about')
                        <h2 class="text-2xl font-bold text-green-700 mb-6">About This Carbon Footprint Tracker</h2>
                        <div class="space-y-6 text-gray-700 leading-relaxed">
                            <p class="text-lg">
                                This app was created as part of CMSC 207 - Web Programming and Development at the University of the Philippines Open University,
                                responding to the Chancellor's emphasis on sustainability initiatives.
                            </p>

                            <p class="text-lg">
                                The Carbon Footprint Tracker helps users understand, measure, and reduce their carbon
                                footprint through gamification, awareness, and actionable recommendations.
                            </p>

                            <div class="bg-green-50 p-6 rounded-lg my-8">
                                <h3 class="text-xl font-bold text-green-800 mb-3">Our Vision</h3>
                                <p class="text-green-700 text-lg italic">
                                    A world where individuals understand their environmental impact and are empowered
                                    to make sustainable choices daily.
                                </p>
                            </div>

                            <div class="bg-blue-50 p-6 rounded-lg my-8">
                                <h3 class="text-xl font-bold text-blue-800 mb-3">Our Mission</h3>
                                <p class="text-blue-700 text-lg italic">
                                    To transform carbon footprint tracking from a complex calculation into an engaging
                                    daily habit that fosters sustainable lifestyle changes.
                                </p>
                            </div>

                            <div class="mt-10">
                                <h3 class="text-xl font-bold text-gray-800 mb-4">Scientific Foundation</h3>
                                <p class="mb-4">
                                    All calculations in this application are based on scientific research from:
                                </p>
                                <blockquote class="border-l-4 border-gray-300 pl-4 py-2 my-4 italic text-gray-600">
                                    Cortes, A. C. (2022). Greenhouse Gas Emissions Inventory of a University in the Philippines: the case of UP Cebu.
                                    <span class="font-semibold">Philippine Journal of Science</span>, 151(3), 901-912.
                                </blockquote>

                                <a href="https://philjournalsci.dost.gov.ph/images/pdf/pjs_pdf/vol151no3/greenhouse_gas_emissions_inventory_in_UP_Cebu_.pdf"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md mt-3 hover:bg-blue-700 transition"
                                   target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    Read the full research paper
                                </a>
                            </div>
                        </div>
                        @break

                    @case('calculations')
                        <h2 class="text-2xl font-bold text-green-700 mb-6">How We Calculate Carbon Footprints</h2>
                        <div class="space-y-6 text-gray-700 leading-relaxed">
                            <p class="text-lg">
                                Our carbon footprint calculations are based on the methodology outlined in the research
                                by Aiza C. Cortes at the University of the Philippines Cebu.
                            </p>

                            <div class="bg-gray-50 p-6 rounded-lg my-8 border border-gray-200">
                                <h3 class="text-xl font-bold text-gray-800 mb-4">Basic Formula</h3>
                                <div class="bg-white p-4 rounded border border-gray-300 text-center font-mono text-lg my-4">
                                    CE = AD × EF × GWP₁₀₀
                                </div>
                                <p class="mb-4">Where:</p>
                                <ul class="list-disc pl-8 space-y-2">
                                    <li><strong class="font-semibold">CE</strong> is carbon emission in kg CO₂e</li>
                                    <li><strong class="font-semibold">AD</strong> is the activity data (distance traveled, electricity used, etc.)</li>
                                    <li><strong class="font-semibold">EF</strong> is the emission factor for that activity</li>
                                    <li><strong class="font-semibold">GWP₁₀₀</strong> is the global warming potential over 100 years</li>
                                </ul>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-10">
                                <div class="bg-blue-50 p-6 rounded-lg">
                                    <h3 class="text-xl font-bold text-blue-800 mb-4 flex items-center">
                                        <span class="text-2xl mr-2">🚗</span> Transportation
                                    </h3>
                                    <p class="mb-3 text-blue-700">Emission factors by mode:</p>
                                    <ul class="list-disc pl-6 space-y-2 text-blue-600">
                                        <li>Walking/Cycling: <span class="font-mono">0 kg CO₂/km</span></li>
                                        <li>Motorcycle: <span class="font-mono">0.1174424 kg CO₂/km</span></li>
                                        <li>Car: <span class="font-mono">0.2118934 kg CO₂/km</span></li>
                                        <li>Public transit: <span class="font-mono">0.2883241 kg CO₂/km</span></li>
                                    </ul>
                                </div>

                                <div class="bg-yellow-50 p-6 rounded-lg">
                                    <h3 class="text-xl font-bold text-yellow-800 mb-4 flex items-center">
                                        <span class="text-2xl mr-2">💡</span> Electricity
                                    </h3>
                                    <p class="mb-3 text-yellow-700">Grid emissions factor:</p>
                                    <p class="font-mono text-yellow-600 mb-2">0.5070 kg CO₂/kWh</p>
                                    <p class="text-yellow-700 text-sm">(Based on the Visayas grid in the Philippines)</p>
                                </div>

                                <div class="bg-green-50 p-6 rounded-lg">
                                    <h3 class="text-xl font-bold text-green-800 mb-4 flex items-center">
                                        <span class="text-2xl mr-2">♻️</span> Waste
                                    </h3>
                                    <p class="mb-3 text-green-700">General waste factor:</p>
                                    <p class="font-mono text-green-600">1.84 kg CO₂/kg waste</p>
                                </div>
                            </div>

                            <div class="bg-indigo-50 p-6 rounded-lg my-8">
                                <h3 class="text-xl font-bold text-indigo-800 mb-4">Baseline Calculation</h3>
                                <p class="text-indigo-700 mb-4">
                                    Your baseline is calculated using your typical habits over a full year:
                                </p>
                                <ul class="list-disc pl-8 space-y-3 text-indigo-600">
                                    <li>
                                        <span class="font-semibold">Transportation:</span>
                                        Daily commute distance × 2 (round trip) × days per week × 52 weeks
                                    </li>
                                    <li>
                                        <span class="font-semibold">Electricity:</span>
                                        Monthly average × 12 months
                                    </li>
                                    <li>
                                        <span class="font-semibold">Waste:</span>
                                        Daily average × 365 days
                                    </li>
                                </ul>
                                <p class="mt-4 text-indigo-700 font-medium">
                                    The total is your yearly carbon footprint baseline in kg CO₂e.
                                </p>
                            </div>

                            <div class="bg-purple-50 p-6 rounded-lg my-8">
                                <h3 class="text-xl font-bold text-purple-800 mb-4">Carbon Savings Calculation</h3>
                                <p class="text-purple-700 mb-4">
                                    When you log activities, we compare your actual emissions to your baseline to calculate savings:
                                </p>
                                <ol class="list-decimal pl-8 space-y-3 text-purple-600">
                                    <li>Divide your yearly baseline by 365 to get your daily baseline</li>
                                    <li>Calculate your actual emissions for the day</li>
                                    <li>Subtract actual emissions from baseline to get savings</li>
                                </ol>
                                <div class="bg-white p-4 rounded mt-4 border border-purple-200">
                                    <p class="text-purple-700 font-medium">
                                        Positive savings mean you're reducing your carbon footprint compared to your typical habits!
                                    </p>
                                </div>
                            </div>
                        </div>
                        @break

                    @case('metrics')
                        <h2 class="text-2xl font-bold text-green-700 mb-4">Understanding Metrics</h2>
                        <div class="space-y-6 text-gray-700 leading-relaxed">
                            <p class="text-lg">
                                Our app shows your carbon impact using several different metrics to help make abstract CO₂ numbers more relatable and meaningful.
                            </p>

                            <div class="bg-green-50 p-4 rounded-lg mb-4">
                                <h3 class="flex items-center text-green-800">
                                    <span class="text-2xl mr-2">🌳</span> Tree Days
                                </h3>
                                <p class="text-green-700">
                                    A "Tree Day" represents one day of a tree absorbing CO₂. An average tree absorbs about 22kg of CO₂ per year, or approximately 0.06kg per day.
                                </p>
                                <p class="text-green-700 mt-2">
                                    When you save 0.06kg of CO₂, that's equivalent to what one tree would absorb in a day. For example, saving 0.6kg of CO₂ equals 10 tree days.
                                </p>
                                <p class="text-green-700 mt-2">
                                    <strong>Formula:</strong> Tree Days = CO₂ saved (kg) ÷ 0.06
                                </p>
                            </div>

                            <div class="bg-blue-50 p-4 rounded-lg mb-4">
                                <h3 class="flex items-center text-blue-800">
                                    <span class="text-2xl mr-2">🚗</span> Car Kilometers
                                </h3>
                                <p class="text-blue-700">
                                    "Car Kilometers" shows how many kilometers of car driving you've avoided by making eco-friendly choices.
                                </p>
                                <p class="text-blue-700 mt-2">
                                    Based on the emission factor of 0.2118934 kg CO₂ per kilometer for an average car, we calculate how far a car would need to drive to emit the same amount of CO₂ that you saved.
                                </p>
                                <p class="text-blue-700 mt-2">
                                    <strong>Formula:</strong> Car Kilometers = CO₂ saved (kg) ÷ 0.2118934
                                </p>
                            </div>

                            <div class="bg-cyan-50 p-4 rounded-lg mb-4">
                                <h3 class="flex items-center text-cyan-800">
                                    <span class="text-2xl mr-2">❄️</span> kg Ice Saved
                                </h3>
                                <p class="text-cyan-700">
                                    "kg Ice Saved" represents the amount of Arctic ice that won't melt thanks to your reduced carbon emissions.
                                </p>
                                <p class="text-cyan-700 mt-2">
                                    Research suggests that for every kg of CO₂ emissions, approximately 3kg of Arctic ice melts over time due to the warming effect.
                                </p>
                                <p class="text-cyan-700 mt-2">
                                    <strong>Formula:</strong> kg Ice Saved = CO₂ saved (kg) × 3
                                </p>
                            </div>

                            <div class="bg-purple-50 p-4 rounded-lg mb-4">
                                <h3 class="flex items-center text-purple-800">
                                    <span class="text-2xl mr-2">⚡</span> Hero Points
                                </h3>
                                <p class="text-purple-700">
                                    "Hero Points" are the gamification element of our app, rewarding you for environmental achievements and carbon savings.
                                </p>
                                <p class="text-purple-700 mt-2">
                                    You earn points by unlocking achievements and by consistently saving carbon compared to your baseline.
                                </p>
                                <p class="text-purple-700 mt-2">
                                    <strong>Formula:</strong> For carbon savings: Hero Points = CO₂ saved (kg) × 10
                                </p>
                                <p class="text-purple-700">
                                    Each achievement also awards specific point values (e.g., 50 points for Carbon Crusher badge).
                                </p>
                            </div>
                        </div>
                        @break

                    @case('achievements')
                        <h2 class="text-2xl font-bold text-green-700 mb-6">Achievements Guide</h2>
                        <div class="space-y-6 text-gray-700 leading-relaxed">
                            <p class="text-lg">
                                Our app includes a gamified achievement system to keep you motivated on your journey to
                                reduce your carbon footprint. Earn badges and points as you make eco-friendly choices!
                            </p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-8">
                                <div class="bg-green-50 p-6 rounded-lg border border-green-100 flex">
                                    <div class="flex-shrink-0 flex items-center bg-white rounded-full p-3 mr-4 shadow-sm">
                                        <span class="text-3xl">🌱</span>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-green-800 mb-2">Planet Protector Rookie</h3>
                                        <p class="text-green-700 mb-2">Log your first activity in the app.</p>
                                        <p class="text-green-600 text-sm mb-3">This is the easiest achievement to unlock - just start tracking!</p>
                                        <div class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full inline-block font-medium">
                                            +10 Hero Points
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 flex">
                                    <div class="flex-shrink-0 flex items-center bg-white rounded-full p-3 mr-4 shadow-sm">
                                        <span class="text-3xl">🛡️</span>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-blue-800 mb-2">Eco Warrior</h3>
                                        <p class="text-blue-700 mb-2">Log activities for 7 days in a row.</p>
                                        <p class="text-blue-600 text-sm mb-3">Consistency is key! Track your carbon footprint daily for a full week.</p>
                                        <div class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full inline-block font-medium">
                                            +50 Hero Points
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-100 flex">
                                    <div class="flex-shrink-0 flex items-center bg-white rounded-full p-3 mr-4 shadow-sm">
                                        <span class="text-3xl">🏆</span>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-yellow-800 mb-2">Climate Champion</h3>
                                        <p class="text-yellow-700 mb-2">Log activities for 30 days in a row.</p>
                                        <p class="text-yellow-600 text-sm mb-3">Demonstrate your commitment by tracking consistently for a full month.</p>
                                        <div class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full inline-block font-medium">
                                            +200 Hero Points
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-6 rounded-lg border border-gray-100 flex">
                                    <div class="flex-shrink-0 flex items-center bg-white rounded-full p-3 mr-4 shadow-sm">
                                        <span class="text-3xl">🚶</span>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800 mb-2">Walking Wonder</h3>
                                        <p class="text-gray-700 mb-2">Choose walking as your transportation mode 10 times.</p>
                                        <p class="text-gray-600 text-sm mb-3">Walking produces zero carbon emissions and is great for your health too!</p>
                                        <div class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full inline-block font-medium">
                                            +50 Hero Points
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-indigo-50 p-6 rounded-lg border border-indigo-100 flex">
                                    <div class="flex-shrink-0 flex items-center bg-white rounded-full p-3 mr-4 shadow-sm">
                                        <span class="text-3xl">🚲</span>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-indigo-800 mb-2">Cycling Star</h3>
                                        <p class="text-indigo-700 mb-2">Choose bicycling as your transportation mode 10 times.</p>
                                        <p class="text-indigo-600 text-sm mb-3">Like walking, cycling produces zero emissions while helping you stay fit.</p>
                                        <div class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full inline-block font-medium">
                                            +50 Hero Points
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-amber-50 p-6 rounded-lg border border-amber-100 flex">
                                    <div class="flex-shrink-0 flex items-center bg-white rounded-full p-3 mr-4 shadow-sm">
                                        <span class="text-3xl">🌟</span>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-amber-800 mb-2">Carbon Crusher</h3>
                                        <p class="text-amber-700 mb-2">Save 50kg of CO₂ emissions compared to your baseline.</p>
                                        <p class="text-amber-600 text-sm mb-3">This significant milestone shows real environmental impact!</p>
                                        <div class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full inline-block font-medium">
                                            +100 Hero Points
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-emerald-50 p-6 rounded-lg border border-emerald-100 flex">
                                    <div class="flex-shrink-0 flex items-center bg-white rounded-full p-3 mr-4 shadow-sm">
                                        <span class="text-3xl">🌳</span>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-emerald-800 mb-2">Tree Guardian</h3>
                                        <p class="text-emerald-700 mb-2">Save the equivalent of 100 tree days by reducing your carbon footprint.</p>
                                        <p class="text-emerald-600 text-sm mb-3">That's like having 100 trees working for a day to absorb CO₂!</p>
                                        <div class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full inline-block font-medium">
                                            +150 Hero Points
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-blue-50 p-6 rounded-lg mt-10">
                                <h3 class="text-xl font-bold text-blue-800 mb-4">Tips for Earning Achievements</h3>
                                <ul class="list-disc pl-8 space-y-3 text-blue-700">
                                    <li>Log your activities consistently every day</li>
                                    <li>Choose walking or cycling whenever possible</li>
                                    <li>Use public transportation instead of private cars when available</li>
                                    <li>Reduce waste generation and electricity usage</li>
                                    <li>Compare your current activities to your baseline to see where you can improve</li>
                                </ul>
                            </div>
                        </div>
                        @break

                    @case('terminology')
                        <h2 class="text-2xl font-bold text-green-700 mb-4">Carbon Footprint Terminology</h2>
                        <div class="space-y-6 text-gray-700 leading-relaxed">
                            <p class="text-lg">
                                Understanding the terminology used in carbon footprint tracking can help you better interpret your impact and make informed choices.
                            </p>

                            <dl class="mt-6 space-y-6 divide-y divide-gray-200">
                                <div class="pt-6 md:grid md:grid-cols-12 md:gap-8">
                                    <dt class="text-base font-medium text-gray-900 md:col-span-5">Carbon Dioxide Equivalent (CO₂e)</dt>
                                    <dd class="mt-2 md:mt-0 md:col-span-7">
                                        <p class="text-base text-gray-700">
                                            A standard unit for measuring carbon footprints that includes all greenhouse gases converted to the equivalent amount of CO₂. This allows for a single "carbon footprint" value that includes the impact of different gases like methane and nitrous oxide.
                                        </p>
                                    </dd>
                                </div>

                                <div class="pt-6 md:grid md:grid-cols-12 md:gap-8">
                                    <dt class="text-base font-medium text-gray-900 md:col-span-5">Kilogram (kg) CO₂e</dt>
                                    <dd class="mt-2 md:mt-0 md:col-span-7">
                                        <p class="text-base text-gray-700">
                                            The standard measurement unit used in our app. One kilogram of CO₂ is the amount produced by burning approximately 0.5 liters of gasoline.
                                        </p>
                                    </dd>
                                </div>

                                <div class="pt-6 md:grid md:grid-cols-12 md:gap-8">
                                    <dt class="text-base font-medium text-gray-900 md:col-span-5">Carbon Footprint</dt>
                                    <dd class="mt-2 md:mt-0 md:col-span-7">
                                        <p class="text-base text-gray-700">
                                            The total amount of greenhouse gases (including carbon dioxide and methane) that are generated by our actions. The average person in the Philippines has a carbon footprint of about 1.23 tons CO₂e per year.
                                        </p>
                                    </dd>
                                </div>

                                <div class="pt-6 md:grid md:grid-cols-12 md:gap-8">
                                    <dt class="text-base font-medium text-gray-900 md:col-span-5">Baseline</dt>
                                    <dd class="mt-2 md:mt-0 md:col-span-7">
                                        <p class="text-base text-gray-700">
                                            Your personal reference point calculated from your typical habits. This represents what your carbon footprint would be if you continued your normal routine. We compare your daily activities to this baseline to measure improvement.
                                        </p>
                                    </dd>
                                </div>

                                <div class="pt-6 md:grid md:grid-cols-12 md:gap-8">
                                    <dt class="text-base font-medium text-gray-900 md:col-span-5">Emission Factor (EF)</dt>
                                    <dd class="mt-2 md:mt-0 md:col-span-7">
                                        <p class="text-base text-gray-700">
                                            A coefficient that converts activity data (like kilometers driven) into the amount of greenhouse gas emissions produced. Different activities and transportation modes have different emission factors.
                                        </p>
                                    </dd>
                                </div>

                                <div class="pt-6 md:grid md:grid-cols-12 md:gap-8">
                                    <dt class="text-base font-medium text-gray-900 md:col-span-5">Carbon Neutral/Net Zero</dt>
                                    <dd class="mt-2 md:mt-0 md:col-span-7">
                                        <p class="text-base text-gray-700">
                                            Achieving a balance between emitting carbon and absorbing carbon from the atmosphere. The ultimate goal is to have no net effect on the concentration of greenhouse gases in the atmosphere.
                                        </p>
                                    </dd>
                                </div>

                                <div class="pt-6 md:grid md:grid-cols-12 md:gap-8">
                                    <dt class="text-base font-medium text-gray-900 md:col-span-5">Carbon Sequestration</dt>
                                    <dd class="mt-2 md:mt-0 md:col-span-7">
                                        <p class="text-base text-gray-700">
                                            The process of capturing and storing atmospheric carbon dioxide, often by trees and plants through photosynthesis. This is why trees are so important for fighting climate change.
                                        </p>
                                    </dd>
                                </div>

                                <div class="pt-6 md:grid md:grid-cols-12 md:gap-8">
                                    <dt class="text-base font-medium text-gray-900 md:col-span-5">Global Warming Potential (GWP)</dt>
                                    <dd class="mt-2 md:mt-0 md:col-span-7">
                                        <p class="text-base text-gray-700">
                                            A measure of how much heat a greenhouse gas traps in the atmosphere over a specific time period, relative to carbon dioxide. For example, methane has a GWP of 28-36 over 100 years, meaning it's 28-36 times more potent than CO₂.
                                        </p>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                        @break

                    @case('research')
                        <h2 class="text-2xl font-bold text-green-700 mb-6">Research & References</h2>
                        <div class="space-y-6 text-gray-700 leading-relaxed">
                            <p class="text-lg">
                                This Carbon Footprint Tracker is built on scientific research and established methodologies.
                                Here are the key references that inform our calculations and approach:
                            </p>

                            <div class="bg-amber-50 p-6 rounded-lg my-8 border border-amber-100">
                                <h3 class="text-xl font-bold text-amber-800 mb-3">Primary Research</h3>

                                <div class="bg-white p-4 rounded-lg border border-amber-200 mb-4">
                                    <h4 class="font-bold text-amber-800 text-lg">
                                        Greenhouse Gas Emissions Inventory of a University in the Philippines
                                    </h4>
                                    <p class="italic text-amber-700 mb-3">
                                        Aiza C. Cortes, Philippine Journal of Science, 151(3), 901-912, June 2022
                                    </p>
                                    <p class="text-amber-700">
                                        This study forms the foundation of our carbon calculation methodology. It provides emission
                                        factors specific to the Philippines context and outlines the framework for estimating
                                        carbon emissions from various activities.
                                    </p>
                                    <div class="mt-4">
                                        <a href="https://philjournalsci.dost.gov.ph/images/pdf/pjs_pdf/vol151no3/greenhouse_gas_emissions_inventory_in_UP_Cebu_.pdf"
                                           class="inline-flex items-center text-blue-600 hover:text-blue-800"
                                           target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                            Read the full paper
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-blue-50 p-6 rounded-lg my-8">
                                <h3 class="text-xl font-bold text-blue-800 mb-4">Key Findings from the Research</h3>
                                <ul class="list-disc pl-8 space-y-3 text-blue-700">
                                    <li>Transportation is the highest contributor to carbon emissions in university settings (47.2% of total emissions)</li>
                                    <li>Student mobility alone accounted for 717.5 tCO₂e out of a total 1,520.6 tCO₂e</li>
                                    <li>The average carbon footprint per capita was 1.1 tCO₂e/year</li>
                                    <li>Simple mitigation strategies like shifting to solar energy, reducing travel, and recycling waste can significantly reduce emissions</li>
                                </ul>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-10">
                                <div class="bg-green-50 p-6 rounded-lg">
                                    <h3 class="text-lg font-bold text-green-800 mb-3 flex items-center">
                                        <span class="text-2xl mr-2">🚗</span> Transportation
                                    </h3>
                                    <ul class="list-disc pl-6 space-y-2 text-green-700">
                                        <li class="font-mono text-sm">Walking/Cycling: 0 kg CO₂/km</li>
                                        <li class="font-mono text-sm">Motorcycle: 0.1174424 kg CO₂/km</li>
                                        <li class="font-mono text-sm">Car: 0.2118934 kg CO₂/km</li>
                                        <li class="font-mono text-sm">Public transit: 0.2883241 kg CO₂/km</li>
                                    </ul>
                                </div>

                                <div class="bg-yellow-50 p-6 rounded-lg">
                                    <h3 class="text-lg font-bold text-yellow-800 mb-3 flex items-center">
                                        <span class="text-2xl mr-2">💡</span> Electricity
                                    </h3>
                                    <ul class="list-disc pl-6 space-y-2 text-yellow-700">
                                        <li class="font-mono text-sm">Grid (Visayas): 0.5070 kg CO₂/kWh</li>
                                    </ul>
                                </div>

                                <div class="bg-red-50 p-6 rounded-lg">
                                    <h3 class="text-lg font-bold text-red-800 mb-3 flex items-center">
                                        <span class="text-2xl mr-2">🗑️</span> Waste
                                    </h3>
                                    <ul class="list-disc pl-6 space-y-2 text-red-700">
                                        <li class="font-mono text-sm">General waste: 1.84 kg CO₂/kg waste</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="bg-purple-50 p-6 rounded-lg my-8">
                                <h3 class="text-xl font-bold text-purple-800 mb-4">Additional References</h3>
                                <ol class="list-decimal pl-8 space-y-4 text-purple-700">
                                    <li>
                                        <span class="font-bold block">IPCC Fifth Assessment Report (2014)</span>
                                        Used for Global Warming Potential (GWP) values for converting various greenhouse gases to CO₂ equivalents.
                                    </li>
                                    <li>
                                        <span class="font-bold block">Philippine Climate Change Commission Guidelines</span>
                                        Provides frameworks for greenhouse gas inventory at various scales.
                                    </li>
                                    <li>
                                        <span class="font-bold block">United States Environmental Protection Agency (US EPA)</span>
                                        Supplementary emission factors for transportation and other activities.
                                    </li>
                                </ol>
                            </div>

                            <div class="bg-indigo-50 p-6 rounded-lg my-8">
                                <h3 class="text-xl font-bold text-indigo-800 mb-4">Calculation Methodology</h3>
                                <p class="text-indigo-700 mb-4">Our application follows the basic equation from the IPCC guidelines, as used in the Cortes study:</p>
                                <div class="bg-white p-4 rounded text-center font-mono text-xl my-6 border border-indigo-200">
                                    CE = AD × EF × GWP₁₀₀
                                </div>
                                <p class="text-indigo-700">Where CE is carbon emission, AD is activity data, EF is emission factor, and GWP₁₀₀ is global warming potential.</p>
                            </div>

                            <div class="text-gray-600 border-t border-gray-200 pt-6 mt-8 bg-gray-50 p-4 rounded-lg">
                                <p class="mb-2">
                                    <span class="font-semibold">Developer Information:</span> This Carbon Footprint Tracker was created by Jeryl Estopace as a final project for CMSC 207 - Web Programming and Development at the University of the Philippines Open University.
                                </p>
                                <p>
                                    For suggestions on improving this app or questions about the methodology, please contact
                                    <a href="https://www.linkedin.com/in/jeryldev/" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                        Jeryl Estopace
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                        </svg>
                                    </a>
                                </p>
                            </div>
                        </div>
                        @break

                    @default
                        <div class="text-center py-12">
                            <div class="text-6xl mb-6">🏗️</div>
                            <h2 class="text-2xl font-bold text-gray-700 mb-4">This page is under construction!</h2>
                            <p class="text-gray-600 mb-8">We're still working on the "{{ $topic }}" knowledge base article.</p>
                            <a href="{{ route('wiki.index') }}"
                               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Knowledge Base
                            </a>
                        </div>
                @endswitch

                <div class="mt-10 pt-6 border-t border-gray-200">
                    <a href="{{ route('wiki.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Knowledge Base
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
