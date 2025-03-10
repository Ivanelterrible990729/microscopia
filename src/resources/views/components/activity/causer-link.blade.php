<div>
    <{{ $tag }}
        @if(isset($route)) href="{{ $route }}" @endif
        @class(['', 'text-blue-700 hover:text-blue-500 dark:text-blue-500 dark:hover:text-blue-700 underline' => $tag === 'a'])
    >
        {{ $value }}
    </{{ $tag }}>
</div>
