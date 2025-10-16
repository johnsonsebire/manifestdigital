<?php

namespace App\Http\Controllers;

use App\Traits\HasRoleBasedDashboard;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use HasRoleBasedDashboard;

    /**
     * Display the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $dashboardData = $this->getDashboardData();

        return view('dashboard', $dashboardData);
    }
}
