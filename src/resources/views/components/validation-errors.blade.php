@if ($errors->any())
    <x-base.alert {{ $attributes }} variant="soft-danger">
        <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

            @if (isset($slot))
                {{ $slot }}
            @endif
        </ul>
    </x-base.alert>
@endif
