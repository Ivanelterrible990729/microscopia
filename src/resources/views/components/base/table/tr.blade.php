@aware(['hover' => null, 'striped' => null])

<tr
    data-tw-merge
    {{ $attributes->class(
            merge([
                'border border-b-2 sm:border-b-0',
                $hover
                    ? '[&:hover_td]:bg-slate-100 [&:hover_td]:dark:bg-darkmode-300 [&:hover_td]:dark:bg-opacity-50'
                    : null,
                $striped
                    ? '[&:nth-of-type(odd)_td]:bg-slate-100 [&:nth-of-type(odd)_td]:dark:bg-darkmode-300 [&:nth-of-type(odd)_td]:dark:bg-opacity-50'
                    : null,
            ]),
        )->merge($attributes->whereDoesntStartWith('class')->getAttributes()) }}
>
    {{ $slot }}
</tr>
