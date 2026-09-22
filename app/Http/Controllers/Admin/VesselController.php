<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ListingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreVesselRequest;
use App\Models\BoatOperator;
use App\Models\Vessel;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VesselController extends Controller
{
    public const FACILITIES = ['Air Conditioning', 'Toilet', 'Life Jackets', 'Insurance', 'Sound System', 'Free Water'];

    /** Boat listing — Figma node 1:6901. */
    public function index(Request $request): View
    {
        $vessels = Vessel::query()
            ->with('operator')
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($w) => $w
                ->where('name', 'like', '%'.$request->string('q').'%')
                ->orWhere('code', 'like', '%'.$request->string('q').'%')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->value()))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.boats', ['boats' => $vessels, 'filters' => $request->only(['q', 'status'])]);
    }

    /** Add New Boat — Figma node 1:7132. */
    public function create(): View
    {
        return $this->form(new Vessel(['status' => ListingStatus::Active, 'facilities' => ['Air Conditioning', 'Toilet', 'Life Jackets', 'Insurance']]));
    }

    public function store(StoreVesselRequest $request): RedirectResponse
    {
        // The Figma form has no operator picker: the fleet belongs to the (single) operator on file.
        $vessel = Vessel::query()->create($this->payload($request) + [
            'code' => $request->input('code') ?: Vessel::nextCode(),
            'boat_operator_id' => $request->input('boat_operator_id') ?: BoatOperator::query()->orderBy('id')->value('id'),
        ]);

        return redirect()->route('admin.boats')->with('flash', "{$vessel->name} added to the fleet.");
    }

    public function edit(Vessel $vessel): View
    {
        return $this->form($vessel);
    }

    public function update(StoreVesselRequest $request, Vessel $vessel): RedirectResponse
    {
        $vessel->update($this->payload($request) + array_filter(['code' => $request->input('code')]));

        return redirect()->route('admin.boats')->with('flash', "{$vessel->name} updated.");
    }

    public function destroy(Vessel $vessel): RedirectResponse
    {
        $vessel->delete();

        return redirect()->route('admin.boats')->with('flash', "{$vessel->name} removed.");
    }

    private function form(Vessel $vessel): View
    {
        return view('admin.boats-create', [
            'vessel' => $vessel,
            'facilities' => collect(self::FACILITIES)->map(fn ($label) => [
                'label' => $label,
                'checked' => in_array($label, old('facilities', $vessel->facilities ?? []), true),
            ])->all(),
            'types' => ['Catamaran Fast Ferry', 'Mono-hull Fastboat', 'Luxury Catamaran'],
            'publishModes' => [
                ['value' => 'publish', 'label' => 'Publish Immediately', 'description' => 'Visible in the fleet and available for schedules right away'],
                ['value' => 'draft', 'label' => 'Save as Draft', 'description' => 'Keep the boat hidden until you are ready'],
            ],
            'operationalStatuses' => [
                ListingStatus::Active->value => 'Active (Ready for Routes)',
                ListingStatus::Inactive->value => 'Non-Active (Maintenance)',
            ],
        ]);
    }

    /** @return array<string, mixed> */
    private function payload(StoreVesselRequest $request): array
    {
        $data = $request->safe()->except(['photos', 'code', 'publish']);
        $data['facilities'] = $request->input('facilities', []);

        // "Save as Draft" hides the boat regardless of the operational status picked below it.
        $data['status'] = $request->input('publish') === 'draft'
            ? ListingStatus::Draft->value
            : $request->input('status', ListingStatus::Active->value);

        if ($photo = Uploads::store($request->file('photos.0'), 'vessels')) {
            $data['image'] = $photo;
        }

        return $data;
    }
}
