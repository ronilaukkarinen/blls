<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use App\Recurring;
use Auth;
use DB;
use Response;

class CreditcardController extends Controller {

  // Add payment plan
  public function addCreditcard(Request $request) {

    // Define stuff that we will add to the database
    DB::table('creditcards')
    ->insert([
      'userid' => Auth::id(),
      'creditor' => $request->creditor,
      'lastfourdigits' => $request->lastfourdigits,
      'amount_paid' => $request->creditcard_amount_paid,
      'amount_total' => $request->creditcard_amount_total,
      'created' => date('Y-m-d H:i:s'),
      'paid' => 0,
    ]);

    // Percents and colors
    $percent = round( ( $request->creditcard_amount_paid / $request->creditcard_amount_total ) * 100 );

    if ( $percent < 40 ) :
      $percent_class = ' low';
    elseif ( $percent > 40 ) :
      $percent_class = ' medium';
    else :
      $percent_class = ' high';
    endif;

    // Print results
    echo '<div class="items items-playmentplans">

    <div class="item">
    <h2>' . $request->creditcard_name . '</h2>

    <div class="progress-bar">
      <div class="progress' . $percent_class . '" style="width: ' . $percent . '%;">
      <p>' . $request->creditcard_amount_paid . ' paid of total ' . $request->creditcard_amount_total . ' rounds. (' . $percent . '%)</p>
      </div>
    </div>
    </div>';
  }

  // Edit payment plan
  public function editCreditcard(Request $request) {

    // Define stuff that we will add to the database
    DB::table('creditcards')
    ->where('userid', Auth::user()->id)
    ->where('id', $request->id)
    ->update([
      'name' => $request->creditcard_name,
      'amount_paid' => $request->creditcard_amount_paid,
      'amount_total' => $request->creditcard_amount_total,
      'paid' => 0,
    ]);

    // Percents and colors
    $percent = round( ( $request->creditcard_amount_paid / $request->creditcard_amount_total ) * 100 );

    if ( $percent < 40 ) :
      $percent_class = ' low';
    elseif ( $percent > 40 ) :
      $percent_class = ' medium';
    else :
      $percent_class = ' high';
    endif;

    // Print results
    echo '<div class="items items-playmentplans">

    <div class="item item-' . $request->id . '" data-id="' . $request->id . '">
    <h2>' . $request->creditcard_name . '</h2>

    <div class="progress-bar">
      <div class="progress' . $percent_class . '" style="width: ' . $percent . '%;">
      <p>' . $request->creditcard_amount_paid . ' paid of total ' . $request->creditcard_amount_total . ' rounds. (' . $percent . '%)</p>
      </div>
    </div>
    </div>';
  }

  // Remove payment plan
  public function removeCreditcard(Request $request) {
    DB::table('creditcards')
    ->where('userid', Auth::user()->id)
    ->where('id', $request->id)
    ->delete();
  }

  // Mark as paid
  public function markaCreditcardasPaid(Request $request) {

    // Update the bill in question
    DB::table('creditcards')
      ->where('userid', Auth::user()->id)
      ->where('id', $request->id)
      ->where('paid', '0')
      ->update([
        'paid' => 1,
        'datepaid' => date('Y-m-d H:i:s')
    ]);
  }

  // Mark as unpaid
  public function markaCreditcardasunPaid(Request $request) {

    // Update the bill in question
    DB::table('creditcards')
      ->where('userid', Auth::user()->id)
      ->where('id', $request->id)
      ->where('paid', '1')
      ->update([
        'paid' => 0,
    ]);
  }

}
