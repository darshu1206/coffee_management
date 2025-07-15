@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-sm text-[#FEFEFE]']) }}>
    {{ $value ?? $slot }}
</label>
