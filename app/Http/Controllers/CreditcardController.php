<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use App\Recurring;
use Auth;
use DB;
use Response;

class CreditcardController extends Controller {

  // Add credit card
  public function addCreditcard(Request $request) {

    // Define stuff that we will add to the database
    DB::table('creditcards')
    ->insert([
      'userid' => Auth::id(),
      'creditor' => $request->creditor,
      'expirationdate' => $request->expirationdate,
      'lastfourdigits' => $request->lastfourdigits,
      'monthlyamount' => $request->monthlyamount,
      'amount_paid' => $request->creditcard_amount_paid,
      'amount_total' => $request->creditcard_amount_total,
      'created' => date('Y-m-d H:i:s'),
    ]);
  }

}
