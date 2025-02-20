<div>
    <div {{ $attributes }}>
        @forelse ($labels as $label)
            <span class="flex items-center">
                <div class="mr-3 h-2 w-2 p-1 rounded-full text-xs" style="background-color: {{ $label['color'] }};"></div>
                <span>{{ $label['name'] }}</span>
            </span>
        @empty
            <span class="mt-2 flex items-center border rounded-md px-3 py-2">
                <span>{{ __('Unlabeled') }}</span>
            </span>
        @endforelse
    </div>

    {{ $slot }}
</div>


