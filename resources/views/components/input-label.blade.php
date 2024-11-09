@props(['value'])

<label {{ $attributes->merge(['class' => 'text-left block font-medium text-lg text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
