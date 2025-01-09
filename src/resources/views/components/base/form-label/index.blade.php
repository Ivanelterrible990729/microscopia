@props(['hint' => null])
@aware(['class' => null])

<div class="flex flex-col sm:flex-row items-start">
    <label
        data-tw-merge
        {{ $attributes->class([
            'inline-block mb-2',
            'group-[.form-inline]:mb-2 group-[.form-inline]:sm:mb-0 group-[.form-inline]:sm:mr-5 group-[.form-inline]:sm:text-right',
            $errors->has($attributes->get('for')) ? 'text-red-600' : '',
            ])->merge($attributes->whereDoesntStartWith('class')->getAttributes()) }}
    >
        {{ $slot }}
    </label>

    @if (isset($hint))
        <div class="hidden sm:block ml-auto rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 mr-1">{{ $hint }}</div>
    @endif
</div>
