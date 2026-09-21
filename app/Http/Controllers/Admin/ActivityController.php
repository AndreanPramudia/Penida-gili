<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ListingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreActivityRequest;
use App\Models\Activity;
use App\Models\Schedule;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public const CATEGORIES = ['Photography', 'Cultural Show', 'Wildlife & Nature', 'Water Sports', 'Adventure'];

    /** Activity listing — Figma node 1:9970. */
    public function index(Request $request): View
    {
        $activities = Activity::query()
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->value()))
            ->orderByDesc('sold_count')
            ->paginate(10)
            ->withQueryString();

        return view('admin.activities', ['activities' => $activities, 'filters' => $request->only(['q', 'status'])]);
    }

    /** Add New Activity — Figma node 1:8502. */
    public function create(): View
    {
        return $this->form(new Activity(['status' => ListingStatus::Active, 'opens_at' => '08:00', 'closes_at' => '18:00']));
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        $activity = Activity::query()->create($this->payload($request));

        return redirect()->route('admin.activities')->with('flash', "{$activity->name} created.");
    }

    public function edit(Activity $activity): View
    {
        return $this->form($activity);
    }

    public function update(StoreActivityRequest $request, Activity $activity): RedirectResponse
    {
        $activity->update($this->payload($request, $activity));

        return redirect()->route('admin.activities')->with('flash', "{$activity->name} updated.");
    }

    /** Clone a listing as a draft so the admin can adjust the copy before publishing. */
    public function duplicate(Activity $activity): RedirectResponse
    {
        $copy = $activity->replicate(['slug', 'sold_count', 'review_count', 'rating']);
        $copy->name = $activity->name.' (Copy)';
        $copy->status = ListingStatus::Draft;
        $copy->save();

        return redirect()->route('admin.activities.edit', $copy)->with('flash', "{$activity->name} duplicated as a draft.");
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete();

        return redirect()->route('admin.activities')->with('flash', "{$activity->name} removed.");
    }

    private function form(Activity $activity): View
    {
        return view('admin.activities-create', [
            'activity' => $activity,
            'days' => Schedule::DAYS,
            'categories' => self::CATEGORIES,
            'statuses' => [
                ['value' => ListingStatus::Active->value, 'label' => 'Active / Published', 'description' => 'Visible & bookable immediately'],
                ['value' => ListingStatus::Draft->value, 'label' => 'Draft', 'description' => 'Save work without releasing'],
                ['value' => ListingStatus::Inactive->value, 'label' => 'Inactive', 'description' => 'Hidden from the catalogue'],
            ],
        ]);
    }

    /** @return array<string, mixed> */
    private function payload(StoreActivityRequest $request, ?Activity $existing = null): array
    {
        $data = $request->safe()->except(['cover', 'gallery', 'included', 'excluded']);
        $data['included'] = $this->lines($request->input('included'));
        $data['excluded'] = $this->lines($request->input('excluded'));
        $data['days'] = $request->input('days') ?: null;
        $data['price_child'] = $data['price_child'] ?? 0;

        if ($cover = Uploads::store($request->file('cover'), 'activities')) {
            $data['image'] = $cover;
        } elseif (! $existing) {
            $data['image'] = 'costume-penglipuran.png';
        }

        if ($gallery = Uploads::gallery($request->file('gallery'), 'activities', $request->string('name')->value())) {
            $data['gallery'] = $gallery;
        }

        return $data;
    }

    /** @return list<string> */
    private function lines(?string $text): array
    {
        return collect(preg_split('/\R/', (string) $text))->map('trim')->filter()->values()->all();
    }
}
