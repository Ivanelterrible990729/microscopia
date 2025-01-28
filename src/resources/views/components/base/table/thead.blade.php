@props(['variant' => null])

<thead
    data-tw-merge
    {{ $attributes->class(
            merge([
                $variant === 'light' ? 'bg-slate-200/60 dark:bg-slate-200 hidden sm:table-header-group' : null,
                $variant === 'dark' ? 'bg-dark text-white dark:bg-black/30 hidden sm:table-header-group' : null,
            ]),
        )->merge($attributes->whereDoesntStartWith('class')->getAttributes()) }}
>
    {{ $slot }}
</thead>
