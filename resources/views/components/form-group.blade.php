<div {{ $attributes->merge(['class' => 'space-y-1']) }}>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-100">{{ $label ?? '' }}</label>
    {{ $slot }}
</div>