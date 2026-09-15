<?php

namespace App\Http\Controllers;

use App\Models\BoatOperator;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Landing page — Figma node 1:55 (desktop) / 1:2386 (mobile).
     */
    public function index(): View
    {
        return view('pages.home', [
            'operators' => BoatOperator::query()
                ->active()
                ->withCount(['schedules', 'vessels'])
                ->orderByDesc('rating')
                ->take(3)
                ->get(),
        ]);
    }
}
