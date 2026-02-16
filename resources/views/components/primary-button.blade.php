<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'w-full py-3 px-6 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-bold text-lg rounded-xl shadow-md transition duration-300 ease-in-out flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2'
]) }}>
    {{ $slot }}
</button>