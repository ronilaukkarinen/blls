<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Bills;
use DB;

class PaidController extends Controller {
  public function __invoke() {
    return view('paid');
  }

  public function showPaid() {

    $balance = DB::table('bills')
    ->where('userid', Auth::user()->id)
    ->where('paid', '1')
    ->sum('amount');

    $bills = DB::table('bills')
    ->orderBy('datepaid', 'desc')
    ->where('userid', Auth::user()->id)
    ->where('paid', '1')
    ->get();

    $paymentplans = DB::table('paymentplans')
    ->where('userid', Auth::user()->id)
    ->where('paid', '1')
    ->get();

    return view( 'paid', compact( 'balance', 'bills', 'paymentplans' ) );
  }
}
