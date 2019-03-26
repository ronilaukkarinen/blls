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

  // Edit credit card
  public function editCreditcard(Request $request) {

    // Define stuff that we will add to the database
    DB::table('creditcards')
    ->where('id', $request->id)
    ->update([
      'expirationdate' => $request->expirationdate,
      'lastfourdigits' => $request->lastfourdigits,
      'monthlyamount' => $request->monthlyamount,
      'amount_paid' => $request->creditcard_amount_paid,
      'amount_total' => $request->creditcard_amount_total,
    ]);

    // Percents and colors
    $percent = round( ( $request->creditcard_amount_paid / $request->creditcard_amount_total ) * 100 );

    if ( $percent < 40 ) :
      $percent_class = ' low';
    elseif ( $percent > 40 && $percent < 60 ) :
      $percent_class = ' medium';
    elseif ( $percent > 40 && $percent > 60 ) :
      $percent_class = ' high';
    endif;

    // Print results
    echo '<div class="item item-creditcard" data-id="' . $request->id . '">
      <div class="col col-creditcard">

      <div class="credit-card credit-card-' . trim( preg_replace( '/[^a-z0-9-]+/', '-', strtolower( $request->creditor ) ), '-') . '">
        <h3 class="name-on-card">' . Auth::user()->name . '</h3>
        <div class="numbers">
          <span><b>●●●●</b> <b>●●●●</b> <b>●●●●</b></span> ' . $request->lastfourdigits . '
        </div>
        <div class="expiration-date">
          ' . $request->expirationdate . '
        </div>
      </div>
    </div>

    <div class="col col-details">
      <div class="details">
        <h2 class="title-larger creditor">' . $request->creditor . '</h2>
        <h3 class="title-small">' . __('dashboard.monthlycut') . '</h3>
        <p class="monthly-cut"><span class="amount">&euro; <span class="formatted-amount">' . str_replace( '.', ',', $request->monthlyamount ) . '</span></span> / ' . __('dashboard.permonth') . '</p>

        <div class="progress-bar">
          <div class="progress' . $percent_class . '" style="width: ' . $percent . '%;">
            <p>' . $request->creditcard_amount_paid . ' ' . __('dashboard.paidoftotal') . ' ' . $request->creditcard_amount_total . ' ' . __('dashboard.wholecredit') . '. (' . $percent . '%)</p>
          </div>
        </div>
      </div>
    </div>

  </div>';
  }

  // Remove credit card
  public function removeCreditcard(Request $request) {
    DB::table('creditcards')
    ->where('userid', Auth::user()->id)
    ->where('id', $request->id)
    ->delete();
  }

}
