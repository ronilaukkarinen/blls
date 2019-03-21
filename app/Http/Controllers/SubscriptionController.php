<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use App\Recurring;
use Auth;
use DB;
use Response;

class SubscriptionController extends Controller {

  // Add subscription
  public function addSubscription(Request $request) {

    // Let's format the date
    $date_to_db = date( 'Y-m-d H:i:s', strtotime( $request->date ) );

    // Define stuff that we will add to the database
    DB::table('subscriptions')
    ->insert([
      'biller' => $request->biller,
      'amount' => $request->amount,
      'date' => $date_to_db,
      'created' => date('Y-m-d H:i:s'),
      'active' => 1,
      'userid' => Auth::id(),
    ]);

    /// Variables
    $old_date = $request->date;
    $old_date_timestamp = strtotime( $old_date );
    $formatted_date = date( 'd.m.Y', $old_date_timestamp );
    $stylish_date = date( 'd/m/Y', $old_date_timestamp );
    setlocale( LC_TIME, "fi_FI" );
    $formatted_amount = str_replace( '.', ',', $sub->amount );
    $biller = strtolower( $sub->biller );

    // Print results
    echo '<div class="item item-' . $biller . '">
    <div class="logo">
      ' . file_get_contents( "svg/subscriptions/{$biller}.svg" ) . '

        <div class="details">
          <span class="biller">' . $request->biller . '</span><br />
          <span class="type">Subscription</span>
        </div>
      </div>

      <div class="content">
        <ul>
          <li class="amount"><span class="value">€ ' . $request->amount . '</span></li>
          <li class="due-date"><span class="value">' . $stylish_date . '</span></li>
        </ul>
      </div>
    </div>';
  }

}
