{{-- Thumbnails of the images already attached to a catalogue record. --}}
@props(['items' => [], 'folder', 'cover' => null])

@if ($cover || $items)
    <div class="mt-[20px] grid [&>*]:min-w-0 gap-[16px] sm:grid-cols-3">
        @if ($cover)
            <figure class="relative overflow-hidden rounded-[10px]">
                <img src="{{ \App\Support\ImagePath::url($cover, $folder) }}" alt="" class="h-[120px] w-full object-cover">
                <figcaption class="absolute left-[8px] top-[8px] rounded-[6px] bg-editorial px-[8px] py-[3px] font-jakarta text-[11px] font-semibold text-white">Cover</figcaption>
            </figure>
        @endif
        @foreach ($items as $photo)
            <figure class="overflow-hidden rounded-[10px]">
                <img src="{{ \App\Support\ImagePath::url($photo['image'] ?? $photo, $folder.'/detail') }}" alt="{{ $photo['alt'] ?? '' }}" class="h-[120px] w-full object-cover">
            </figure>
        @endforeach
    </div>
@endif
