<?php

namespace App\Http\Controllers;

use App\Support\BoatDetails;
use App\Support\BoatOrder;
use App\Support\BoatOperators;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BoatOperatorController extends Controller
{
    /**
     * Boat Operators listing — Figma node 1:408.
     */
    public function index(Request $request): View
    {
        return view('pages.boats', [
            'operators' => $this->paginateCollection(BoatOperators::all(), $request),
        ]);
    }

    /**
     * Boat detail — Figma node 1:1179.
     */
    public function show(string $boat): View
    {
        return view('pages.boat-detail', ['boat' => BoatDetails::find($boat)]);
    }

    /**
     * Order summary — Figma node 1:1923.
     */
    public function order(string $boat): View
    {
        return view('pages.boat-order', ['order' => BoatOrder::draft($boat)]);
    }
}
