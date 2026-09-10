<?php

namespace App\Http\Controllers;

use App\Support\BoatOperators;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Landing page — Figma node 1:55.
     */
    public function index(): View
    {
        return view('pages.home', [
            'operators' => BoatOperators::all()->take(3),
        ]);
    }
}
