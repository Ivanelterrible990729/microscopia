<div>
    <div class="flex flex-col sm:flex-row items-center gap-2" {{ $attributes }}>
        @forelse ($labels as $label)
            <span class="mt-2 flex items-center border rounded-md px-2 py-1 w-min">
                <div class="mr-3 h-2 w-2 p-1 rounded-full text-xs" style="background-color: {{ $label['color'] }};"></div>
                <span>{{ $label['name'] }}</span>
            </span>
        @empty
            <span class="mt-2 flex items-center border rounded-md px-3 py-2">
                <span>{{ __('Unlabeled') }}</span>
            </span>
        @endforelse

        {{ $slot }}
    </div>
</div>


