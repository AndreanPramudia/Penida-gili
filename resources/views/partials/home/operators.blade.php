{{-- Figma nodes 1:86 / 1:87 — "Top Boat Operators" (reuses the boat-card component) --}}
<section class="container-page pt-[67px] lg:pt-[160px]">
    @include('partials.section-heading', [
        'eyebrow' => 'Top Boat Operators',
        'title'   => 'Top Boat <br> Operators',
        'intro'   => "Explore Indonesia's leading boat operators and their premium vessel fleets. Choose from trusted companies offering fast boats, ferries, and luxury vessels with the best prices, safety standards, and customer service for your island adventures.",
    ])

    <div class="mt-[28px] lg:mt-[66px] grid [&>*]:min-w-0 justify-items-center gap-x-[52px] gap-y-[71px] sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($operators as $index => $operator)
            @include('components.boat-card', [
                'delay'       => $index * 90,
                'name'        => $operator['name'],
                'description' => $operator['description'],
                'rating'      => $operator['rating'],
                'image'       => $operator['image_url'],
                'routes'      => $operator['schedules_count'],
                'vessels'     => $operator['vessels_count'],
                'href'        => route('boats.show', $operator),
            ])
        @endforeach
    </div>
</section>
