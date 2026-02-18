<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 {{ $class ?? '' }}">
        <thead class="bg-gray-50">
            {{ $thead }}
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            {{ $slot }}
        </tbody>
    </table>
</div>
