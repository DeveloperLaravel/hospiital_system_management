@props(['href' => null, 'type' => 'button', 'color' => 'blue'])

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "flex items-center gap-1 px-3 py-1 rounded text-white hover:opacity-90 bg-$color-500 transition"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "flex items-center gap-1 px-3 py-1 rounded text-white hover:opacity-90 bg-$color-500 transition"]) }}>
        {{ $slot }}
    </button>
@endif
