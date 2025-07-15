<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center px-5 py-2 rounded-xl font-bold text-sm text-white uppercase tracking-wide bg-[#1A1918] hover:bg-[#2C2A27] focus:bg-[#2C2A27] active:bg-[#2C2A27] focus:outline-none focus:ring-1 focus:ring-[#2C2A27] focus:ring-offset-2 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
