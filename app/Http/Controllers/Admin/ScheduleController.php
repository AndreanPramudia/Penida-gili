<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ListingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreScheduleRequest;
use App\Models\BoatOperator;
use App\Models\Port;
use App\Models\Schedule;
use App\Models\Vessel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    /** Schedule listing — Figma node 1:9017. */
    public function index(Request $request): View
    {
        $schedules = Schedule::query()
            ->with(['operator', 'vessel', 'fromPort', 'toPort'])
            ->when($request->filled('q'), fn ($q) => $q->betweenPorts($request->string('q')->value(), null)
                ->orWhereHas('toPort', fn ($p) => $p->where('name', 'like', '%'.$request->string('q').'%')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->value()))
            ->orderBy('departure_time')
            ->paginate(10)
            ->withQueryString();

        return view('admin.schedules', ['schedules' => $schedules, 'filters' => $request->only(['q', 'status'])]);
    }

    /** Add New Schedule — Figma node 1:7269. */
    public function create(): View
    {
        return $this->form(new Schedule(['status' => ListingStatus::Draft]));
    }

    public function store(StoreScheduleRequest $request): RedirectResponse
    {
        $schedule = Schedule::query()->create($request->payload());

        return redirect()->route('admin.schedules')->with('flash', 'Schedule '.$schedule->route_label.' saved.');
    }

    public function edit(Schedule $schedule): View
    {
        return $this->form($schedule);
    }

    public function update(StoreScheduleRequest $request, Schedule $schedule): RedirectResponse
    {
        $schedule->update($request->payload());

        return redirect()->route('admin.schedules')->with('flash', 'Schedule '.$schedule->route_label.' updated.');
    }

    public function destroy(Schedule $schedule): RedirectResponse
    {
        $schedule->delete();

        return redirect()->route('admin.schedules')->with('flash', 'Schedule removed.');
    }

    private function form(Schedule $schedule): View
    {
        return view('admin.schedules-create', [
            'schedule' => $schedule,
            'operators' => BoatOperator::query()->orderBy('name')->pluck('name', 'id'),
            'vessels' => Vessel::query()->with('operator')->orderBy('name')->get(),
            'ports' => Port::query()->orderBy('name')->pluck('name', 'id'),
            'days' => Schedule::DAYS,
        ]);
    }
}
