@props(['value', 'hint' => null])

<div class="flex flex-col sm:flex-row items-start">
    <label {{ $attributes->merge(['class' => 'block font-medium text-sm']) }}>
        {{ $value ?? $slot }}
    </label>

    @if (isset($hint))
        <div class="hidden sm:block ml-auto rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 mr-1">{{ $hint }}</div>
    @endif
</div>
