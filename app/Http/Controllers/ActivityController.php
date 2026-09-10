<?php

namespace App\Http\Controllers;

use App\Support\Activities;
use App\Support\ActivityDetails;
use App\Support\ActivityOrder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    /**
     * Activity listing — Figma node 1:623.
     */
    public function index(Request $request): View
    {
        return view('pages.activities', [
            'activities' => $this->paginateCollection(Activities::all(), $request),
        ]);
    }

    /**
     * Activity detail — Figma node 1:1442.
     */
    public function show(string $activity): View
    {
        return view('pages.activity-detail', ['activity' => ActivityDetails::find($activity)]);
    }

    /**
     * Order summary — Figma node 1:2874.
     */
    public function order(string $activity): View
    {
        return view('pages.activity-order', ['order' => ActivityOrder::draft($activity)]);
    }
}
