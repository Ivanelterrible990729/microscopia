@aware(['dark' => null, 'bordered' => null, 'sm' => null, 'for' => null])

<td
    data-tw-merge
    {{ $attributes->class(
            merge([
                'flex flex-col sm:table-cell px-5 py-3 border-b dark:border-darkmode-300',
                $dark ? 'border-slate-600 dark:border-darkmode-300' : null,
                $bordered ? 'border-l border-r border-t' : null,
                $sm ? 'px-4 py-2' : null,
            ]),
        )->merge($attributes->whereDoesntStartWith('class')->getAttributes()) }}
>
    @if (isset($for))
        <span class="text-gray-500 dark:text-gray-400 font-medium uppercase mb-2 sm:hidden">{{ $for }}</span>
    @endif
    {{ $slot }}
</td>
