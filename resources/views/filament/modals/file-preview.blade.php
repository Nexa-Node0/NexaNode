<div class="space-y-4">
    {{-- Preview --}}
    @if (str_starts_with($record->mime_type, 'image/'))
        <img src="{{ $url }}" class="w-1/2 mx-auto rounded-lg" title="{{ $record->original_name }}" />
    @elseif(str_starts_with($record->mime_type, 'video/'))
        <video controls class="w-full" title="{{ $record->description }}">
            <source src="{{ $url }}">
        </video>
    @else
        <p class="text-sm text-gray-500">
            Preview not available for this file type.
        </p>
    @endif

    {{-- Title --}}
    <div class="text-sm font-semibold">
        {{ $record->title ?? $record->original_name }}
    </div>

    {{-- Description --}}
    @if ($record->description)
        <div class="text-xs text-center text-gray-500">
            {{ $record->description }}
        </div>
    @endif
</div>
