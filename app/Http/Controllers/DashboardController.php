<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Recurring;
use Auth;
use DB;

class DashboardController extends Controller {
    public function __invoke() {
        $space_id = session('space')->id;
        $currentYear = date('Y');
        $currentMonth = date('m');
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

        $recurrings = session('space')->monthlyRecurrings($currentYear, $currentMonth);


        return view('dashboard', [
            'month' => date('n'),
            'recurrings' => $recurrings,
        ]);
    }
}
