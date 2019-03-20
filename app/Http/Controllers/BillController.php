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

  // List bills
  public function getBills() {

    $bills = DB::table('bills')
        ->orderBy('duedate', 'asc')
        ->where('userid', Auth::user()->id)
        ->get();

    return $bills;
  }
}
