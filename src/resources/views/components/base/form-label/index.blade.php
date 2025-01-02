@aware(['class' => null])

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
