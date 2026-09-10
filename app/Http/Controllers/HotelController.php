<?php

namespace App\Http\Controllers;

use App\Support\HotelDetails;
use App\Support\HotelOrder;
use App\Support\Hotels;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HotelController extends Controller
{
    /**
     * Hotel listing — Figma node 1:946.
     */
    public function index(Request $request): View
    {
        return view('pages.hotels', [
            'hotels' => $this->paginateCollection(Hotels::all(), $request),
        ]);
    }

    /**
     * Hotel detail — Figma node 1:1694.
     */
    public function show(string $hotel): View
    {
        return view('pages.hotel-detail', ['hotel' => HotelDetails::find($hotel)]);
    }

    /**
     * Order summary — Figma node 1:3024.
     */
    public function order(string $hotel): View
    {
        return view('pages.hotel-order', ['order' => HotelOrder::draft($hotel)]);
    }
}
