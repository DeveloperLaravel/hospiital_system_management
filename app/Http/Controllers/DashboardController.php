<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function __invoke()
    {
        $stats = $this->dashboardService->getStats();

        return view('dashboard', $stats);
    }
}
