<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Recurring;
use Auth;
use DB;

class BillController extends Controller {

  // Test function
  public function testfunction(Request $request) {
    if ( $request->isMethod('post') ) {
      return response()->json(['response' => 'This is post method']);
    }

    return response()->json(['response' => 'This is get method']);
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
        ->orderBy('duedate', 'asc')
        ->where('userid', Auth::user()->id)
        ->get();

    return $bills;
  }
}
