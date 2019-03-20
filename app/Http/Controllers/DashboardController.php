<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Recurring;
use Auth;
use Bills;
use DB;

class DashboardController extends Controller {
  public function __invoke() {
    return view('dashboard');
  }

  // Get total amount of bills that are not paid
  public function totalAmount() {

    $balance = DB::table('bills')
        ->where('userid', Auth::user()->id)
        ->where('paid', '0')
        ->sum('amount');

    return view( 'dashboard' )->with( 'balance', $balance );
  }

  // List bills
  public function getBills() {

    $bills = DB::table('bills')
        ->orderByRaw('duedate ASC')
        ->where('userid', Auth::user()->id)
        ->get();

    return view( 'dashboard', [ 'bills' => $bills ] );
  }
}
