@props(['value'])

<label style="text-align: end;background-color:#202021" {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>
