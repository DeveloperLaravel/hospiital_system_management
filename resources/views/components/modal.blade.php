@props(['maxWidth' => 'lg'])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
@endphp

<div
    x-data="{ show: @entangle($attributes->wire('model')) }"
    x-show="show"
    x-on:keydown.escape.window="show = false"
    class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6"
    style="display:none"
>

    <!-- Backdrop -->
    <div
        x-show="show"
        x-transition.opacity
        class="fixed inset-0 bg-black/50 backdrop-blur-sm"
        wire:click="$set('{{ $attributes->wire('model')->value() }}', false)"
    ></div>

    <!-- Modal -->
    <div
        x-show="show"
        x-transition
        class="bg-white rounded-2xl shadow-2xl w-full {{ $maxWidth }} mx-auto overflow-hidden"
    >

        {{ $slot }}

    </div>

</div>
