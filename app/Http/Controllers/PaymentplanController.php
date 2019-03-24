<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use App\Recurring;
use Auth;
use DB;
use Response;

class PaymentplanController extends Controller {

  // Add payment plan
  public function addSubscription(Request $request) {

    // Define stuff that we will add to the database
    DB::table('paymentplans')
    ->insert([
      'userid' => Auth::id(),
      'name' => $request->name,
      'months_paid' => $request->months_paid,
      'months_total' => $request->$months_total,
      'created' => date('Y-m-d H:i:s'),
    ]);
  }

}
