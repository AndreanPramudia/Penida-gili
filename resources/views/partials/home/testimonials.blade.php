{{-- Figma node 1:56 — "Testimonials from Our Guests" --}}

<section class="container-page pt-[80px] lg:pt-[191px] pb-[41px] lg:pb-[97px]">
    @include('partials.section-heading', [
        'eyebrow' => 'Testimonials',
        'title'   => 'Testimonials from Our Guests',
        'intro'   => 'Discover what makes Boat Booking unforgettable. Our guests share their experiences aboard our Boats.',
    ])

    <div class="mt-[43px] grid [&>*]:min-w-0 gap-[46px] lg:grid-cols-3">
        @foreach ($testimonials as $index => $testimonial)
            <figure data-reveal style="--reveal-delay: {{ $index * 90 }}ms"
                    class="flex h-[220px] lg:h-[350px] w-full max-w-[476px] flex-col rounded-card border-2 border-line-card bg-surface p-[58px] shadow-card
                           transition-[transform,box-shadow] duration-500 ease-smooth hover:-translate-y-2 hover:shadow-card-hover">
                <img src="{{ asset('images/icons/stars-5.svg') }}" alt="5 out of 5 stars" class="h-[24.5px] w-[166px]">
                <blockquote class="mt-[31px] max-w-[353px] text-[16px] leading-[30px] text-ink-muted">
                    {{ trim($testimonial['quote'], '\"') }}
                </blockquote>
                <figcaption class="mt-auto">
                    <p class="text-[20px] leading-[41px] text-ink">{{ $testimonial['name'] }}</p>
                    <p class="text-[16px] leading-[30px] text-ink-muted">{{ $testimonial->experienceLabel('Traveled') ?? 'Verified guest' }}</p>
                </figcaption>
            </figure>
        @endforeach

        <div data-reveal style="--reveal-delay: 180ms"
             class="group h-[220px] lg:h-[350px] w-full max-w-[476px] overflow-hidden rounded-card">
            <img src="{{ asset('images/home/testimonial.png') }}" alt="Guests aboard a fast boat"
                 class="size-full object-cover transition-transform duration-700 ease-smooth group-hover:scale-105">
        </div>
    </div>
</section>
