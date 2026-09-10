<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminDashboard;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Admin dashboard — Figma node 1:6642.
     */
    public function index(): View
    {
        return view('admin.dashboard', [
            'kpis' => AdminDashboard::kpis(),
            'vessels' => AdminDashboard::vessels(),
            'transactions' => AdminDashboard::transactions(),
            'transactionsSummary' => 'Showing 1 to 3 of 124 entries',
        ]);
    }
}
