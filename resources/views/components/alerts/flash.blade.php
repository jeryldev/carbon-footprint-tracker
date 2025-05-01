@props(['type' => 'success', 'message'])

@php
    $classes = match ($type) {
        'success' => 'bg-green-100 border-l-4 border-green-500 text-green-700',
        'error' => 'bg-red-100 border-l-4 border-red-500 text-red-700',
        'warning' => 'bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700',
        'info' => 'bg-blue-100 border-l-4 border-blue-500 text-blue-700',
        default => 'bg-green-100 border-l-4 border-green-500 text-green-700',
    };

    $icons = [
        'success' => '🎉',
        'error' => '😮',
        'warning' => '⚠️',
        'info' => 'ℹ️',
    ];
@endphp

<div {{ $attributes->merge(['class' => $classes . ' p-4 rounded-md']) }} role="alert">
    <div class="flex">
        <div class="flex-shrink-0">
            <span class="text-2xl">{{ $icons[$type] ?? '🔔' }}</span>
        </div>
        <div class="ml-3">
            <p class="text-sm">{{ $message }}</p>
        </div>
    </div>
</div>
